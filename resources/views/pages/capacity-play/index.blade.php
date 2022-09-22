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
                        <th>Mã trò chơi </th>
                        <th>Chi tiết trò chơi </th>
                        <th>Số điểm </th>
                        <th>Tình trạng </th>
                        <th>Tiến độ </th>
                        <th>Thao tác </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($exams as $key => $exam)
                        <tr>
                            <td> {{ $exam->name }} </td>
                            <td> {{ $exam->room_code }} </td>
                            <td> {{ $exam->description }} </td>
                            <td> {{ $exam->max_ponit }} </td>
                            <td>
                                <div class="alert {{ $exam->status == 2 ? 'alert-primary' : 'alert-info' }} ">
                                    {{ $exam->status == 2 ? 'Đã kết thúc' : ($exam->room_token ? 'Đã bắt đầu ' : 'Chưa bắt đầu') }}
                                </div>
                            </td>
                            <td> {{ count($exam->questions) }} / {{ count(json_decode($exam->room_progress) ?? []) }} </td>
                            <td> <a href="{{ route('admin.capacit.play.show', ['id' => $exam->id]) }}">Xem chi tiết </a>
                            </td>
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
