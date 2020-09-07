<?php

namespace App\Http\Controllers\Api;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SearchQuestions;

class QuestionsController extends Controller {
  public function index(Request $request) {
    return SearchQuestions::dispatchNow($request->input('search', '*'));
  }

  public function show($id) {
    return Question::where('id', $id)
      ->with('answers.replies')
      ->get();
  }
}
