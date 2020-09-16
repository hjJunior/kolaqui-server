<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\CreateQuestion;
use App\Question;

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
    $this->assertAnswers($question);
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
    $this->assertAnswers($question);
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

  private function assertAnswers($question) {
    $answers = $question->answers()->get()->toArray();
    $this->assertEquals($answers[0]['slug'], $this->base_args['answers'][0]['slug']);
    $this->assertEquals($answers[0]['content'], $this->base_args['answers'][0]['content']);
    $this->assertEquals($answers[0]['pure_content'], strip_tags($this->base_args['answers'][0]['content']));
    $this->assertEquals($answers[1]['slug'], $this->base_args['answers'][1]['slug']);
    $this->assertEquals($answers[1]['content'], $this->base_args['answers'][1]['content']);
    $this->assertEquals($answers[1]['pure_content'], strip_tags($this->base_args['answers'][1]['content']));
  }
}
