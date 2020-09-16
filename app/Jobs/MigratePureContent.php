<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Question;
use App\Answer;

class MigratePureContent implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
  public function __construct(){
  }
  
  public function handle() {
    $this->migrateRegisters(Question::all());
    $this->migrateRegisters(Answer::all());
  }

  private function migrateRegisters($registers) {
    foreach($registers as $register) {
      $register->pure_content = strip_tags($register->content);
      $register->save();
    }
  }
}
