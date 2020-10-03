<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model {
  use Searchable, HasFactory;
  
  protected $fillable = [
    'slug', 'content', 'pure_content'
  ];

  function answers() {
    return $this->hasMany('App\Answer');
  }

  function replies() {
    return $this->hasMany('App\Reply');
  }

  public function scopeHasReplies($query) {
    return $query->has("replies");
  }

  protected $hidden = [
    'created_at', 'updated_at'
  ];

  protected $indexConfigurator = ElasticSearchIndex\QuestionsIndexConfigurator::class;
  
  protected $mapping = [
    'properties' => [
      'pure_content' => [
        'type' => 'text'
      ],
    ]
  ];
}
