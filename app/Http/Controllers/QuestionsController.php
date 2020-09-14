<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SearchQuestions;
use App\Question;

class QuestionsController extends Controller {
  public function index(Request $request) {
    $questions = SearchQuestions::dispatchNow($request->input('search', '*'));

    return view('questions.index', ['questions' => $questions]);
  }

  public function show($id) {
    $question = Question::findOrFail($id);

    return view('questions.show', ['question' => $question]);
  }
}
