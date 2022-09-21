@extends('layouts.main')
@section('title', 'Trực tiếp trò chơi ')
@section('page-title', 'Trực tiếp trò chơi ')
@section('content')

    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h1>Trực tiếp trò chơi {{ $exam->name }} <strong class="text-primary">{{ $exam->questions_count }} /
                            {{ count(json_decode($exam->room_progress) ?? []) == 0 ? 1 : count(json_decode($exam->room_progress) ?? []) }}</strong>
                    </h1>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2>{!! $question->content !!}</h2>
            @foreach ($question->answers as $answer)
                <li>{!! $answer->content !!}</li>
            @endforeach
        </div>

        <div class=" d-flex flex-row-reverse bd-highlight">
            @if ($exam->questions_count == count(json_decode($exam->room_progress) ?? []))
                <a href="{{ route('admin.capacit.play.end', ['id' => $exam->room_code]) }}" class=" btn btn-primary">Kết thúc
                </a>
            @else
                @php
                    $next = $exam->questions[count(json_decode($exam->room_progress) ?? [])];
                @endphp
                <a href="{{ route('admin.capacit.play.run', ['id' => $exam->room_code, 'next' => $next]) }}"
                    class=" btn btn-primary">Câu tiếp theo
                </a>
            @endif
        </div>

    </div>


@endsection
@section('page-script')
@endsection
