@extends('layouts.main')
@section('title', 'Chi tiết đội thi')
@section('page-title', 'Chi tiết đội thi')
@section('content')
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
                    <li class="breadcrumb-item px-3 text-muted">
                        <a href="{{ route('admin.round.detail.team', ['id' => $round->id]) }}"> Đội thi</a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">
                        {{ $team->name }}
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 mb-5 mb-xl-10">
            <div class="card card-flush ">
                <!--begin::Heading-->
                <div class=" rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
                    style="background-image:url('assets/media/svg/shapes/top-green.png')">
                    <!--begin::Title-->
                    <div class="p-5">
                        <span class="fw-bolder text-white fs-2x mb-3">{{ $team->name }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <img style="width:100%"
                                    src="{{ $team->image ? $team->image : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                    {{-- src="{{ Storage::disk('s3')->has($team['image']) ? Storage::disk('s3')->temporaryUrl($team['image'], now()->addMinutes(5)) : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}" --}} alt="">
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Cuộc thi </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $round->contest->name }}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Vòng thi </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $round->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thể loại cuộc thi </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $round->type_exam->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian bắt đầu</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($round->start_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($round->start_time)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian kết thúc</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($round->end_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($round->end_time)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Trạng thái</h3>
                                    </div>
                                    <div class="col-8">
                                        @if ($contest->status == 1)
                                            <button type="button" class="btn btn-primary">
                                                Kích hoạt
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger">
                                                Không kích hoạt
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-8 mb-5 mb-xl-10">

            <div class="container-fluid  card card-flush">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="my-6">Danh sách thành viên </h2>
                        <div class=" fs-3 pb-5">
                            @if (count($team->members) > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Họ Tên</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $indexUser = 1; ?>
                                        @foreach ($team->members as $user)
                                            <tr>

                                                <td>{{ $indexUser++ }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h3> Chưa có thành viên</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class=" card card-flush ">
                <div class="row p-5 d-flex justify-content-center align-items-center ">
                    <div class="col-md-3">
                        <a href="{{ route('admin.round.detail.team.Exam', ['id' => $round->id, 'teamId' => $team->id]) }}">
                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                <div class="m-0">
                                    <span class="text-gray-700 fw-bold fs-6">Đề bài</span>
                                </div>

                            </div>
                        </a>
                    </div>
                    {{-- <div class="col-md-3">
                        <a
                            href="{{ route('admin.round.detail.team.takeExam', ['id' => $round->id, 'teamId' => $team->id]) }}">
                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                <div class="m-0">
                                    <span class="text-gray-700 fw-bold fs-6">Bài làm và kết quả</span>
                                </div>
                            </div>
                        </a>
                    </div> --}}
                    @hasanyrole('judge')
                        <div class="col-md-3">
                            <a
                                href="{{ route('admin.round.detail.team.make.exam', ['id' => $round->id, 'teamId' => $team->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Chấm
                                            bài</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endhasanyrole
                    @hasanyrole(config('util.ROLE_ADMINS'))
                        <div class="col-md-3">
                            <a
                                href="{{ route('admin.round.detail.team.judge', ['id' => $round->id, 'teamId' => $team->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Xác nhận điểm</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endhasanyrole
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
@endsection
