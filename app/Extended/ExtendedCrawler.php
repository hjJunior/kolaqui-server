<?php

namespace App\Extended;

use Symfony\Component\DomCrawler\Crawler;

class ExtendedCrawler extends Crawler {
  public function parent() {
    $node = $this->getNode(0);
    $nodes = array();

    if ($node = $node->parentNode) {
      $nodes[] = $node;
    }

    return $this->createSubCrawler($nodes);
  }

  public function parentsUntil(string $selector) {
    if ($this->matches($selector)) {
      return $this;
    }

    if ($this->first()->matches('html')) {
      return null;
    };

    return $this->parent()->parentsUntil($selector);
  }

  private function createSubCrawler($nodes): object {
    return new static($nodes);
  }
}
