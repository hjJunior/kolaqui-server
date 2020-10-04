<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\UploadedFile;

class RegisterUploadedFile implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct($request) {
    $this->request = $request;
  }

  public function handle() {
    $file_path = $this->uploadFile();
    return $this->storeInDatabase($file_path);
  }

  private function uploadFile() {
    return $this->request->file->store('questions', 's3');
  }

  private function storeInDatabase($path) {
    $uploaded_file = (new UploadedFile([
      'filename' => $path
    ]));

    $uploaded_file->save();

    return $uploaded_file;
  }
}
