<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Question;

class SearchQuestions implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
  public function __construct($search) {
    $this->search = $search;
  }
  
  public function handle() {
    return Question::search($this->search)->paginate();
      // ->whereIn('id', $this->questionsWithRepliesIds())
      // ->paginate();
  }

  private function questionsWithRepliesIds() {
    return Question::hasReplies()->pluck('id')->all();
  }

  private function normalizeSearch($search) {
    // return str_replace(['\\', '(', ')', '{', '}', '^'], '', $search);
  }
}
