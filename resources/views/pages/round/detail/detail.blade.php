@extends('layouts.main')
@section('title', 'Chi tiết vòng thi ')
@section('page-title', 'Chi tiết vòng thi ')
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
                    <li class="breadcrumb-item px-3 text-muted">{{ $round->name }}</li>
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
                        <span class="fw-bolder text-white fs-2x mb-3">{{ $round->name }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <img style="width:100%"
                                    src="{{ Storage::disk('google')->has($round['image']) ? Storage::disk('google')->url($round['image']) : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                    alt="">
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
                        <h2 class="my-6">Mô tả vòng thi </h2>
                        <div class=" fs-3 pb-5">
                            {!! $round->description !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class=" card card-flush ">
                        <div class="row p-5 d-flex justify-content-center align-items-center ">

                            @if (count($roundTeam) > 0)
                                <div class="col-md-3">
                                    <a href="{{ route('admin.round.detail.updateRoundTeam', ['id' => $round->id]) }}">
                                        <div
                                            class="badge badge-primary badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                            <div class="m-0  ">
                                                <span class="text-white-700 fw-bold fs-6">Công bố đội thi</span>
                                            </div>

                                        </div>
                                    </a>
                                </div>
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
                    @hasanyrole(config('util.ROLE_ADMINS') . '|judge')
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.round.detail.team', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Đội thi</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->teams) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endhasanyrole
                    @hasanyrole(config('util.ROLE_ADMINS'))
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.judges.round', ['round_id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Ban giám khảo</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->judges) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.round.detail.enterprise', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Doanh nghiệp tài trợ</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->Donor) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.exam.index', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Đề bài</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->exams) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.result.index', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Danh sách kết quả</span>
                                    </div>
                                    {{-- <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->exams) }}</span>
                                    </div> --}}
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
