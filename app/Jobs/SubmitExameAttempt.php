<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Question;
use App\Answer;
use App\Reply;

class SubmitExameAttempt implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
  protected $answers;
  
  public function __construct($answers) {
    $this->answers = $answers;
  }
  
  public function handle() {
    foreach ($this->answers as $answer) {
      $this->handleAnswer($answer);
    }
  }

  public function failed(Throwable $exception) {
    dump("Deu ruim");
    dump($exception);

    echo ("Deu ruimmmmm");
  }

  private function handleAnswer($answerInput) {
    $question = $this->getQuestion($answerInput['questionId'], $answerInput['questionHtml']);
    $answer = $this->getAnswer($answerInput['answerId'], $answerInput['answerHtml'], $question->id);

    return $this->createReply($question, $answer);
  }

  private function createReply($question, $answer) {
    $reply = new Reply;

    $reply->question()->associate($question);
    $reply->answer()->associate($answer);
    $reply->save();
  }

  private function getQuestion($questionSlug, $questionHtml) {
    return Question::firstOrCreate([
      'slug' => $questionSlug,
      'content' => $questionHtml
    ]);
  }

  private function getAnswer($answerSlug, $answerHtml, $questionId) {
    return Answer::firstOrCreate([
      'slug' => $answerSlug,
      'content' => $answerHtml,
      'question_id' => $questionId,
    ]);
  }
}
