@extends('layouts/app')

@section('content')
  <div class="card">
    {!! $question->content !!}
    <div class="display-large-text">
      Alternativas
    </div>
    @foreach ($question->answers()->get() as $answer)
      <div
        class="answer-row {{ $answer->isCorrect() ? 'answer-row--corect' : ''}}"
      >
        {!! $answer->content !!}
      </div>
    @endforeach
  </div>
@endsection
