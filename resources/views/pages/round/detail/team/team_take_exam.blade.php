@extends('layouts.main')
@section('title', 'Bài làm của đội thi')
@section('page-title', 'Bài làm của đội thi')
@section('content')
    <div class=" card card-flush p-5">
        <div class=" mb-4">
            <div class="row">
                <div class="col-lg-12">
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
                            <a href="{{ route('admin.contest.detail.round', ['id' => $round->contest_id]) }}"
                                class="pe-3">Vòng thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}">
                                {{ $round->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail.team', ['id' => $round->id]) }}"> Đội thi</a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            {{ $team->name }}
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            Bài làm
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    @if ($takeExam != null)
                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th></th>
                                    <th>Đề bài</th>
                                    <th>Bài làm </th>
                                    <th>Quá trình</th>
                                    <th>Điểm Qua vòng</th>
                                    <th>Điểm thi</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                              <a
                                                  href="{{ route('dowload.file') }}?url={{  $takeExam->exam->external_url }}"
                                                  class="badge bg-primary p-3">Tải về</a>
                                    </td>
                                    <td>
                                        @if ($takeExam->status == config('util.TAKE_EXAM_STATUS_UNFINISHED'))
                                            <span class="badge bg-primary p-3"> Chưa có bài </span>
                                        @elseif($takeExam->status == config('util.TAKE_EXAM_STATUS_CANCEL'))
                                            <span class="badge bg-danger  p-3"> Bài thi bị hủy </span>
                                        @else
                                             @if ($takeExam->file_url)
                                            <a href="{{ route('dowload.file') }}?url={{ $takeExam->file_url }}"
                                                class="badge bg-primary p-3">Tải về</a>
                                             @endif
                                            @if ($takeExam->result_url != null)
                                                <a href="{{ $takeExam->result_url }}"
                                                    class="badge bg-primary p-3">Link bài làm </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($takeExam->status == config('util.TAKE_EXAM_STATUS_UNFINISHED'))
                                            <span class="badge bg-success  p-3"> Đang làm bài </span>
                                        @elseif($takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE'))
                                            <span class="badge bg-success  p-3"> Đã nộp bài </span>
                                        @else
                                            <span class="badge bg-danger  p-3"> Đã hủy bài </span>
                                        @endif
                                    </td>
                                    <td>{{ $takeExam->exam->ponit }}</td>
                                    <td>
                                        @if ($takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE'))
                                            {{ $takeExam->final_point ?? 0 }}/{{ $takeExam->exam->max_ponit }}
                                        @else
                                            0/{{ $takeExam->exam->max_ponit }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE') && $takeExam->final_point >= $takeExam->exam->ponit)
                                            <span class="badge bg-success  p-3"> Passed </span>
                                        @elseif($takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE') && $takeExam->final_point == null)
                                            <span class="badge bg-success  p-3">Đang đợi điểm</span>
                                        @else
                                            <span class="badge bg-danger  p-3"> Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $takeExam->mark_comment }}</td>
                                    @if ($takeExam->status == config('util.TAKE_EXAM_STATUS_CANCEL'))
                                        <td>
                                            <p>Đã hủy bài !</p>
                                        </td>
                                    @endif

                                </tr>

                            </tbody>
                        </table>
                    @else
                        <h3>Đội thi chưa có bài làm !!!</h3>
                    @endif
                </div>
            </div>


        </div>
    </div>
@endsection
@section('page-script')
    <script>
        var URL = '{{ url()->current() }}' + '?';
        var userArray = [];
        var _token = "{{ csrf_token() }}"
    </script>
    <script></script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
