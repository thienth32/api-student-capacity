@extends('layouts.main')
@section('title', 'Danh sách trò chơi trực tiếp')
@section('page-title', 'Danh sách trò chơi trực tiếp')
@section('content')

    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">

                    <h1>Quản lý trò chơi trực tiếp
                    </h1>
                </div>

            </div>
            <div class=" col-lg-6">
                <div class=" d-flex flex-row-reverse bd-highlight">
                    <a href="{{ route('admin.capacit.play.create') }}" class=" btn btn-primary">Bắt đầu trò chơi mới
                    </a>
                </div>
            </div>
        </div>

        <div class="">
            <table class=" table table-row-bordered table-row-gray-300 gy-7  table-hover  ">
                <thead>
                    <tr>
                        <th>Tên trò chơi </th>
                        <th>Chi tiết trò chơi </th>
                        <th>Số điểm </th>
                        <th>Tình trạng </th>
                        <th>Thao tác </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($exams as $key => $exam)
                        <tr>
                            <td> {{ $exam->name }} </td>
                            <td> {{ $exam->description }} </td>
                            <td> {{ $exam->max_ponit }} </td>
                            <td> {{ $exam->max_ponit }} </td>
                            <td> Tiếp tục </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{ $exams->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>


    </div>



@endsection
@section('page-script')
@endsection
