<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUploadedFile;
use App\Jobs\RegisterUploadedFile;
use App\Notifications\NewUploadedFileNotification;

class FileUploadController extends Controller {
  public function __invoke(StoreUploadedFile $request) {
    $uploadedFile = RegisterUploadedFile::dispatchNow($request);
    $uploadedFile->notify(new NewUploadedFileNotification($uploadedFile));

    return array(
        'status' => 'ok'
    );
  }
}
