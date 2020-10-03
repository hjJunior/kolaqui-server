<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUploadedFile;
use App\Jobs\RegisterUploadedFile;

class FileUploadController extends Controller {
  public function __invoke(StoreUploadedFile $request) {
    RegisterUploadedFile::dispatchNow($request);

    return array('status' => 'ok');
  }
}
