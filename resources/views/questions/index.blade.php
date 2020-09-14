@extends('layouts/app')

@section('content')
  <div class="search-container">
    <div class="display-large-text">
      O que você quer kolar hoje?
    </div>
    <form class="search-container__form">
      <div class="search-container__input">
        <input name="search" />
        <div class="search-container__search-icon">
          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
        </div>
      </div>
    </form>
  </div>

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
  <div class="pagination-section">
    {!! $questions->links("pagination::bootstrap-4") !!}
  </div>
@endsection
