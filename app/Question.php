<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
  protected $fillable = [
    'slug', 'content'
  ];

  function answer() {
    return $this->belongsTo('App\Answer');
  }
}
