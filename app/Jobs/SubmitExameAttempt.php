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
    $faileds = [];

    foreach ($this->replies as $reply) {
      // try {
        $this->handleReply($reply);
      // } catch (\Throwable $th) {
      //   $faileds[] = $th;
      // }
    }

    if (count($faileds) >= 1) {
      throw new \Exception('Error while handling some replies');
    }
  }

  private function handleReply($replyInput) {
    $question = Question::where('slug', $replyInput['questionId'])->first();
    $answer = Answer::where('checksum', $replyInput['answerId'])->first();
    $isCorrect = $replyInput['isCorrect'];

    return $this->createReply($question, $answer, $isCorrect);
  }

  private function createReply($question, $answer, $isCorrect) {
    $reply = Reply::firstOrCreate([
      'attempt_id' => $this->attemptId,
      'question_id' => $question != null ? $question->id : null,
      'answer_id' => $question != null ? $answer->id : null,
    ], [
      'correct' => $isCorrect,
    ]);

    $reply->save();
  }
}
