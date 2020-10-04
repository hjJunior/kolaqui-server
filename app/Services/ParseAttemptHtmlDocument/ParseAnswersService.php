<?php

namespace App\Services\ParseAttemptHtmlDocument;

use App\Extended\ExtendedCrawler;
use App\Services\HtmlSanitizer;
use Symfony\Component\DomCrawler\Crawler;

class ParseAnswersService {
  private Crawler $crawler;
  private string $answersSelector = '.ablock .answer > div';
  private string $questionSelector = '.que.multichoice';
  private string $questionGradeSelector = '.grade';

  public function __construct(ExtendedCrawler $crawler) {
    $this->crawler = $crawler;
  }

  public function perform() {
    return $this->getAnswers();
  }

  private function getAnswers() {
    $answers = [];

    $this
    ->crawler
    ->filter($this->answersSelector)
    ->each(function(Crawler $answerNode) use (&$answers) {
      $answers[] = $this->getAnswer($answerNode);
    });


    return $answers;
  }
  private function getAnswer(ExtendedCrawler $answerNode) {
    $isAnswerChecked = $this->isAnswerChecked($answerNode);
    $isQuestionCorrect = $this->isQuestionCorrect($answerNode);


    return [
      'pure_content' => $answerNode->filter('label')->first()->text(),
      'content' => (new HtmlSanitizer($answerNode->filter('label')->first()->html()))->perform(),
      'correct' => $isAnswerChecked && $isQuestionCorrect,
      'selected' => $isAnswerChecked,
    ];
  }

  private function isAnswerChecked(ExtendedCrawler $answerNode) {
    return $answerNode->filter('input')->attr('checked') === 'checked';
  }

  private function isQuestionCorrect(ExtendedCrawler $answerNode) {
    $regexMatchers = [];
    $questionGrade = $this->getQuestionGrande($answerNode);

    /*
      Regex macthing examples:
      - Atingiu 0,00 de 0,50
      - Atingiu 0,00 de 0
      - Atingiu 0 de 0
    */
    if (preg_match('/(\d+\,?\d*?) de (\d+\,?\d*)/', $questionGrade, $regexMatchers)) {
      return $regexMatchers[1] === $regexMatchers[2];
    }

    return false;
  }

  private function getQuestionGrande(ExtendedCrawler $node) {
    return $node
        ->parentsUntil($this->questionSelector)
        ->filter($this->questionGradeSelector)
        ->first()
        ->text();
  }
}
