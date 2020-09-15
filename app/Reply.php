<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
  protected $hidden = [
    'created_at', 'updated_at', 'question_id', 'answer_id'
  ];

  protected $fillable = [
    'correct', 'attempt_id', 'question_id', 'answer_id'
  ];


  function question() {
    return $this->belongsTo('App\Question');
  }

  function answer() {
    return $this->belongsTo('App\Answer');
  }
}
