<?php

namespace App\Http\Controllers\Api;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SearchQuestions;
use App\Jobs\CreateQuestion;

class QuestionsController extends Controller {
  public function index(Request $request) {
    return SearchQuestions::dispatchNow($request->input('search', '*'));
  }

  public function show($slug) {
    return Question::where('slug', $slug)
      ->with('answers.replies')
      ->firstOrFail();
  }

  public function store(Request $request) {
    $attibutes = $request->only('questionId', 'questionHtml', 'answers');
    CreateQuestion::dispatch($attibutes);

    return array('status' => 'scheduled');
  }
}
