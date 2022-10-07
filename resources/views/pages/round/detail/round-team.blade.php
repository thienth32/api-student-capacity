@extends('layouts.main')
@section('title', 'Danh sách đội thi ')
@section('page-title', 'Danh sách đội thi ')
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
                            <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}" class="pe-3">
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
                        <li class="breadcrumb-item px-3 text-muted">Danh sách đội thi</li>
                    </ol>
                </div>
            </div>
        </div>
        @hasanyrole(config('util.ROLE_ADMINS'))
            <div class="row">
                <div class="col-lg-12">
                    <form id="formTeam" action="{{ route('admin.round.detail.team.attach', ['id' => $round->id]) }}"
                        method="POST">
                        @csrf
                        <label for="" class="form-label">Đội thi</label>
                        <select multiple class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="false" tabindex="-1" aria-hidden="true" name="team_id[]"
                            value="{{ old('team_id') }}">
                            {{-- @if (count($round->add_Teams) > 0 || count($round->teams) > 0)
                                @foreach ($round->add_Teams as $teamSelect)
                                    <option value="{{ $teamSelect->id }}"> {{ $teamSelect->name }}</option>
                                @endforeach
                            @else --}}
                            @foreach ($teamContest as $team)
                                <option value="{{ $team->id }}"> {{ $team->name }}</option>
                            @endforeach

                        </select>
                        <button type="submit" class="btn btn-primary"> Thêm </button>

                    </form>
                </div>
            </div>
        @endhasanyrole
    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                {{-- <th>Ảnh</th> --}}
                                <th>Tên đội</th>
                                <th>Đề bài</th>
                                <th>Bài làm </th>
                                <th>Quá trình</th>
                                <th>Điểm Qua vòng</th>
                                <th>Điểm thi</th>
                                <th>Trạng thái</th>

                                <th>Trạng thái làm bài </th>
                                @if (auth()->user()->hasRole('judge'))
                                    <th>Chấm bài </th>
                                @else
                                    <th> Xác nhận điểm thi</th>
                                @endif
                                @hasanyrole(config('util.ROLE_ADMINS'))
                                    <th>Thao tác</th>
                                @endhasanyrole
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($roundTeams as $team)
                                <tr>

                                    <td> <a
                                            href="{{ route('admin.round.detail.team.detail', ['id' => $round->id, 'teamId' => $team->team->id]) }}">
                                            {{ $team->team->name }}</a>
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('dowload.file') }}?url={{ $team->takeExam->exam->external_url }}" --}}
                                        @if ($team->takeExam)
                                            <a href="{{ $team->takeExam->exam->external_url }}"
                                                class="badge bg-primary p-3">Tải về</a>
                                        @else
                                            <span class="badge bg-primary p-3"> Chưa có bài </span>
                                        @endif

                                    </td>
                                    <td>
                                        @if ($team->takeExam)
                                            @if ($team->takeExam->status == config('util.TAKE_EXAM_STATUS_UNFINISHED'))
                                                <span class="badge bg-primary p-3"> Chưa có bài </span>
                                            @elseif($team->takeExam->status == config('util.TAKE_EXAM_STATUS_CANCEL'))
                                                <span class="badge bg-danger  p-3"> Bài thi bị hủy </span>
                                            @else
                                                @if ($team->takeExam->file_url)
                                                    <a href="{{ route('dowload.file') }}?url={{ $team->takeExam->file_url }}"
                                                        class="badge bg-primary p-3">Tải về</a>
                                                @endif
                                                @if ($team->takeExam->result_url != null)
                                                    <a href="{{ $team->takeExam->result_url }}"
                                                        class="badge bg-primary p-3">Link bài làm </a>
                                                @endif
                                            @endif
                                        @else
                                            <span class="badge bg-primary p-3"> Chưa có bài </span>
                                        @endif

                                    </td>
                                    <td>
                                        @if ($team->takeExam)
                                            @if ($team->takeExam->status == config('util.TAKE_EXAM_STATUS_UNFINISHED'))
                                                <span class="badge bg-success  p-3"> Đang làm bài </span>
                                            @elseif($team->takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE'))
                                                <span class="badge bg-success  p-3"> Đã nộp bài </span>
                                            @else
                                                <span class="badge bg-danger  p-3"> Đã hủy bài </span>
                                            @endif
                                        @else
                                            <span class="badge bg-primary p-3"> Chưa có bài </span>
                                        @endif

                                    </td>
                                    <td>
                                        @if ($team->takeExam)
                                            {{ $team->takeExam->exam->ponit }}
                                        @else
                                            <span class="badge bg-primary p-3"> Chưa có bài </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($team->takeExam)
                                            @if ($team->takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE'))
                                                {{ $team->takeExam->final_point ?? 0 }}/{{ $team->takeExam->exam->max_ponit }}
                                            @else
                                                0/{{ $team->takeExam->exam->max_ponit }}
                                            @endif
                                        @else
                                            <span class="badge bg-primary p-3"> Chưa có bài </span>
                                        @endif

                                    </td>
                                    <td>
                                        @if ($team->takeExam)
                                            @if ($team->takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE') &&
                                                $team->takeExam->final_point >= $team->takeExam->exam->ponit)
                                                <span class="badge bg-success  p-3"> Passed </span>
                                            @elseif($team->takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE') && $team->takeExam->final_point == null)
                                                <span class="badge bg-success  p-3">Đang đợi điểm</span>
                                            @else
                                                <span class="badge bg-danger  p-3"> Failed</span>
                                            @endif
                                        @else
                                            <span class="badge bg-primary p-3"> Chưa có bài </span>
                                        @endif

                                    </td>

                                    <td>

                                        @if (isset($team->takeExam) && $team->takeExam->status == 2)
                                            Đã nộp bài
                                        @else
                                            Chưa nộp bài
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->hasRole('judge'))
                                            <a class="badge bg-primary p-3"
                                                href="{{ route('admin.round.detail.team.make.exam', ['id' => $round->id, 'teamId' => $team->team->id]) }}">Chấm
                                                bài</a>
                                        @else
                                            <a href="{{ route('admin.round.detail.team.judge', ['id' => $round->id, 'teamId' => $team->team->id]) }}"
                                                class="badge bg-primary p-3"> Xác nhận điểm thi.
                                            </a>
                                        @endif
                                    </td>
                                    @hasanyrole(config('util.ROLE_ADMINS'))
                                        <td>
                                            <a href="{{ route('admin.round.detail.team.detach', ['id' => $round->id, 'team_id' => $team->team->id]) }}"
                                                class="btn btn-danger deleteTeams"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    @endhasanyrole
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
    <script>
        var URL = '{{ url()->current() }}' + '?';
        var userArray = [];
        var _token = "{{ csrf_token() }}"
        // var URL_ATTACH = "{{ route('admin.judges.attach', ['contest_id' => $round->id]) }}"
        // var URL_SYNC = "{{ route('admin.judges.sync', ['contest_id' => $round->id]) }}"
        // var URL_DETACH = "{{ route('admin.judges.detach', ['contest_id' => $round->id]) }}"
    </script>
    <script>
        const elForm = "#formTeam";
        const onkeyup = true;
        const rules = {
            team_id: {
                required: true,
            }
        };
        const messages = {
            team_id: {
                required: 'Chưa chọn đội !!',
            }
        };
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
