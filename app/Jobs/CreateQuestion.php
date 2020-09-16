<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Question;
use App\Answer;

class CreateQuestion implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $questionSlug;
  protected $questionHtml;
  protected $answers;
  
  public function __construct($attributes = []) {
    $this->questionSlug = $attributes['questionId'];
    $this->questionHtml = $attributes['questionHtml'];
    $this->answers = $attributes['answers'];
  }
  
  public function handle() {
    $question = $this->registerQuestion();

    foreach ($this->answers as $answer) {
      $this->registerAnswer($answer, $question->id);
    }
  }

  private function registerQuestion() {
    return Question::firstOrCreate([
      'slug' => $this->questionSlug
    ], [
      'content' => $this->questionHtml,
      'pure_content' => strip_tags($this->questionHtml),
    ]);
  }

  private function registerAnswer($attributes = [], $questionId) {
    $saveAttributes = array_merge($attributes, [
      'question_id' => $questionId,
      'pure_content' => strip_tags($attributes['content']),
    ]);

    return Answer::firstOrCreate($saveAttributes);
  }
}
