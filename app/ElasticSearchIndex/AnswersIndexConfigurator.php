<?php

namespace App\ElasticSearchIndex;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class AnswersIndexConfigurator extends IndexConfigurator {
  use Migratable;
  
  protected $settings = [];
}
