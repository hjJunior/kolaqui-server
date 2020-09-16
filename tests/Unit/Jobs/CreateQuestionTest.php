<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\CreateQuestion;
use App\Question;
use App\Answer;

class CreateQuestionTest extends TestCase {
  use RefreshDatabase;

  protected $base_args = [
    'questionId' => 'question-slug-1',
    'questionHtml' => '<p>Conteudo aqui</p>',
    'answers' => [
      [
        'slug' => 'answer-slug-1',
        'content' => '<b>html here</b>'
      ],
      [
        'slug' => 'answer-slug-2',
        'content' => '<b>html here</b>'
      ],
    ]
  ];

  public function test_creates_new_register_if_question_is_not_registered() {
    // Setup
    $job = new CreateQuestion($this->base_args);
    $job->handle();

    $question = Question::first();
    
    // Assert registers count
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseCount('answers', 2);

    // Assert database registers
    $this->assertEquals($question->slug, $this->base_args['questionId']);
    $this->assertEquals($question->content, $this->base_args['questionHtml']);
    $this->assertAnswers($question, $this->base_args);
  }

  public function test_not_create_new_register_if_question_is_registered() {
    // Setup
    $question = new Question([
      'slug' => 'question-slug-1',
      'content' => '<p>Conteudo aqui</p>',
      'pure_content' => 'Conteudo aqui'
    ]);
    $question->save();

    $job = new CreateQuestion($this->base_args);
    $job->handle();

    // Assert registers count
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseCount('answers', 2);

    // Assert database registers
    $this->assertAnswers($question, $this->base_args);
  }

  public function test_not_create_new_register_for_answer_if_is_registered() {
    $job = new CreateQuestion($this->base_args);
    $job->handle();

    // Assert registers count
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseCount('answers', 2);

    $job->handle();

    // Assert again
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseCount('answers', 2);
  }

  public function test_when_question_exists_but_not_all_requestions() {
    // Setup
    $answer = Answer::factory()->create();
    $args = $this->base_args;
    $args['questionId'] = $answer->question()->first()->slug;
    array_unshift($args['answers'], ['slug' => $answer->slug, 'content' => $answer->content]);

    // Assert
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseCount('answers', 1);

    // Act
    $job = new CreateQuestion($args);
    $job->handle();

    // Assert
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseCount('answers', 3);
    
    $this->assertAnswers($answer->question()->first(), $args);
  }

  private function assertAnswers($question, $args) {
    $answers = collect($question->answers()->get()->toArray())->all();

    foreach($answers as $index => $answer) {
      $this->assertEquals($answers[$index]['slug'], $args['answers'][$index]['slug']);
      $this->assertEquals($answers[$index]['content'], $args['answers'][$index]['content']);
      $this->assertEquals($answers[$index]['pure_content'], strip_tags($args['answers'][$index]['content']));
    }
  }
}
