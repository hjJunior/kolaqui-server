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
  
  protected $replies;
  protected $attemptId;
  
  public function __construct($attributes = []) {
    $this->replies = $attributes["replies"];
    $this->attemptId = $attributes["attemptId"];
  }
  
  public function handle() {
    foreach ($this->replies as $reply) {
      $this->handleReply($reply);
    }
  }

  private function handleReply($replyInput) {
    $question = Question::where('slug', $replyInput['questionId'])->first();
    $answer = Answer::where('slug', $replyInput['answerId'])->first();
    $isCorrect = $replyInput['isCorrect'];

    return $this->createReply($question, $answer, $isCorrect);
  }

  private function createReply($question, $answer, $isCorrect) {
    $reply = Reply::firstOrCreate([
      'attempt_id' => $this->attemptId,
      'question_id' => $question->id,
      'answer_id' => $answer->id,
    ], [
      'correct' => $isCorrect,
    ]);

    $reply->save();
  }
}
