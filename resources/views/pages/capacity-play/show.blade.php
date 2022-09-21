@extends('layouts.main')
@section('title', 'Chi tiết trò chơi ')
@section('page-title', 'Chi tiết trò chơi ')
@section('content')

    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h1>Chi tiết trò chơi {{ $exam->name }}
                        <a href="{{ route('admin.capacit.play.run', ['id' => $exam->id]) }}">Bắt đầu </a>
                    </h1>
                </div>
            </div>
        </div>

    </div>


@endsection
@section('page-script')
@endsection
