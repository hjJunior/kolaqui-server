<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
  protected $fillable = [
    'slug', 'content', 'question_id'
  ];

  function question() {
    return $this->belongsTo('App\Question');
  }
}
