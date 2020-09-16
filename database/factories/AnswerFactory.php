<?php

namespace Database\Factories;

use App\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnswerFactory extends Factory {
  protected $model = Answer::class;
  
  public function definition() {
    return [
      'slug' => $this->faker->uuid(),
      'content' => $this->faker->randomHtml(1, 2),
    ];
  }
}
