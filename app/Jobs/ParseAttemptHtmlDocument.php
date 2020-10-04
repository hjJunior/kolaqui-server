<?php

namespace App\Jobs;

use App\Extended\ExtendedCrawler;
use App\UploadedFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Services\ParseAttemptHtmlDocument\ParseQuestionsService;

class ParseAttemptHtmlDocument implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private ExtendedCrawler $crawler;
  private string $courseSelector = '#page-header .page-header-headings';

  public function __construct(UploadedFile $uploadedFile) {
    $this->loadFile($uploadedFile);
  }

  public function handle() {
    return [
      'course_slug' => $this->getCourseSlug(),
      'questions' => (new ParseQuestionsService($this->crawler))->perform(),
    ];
  }

  private function loadFile(UploadedFile $uploadedFile) {
    if (Storage::disk('s3')->exists($uploadedFile->filename)) {
      $contents = Storage::disk('s3')->get($uploadedFile->filename);

      $this->crawler = new ExtendedCrawler($contents);
    }
  }

  private function getCourseSlug() {
    return $this->crawler->filter($this->courseSelector)->first()->text();
  }
}
