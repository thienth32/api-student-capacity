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
                                <th>#</th>
                                <th>Ảnh</th>
                                <th>Tên đội</th>
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
                                    <td>{{ $key++ }}</td>

                                    <td><img class='w-100px'
                                            src="{{ $team->team->image ? $team->team->image : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                            {{-- src="{{ Storage::disk('s3')->has($team->image) ? Storage::disk('s3')->temporaryUrl($team->image, now()->addMinutes(5)) : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}" --}} alt=""></td>
                                    <td> <a
                                            href="{{ route('admin.round.detail.team.detail', ['id' => $round->id, 'teamId' => $team->team->id]) }}">
                                            {{ $team->team->name }}</a>
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
