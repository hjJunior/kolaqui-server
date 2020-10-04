<?php

namespace App\Services\ParseAttemptHtmlDocument;

use App\Extended\ExtendedCrawler;
use App\Services\HtmlSanitizer;

class ParseQuestionsService {
  private ExtendedCrawler $crawler;

  private string $questionsSelector = '.que.multichoice';
  private string $questionTextSelector = '.qtext';
  private string $flagQuestionInput = 'input.questionflagpostdata';

  public function __construct(ExtendedCrawler $crawler) {
    $this->crawler = $crawler;
  }

  public function perform() {
    return $this->getQuestions();
  }

  private function getQuestions() {
    $questions = [];

    $this
        ->crawler
        ->filter($this->questionsSelector)
        ->each(function(ExtendedCrawler $questionNode) use (&$questions) {
        $questions[] = $this->getQuestion($questionNode);
    });

    return $questions;
  }


  private function getQuestion(ExtendedCrawler $questionNode) {
    return [
      'slug' => $this->getRealQuestionId($questionNode),
      'pure_content' => $this->getQuestionTextNode($questionNode)->text(),
      'content' => (new HtmlSanitizer($this->getQuestionTextNode($questionNode)->html()))->perform(),
      'answers' => (new ParseAnswersService($questionNode))->perform(),
    ];
  }

  private function getQuestionTextNode(ExtendedCrawler $questionNode) {
    return $questionNode
        ->filter($this->questionTextSelector)
        ->first();
  }


  private function getRealQuestionId(ExtendedCrawler $questionNode) {
    $result = [];
    $attrs = $questionNode
        ->filter($this->flagQuestionInput)
        ->first()
        ->attr('value');

    parse_str($attrs, $result);

    return $result['qid'];
  }
}
