<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model {
  use HasFactory;

  protected $fillable = [
    'content', 'question_id', 'pure_content', 'checksum'
  ];

  protected $hidden = [
    'created_at', 'updated_at', 'question_id', 'checksum'
  ];

  function question() {
    return $this->belongsTo('App\Question');
  }

  function replies() {
    return $this->hasMany('App\Reply');
  }

  function hasReplies() {
    return $this->replies()->count() >= 1;
  }

  function isCorrect() {
    if ($this->hasReplies()) {
        return $this->replies()->where('correct', true)->count() >= 1;
    }
    return NULL;
  }
}
