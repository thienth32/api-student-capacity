@extends('layouts.main')
@section('title', 'Trực tiếp trò chơi ')
@section('page-title', 'Trực tiếp trò chơi ')
@section('content')

    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h1>Trực tiếp trò chơi {{ $exam->name }}
                    </h1>
                </div>
            </div>
        </div>

    </div>


@endsection
@section('page-script')
@endsection
