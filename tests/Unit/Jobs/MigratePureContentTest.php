<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\SubmitExameAttempt;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Jobs\MigratePureContent;
use App\Question;
use App\Answer;

class MigratePureContentTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();

    Question::factory()->count(3)->create();
    Answer::factory()->count(3)->create();
  }

  public function test_if_it_updates_the_pure_content() {
    $job = new MigratePureContent;
    $job->handle();

    foreach (Question::all() as $question) {
      $this->assertEquals($question->pure_content, strip_tags($question->content));
    }

    foreach (Answer::all() as $question) {
      $this->assertEquals($question->pure_content, strip_tags($question->content));
    }
  }
}