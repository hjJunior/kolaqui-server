<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\SubmitExameAttempt;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Question;
use App\Answer;
use App\Reply;

class SubmitExameAttemptTest extends TestCase {
  use RefreshDatabase;

  protected $base_args = [
    'attemptId' => 'attempt-1',
    'replies' => [
      [
        'answerId' => 'answer-slug-1',
        'isCorrect' => true,
        'questionId' => 'question-slug-1',
      ],
      [
        'answerId' => 'answer-slug-2',
        'isCorrect' => false,
        'questionId' => 'question-slug-2',
      ],
    ]
  ];

  public function setUp(): void {
    parent::setUp();

    foreach ($this->base_args['replies'] as $reply) {
      Question::factory()
        ->hasAnswers(1, [
          'slug' => $reply['answerId'],
        ])
        ->create(['slug' => $reply['questionId']]);
    }
  }

  public function test_it_creates_new_reply_for_each_answer() {    
    // Setup
    $job = new SubmitExameAttempt($this->base_args);
    $job->handle();

    // Assert
    $this->assertRegisters();
  }

  public function test_it_ignore_when_already_exists() {
    // Setup
    $job = new SubmitExameAttempt($this->base_args);
    $job->handle();
    $job->handle();

    // Assert
    $this->assertRegisters();
  }

  public function test_it_when_not_exists_the_first_question() {
    // Setup
    $new_args = $this->base_args;
    $new_args['replies'][0]['questionId'] = 'this-not-exists';
    $job = new SubmitExameAttempt($new_args);

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Error while handling some replies');

    // Act
    $job->handle();

    $this->assertDatabaseCount('replies', 1);
  }

  private function assertRegisters() {
    $this->assertDatabaseCount('replies', 2);
    $replies = Reply::all();

    foreach ($replies as $index => $reply) {
      $replyInput = $this->base_args['replies'][$index];
      
      $this->assertEquals($reply->answer->slug, $replyInput['answerId']);
      $this->assertEquals($reply->question->slug, $replyInput['questionId']);
      $this->assertEquals($reply->correct, $replyInput['isCorrect']);
    }
  }
}
