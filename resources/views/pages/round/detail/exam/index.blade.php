@extends('layouts.main')
@section('title', 'Danh sách đề thi')
@section('page-title', 'Danh sách đề thi ')
@section('content')
    <div class=" card card-flush p-5">
        <div class=" mb-4">
            <div class="row">
                <div class="col-lg-10">
                    <ol class="breadcrumb text-muted fs-6 fw-bold">
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 ">
                            <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}"
                                class="pe-3">
                                {{ $round->contest->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.round.list') }}" class="pe-3">Vòng thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}">
                                {{ $round->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">Danh sách đề thi</li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a href="{{ route('admin.exam.create', ['id' => $round->id]) }}" class="btn btn-primary">Thêm mới
                        đề</a>
                </div>
            </div>
        </div>


    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th>#</th>
                                <th>Tên</th>
                                <th>Mô tả đề</th>
                                <th>Điểm qua vòng</th>
                                <th>Điểm tối đa</th>
                                <th>Đề bài</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($exams as $exam)
                                <tr>
                                    <td>{{ $key++ }}</td>

                                    <td>{{ $exam->name }}</td>

                                    <td>
                                        <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal_{{ $exam->id }}">
                                            Xem Thêm
                                        </button>
                                        <!-- Modal -->
                                        <div style="margin: auto; display: none;" class="modal fade"
                                            id="exampleModal_{{ $exam->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Mô tả đề thi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body  ">
                                                        {{ $exam->description }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Thoát
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    <td>{{ $exam->ponit }}</td>
                                    <td>{{ $exam->max_ponit }}</td>
                                    <td>

                                        <button data-id="{{ $exam->id }}"
                                            data-external_url="{{ Storage::disk('google')->url($exam->external_url) }}"
                                            type="button" class="download_file btn btn-success">Tải xuống</button>
                                        {{-- <iframe width="50%" height="100%"
                                            src="https://drive.google.com/file/d/{{ explode('=', explode('&', explode('?', Storage::disk('google')->url($exam->external_url))[1])[0])[1] }}/preview"></iframe> --}}
                                    </td>

                                    <td>

                                        <button
                                            data-href="{{ route('admin.exam.edit', ['id_exam' => $exam->id, 'id' => $round->id]) }}"
                                            data-date_time="{{ $exam->round->start_time }}"
                                            class="edit_exam btn btn-primary">
                                            Chỉnh sửa đề
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('page-script')

    <script src="assets/js/system/exam/exam.js"></script>

@endsection
