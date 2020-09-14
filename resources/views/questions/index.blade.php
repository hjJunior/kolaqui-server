@extends('layouts/app')

@section('content')
  @foreach ($questions as $question)
    <div class="question-row">
      <div class="question-row__stats">
        <div class="display-large-text">{{  $question->replies()->count() }}</div>
        <div>Tentativas</div>
      </div>

      <a
        href="{{ route('questions.show', ['question' => $question]) }}"
        class="question-row__content"
      >
        {!! $question->content !!}
      </a>
    </div>
  @endforeach
@endsection
