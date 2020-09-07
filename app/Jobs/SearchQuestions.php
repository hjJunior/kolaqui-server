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
    $this->search = $this->normalizeSearch($search);
  }
  
  public function handle() {
    return Question::search($this->search)
      ->take(5)
      ->get();
  }

  private function normalizeSearch($search) {
    return str_replace(['\\', '(', ')', '{', '}', '^'], '', $search);
  }
}
