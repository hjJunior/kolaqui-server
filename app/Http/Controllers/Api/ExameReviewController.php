<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SubmitExameAttempt;

class ExameReviewController extends Controller {
  public function __invoke(Request $request) {
    SubmitExameAttempt::dispatch($request->input('answers'));

    return array('status' => 'scheduled');
  }
}
