<?php

namespace Database\Factories;

use App\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionFactory extends Factory {
  protected $model = Question::class;
  
  public function definition() {
    return [
      'slug' => $this->faker->uuid(),
      'content' => $this->faker->randomHtml(1, 2),
    ];
  }
}
