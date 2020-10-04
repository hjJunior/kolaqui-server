<?php

namespace Database\Factories;

use App\Answer;
use App\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnswerFactory extends Factory {
  protected $model = Answer::class;

  public function definition() {
    $content = $this->faker->randomHtml(1, 2);

    return [
      'checksum' => $this->faker->uuid(),
      'content' => $content,
      'pure_content' => strip_tags($content),
      'question_id' => Question::factory(),
    ];
  }
}
