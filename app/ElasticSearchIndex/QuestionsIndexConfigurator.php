<?php

namespace App\ElasticSearchIndex;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class QuestionsIndexConfigurator extends IndexConfigurator {
  use Migratable;
  
  protected $settings = [];
}
