<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SubmitExameAttempt;

class ExameReviewController extends Controller {
  public function __invoke(Request $request) {
    $attributes = $request->only('answers', 'attemptId');
    SubmitExameAttempt::dispatch($attributes);

    return array('status' => 'scheduled');
  }
}
