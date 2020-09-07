<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class Question extends Model {
  use Searchable;
  
  protected $fillable = [
    'slug', 'content'
  ];

  function answers() {
    return $this->hasMany('App\Answer');
  }

  protected $hidden = [
    'created_at', 'updated_at'
  ];

  protected $indexConfigurator = ElasticSearchIndex\QuestionsIndexConfigurator::class;
  
  protected $mapping = [
    'properties' => [
      'content' => [
        'type' => 'text',
        'fields' => [
          'raw' => [
            'type' => 'keyword',
          ]
        ]
      ],
    ]
  ];
}
