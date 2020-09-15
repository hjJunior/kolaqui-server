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
  protected $attemptId;
  
  public function __construct($attributes = []) {
    $this->answers = $attributes["answers"];
    $this->attemptId = $attributes["attemptId"];
  }
  
  public function handle() {
    foreach ($this->answers as $answer) {
      $this->handleAnswer($answer);
    }
  }

  private function handleAnswer($answerInput) {
    $question = $this->getQuestion($answerInput['questionId'], $answerInput['questionHtml']);
    $answer = $this->getAnswer($answerInput['answerId'], $answerInput['answerHtml'], $question->id);
    $isCorrect = $answerInput['isCorrect'];
    return $this->createReply($question, $answer, $isCorrect);
  }

  private function createReply($question, $answer, $isCorrect) {
    $reply = Reply::firstOrCreate([
      'correct' => $isCorrect,
      'attempt_id' => $this->attemptId,
      'question_id' => $question->id,
      'answer_id' => $answer->id,
    ]);

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
