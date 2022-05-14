@extends('layouts.main')
@section('title', 'Đề bài của đội thi')
@section('page-title', 'Đề bài của đội thi')
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
                            <a
                                href="{{ route('admin.round.detail.team.detail', ['id' => $round->id, 'teamId' => $team->id]) }}">
                                {{ $team->name }}</a>

                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            Đề thi
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
                    @if ($Exam != null)
                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th></th>
                                    <th>Đề thi</th>
                                    <th>link đề</th>
                                    <th>mô tả</th>
                                    <th>Điểm tối đa</th>
                                    <th>Điểm qua vòng</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td></td>
                                    <td>{{ $Exam->exam->name }}</td>
                                    <td> <a class="badge bg-primary p-3" href="{{$Exam->exam->external_url }}">
                                            xem tại đây</a></td>

                                    <td>
                                        <button style="border: none" class="badge bg-primary p-3" type="button"
                                            data-bs-toggle="modal" data-bs-target="#introduce_{{ $Exam->exam->id }}">
                                            Xem thông tin...
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="introduce_{{ $Exam->exam->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Mô tả đề thi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body  ">
                                                        {{ $Exam->exam->description }}
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

                                    <td>{{ $Exam->exam->max_ponit }}</td>
                                    <td>{{ $Exam->exam->ponit }}</td>
                                    <td>
                                        @if ($Exam->exam->status == 1)
                                            <span class="badge bg-primary p-3">
                                                Kích hoạt
                                            </span>
                                        @else
                                            <span class="badge bg-danger p-3">
                                                Không kích hoạt
                                                <span>
                                        @endif
                                    </td>



                                </tr>

                            </tbody>
                        </table>
                    @else
                        <h3>Đội thi chưa có đề thi !!!</h3>
                    @endif
                </div>
            </div>


        </div>
    </div>
@endsection
@section('page-script')
    <script>
        var URL = window.location.href;
        var userArray = [];
        var _token = "{{ csrf_token() }}"
    </script>
    <script>

    </script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
