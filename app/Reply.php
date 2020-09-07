<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
  function question() {
    return $this->belongsTo('App\Question');
  }

  function answer() {
    return $this->belongsTo('App\Answer');
  }
}
