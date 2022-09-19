@extends('layouts.main')
@section('title', 'Chi tiết bài viết')
@section('page-title', 'Chi tiết bài viết')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.post.list') }}" class="pe-3">Bài viết</a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">{{ $data->title }}</li>
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
                        <span class="fw-bolder text-white fs-2x mb-3">{{ $data->title }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <img style="width:100%"
                                    src="{{ $data->thumbnail_url ? $data->thumbnail_url : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}" />

                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Tác giả</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->user->name }} - {{ $data->user->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Ngày xuất bản</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($data->published_at)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($data->published_at)->diffforHumans() }}
                                        <br>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thuộc</h3>
                                    </div>
                                    <div class="col-8">
                                        @if (get_class($data->postable) == \App\Models\Round::class)
                                            Vòng thi : <b><a
                                                    href="{{ route('admin.round.detail', ['id' => $data->postable->id]) }}">{{ $data->postable->name }}</a></b>
                                        @elseif (get_class($data->postable) == \App\Models\Recruitment::class)
                                            Tuyển dụng :
                                            <b><a
                                                    href="{{ route('admin.recruitment.detail', ['id' => $data->postable->id]) }}">{{ $data->postable->name }}</a></b>
                                        @elseif(get_class($data->postable) == \App\Models\Contest::class && $data->postable->type == 0)
                                            Cuộc thi : <b><a
                                                    href="{{ route('admin.contest.show', ['id' => $data->postable->id]) }}">{{ $data->postable->name }}</a></b>
                                        @else
                                            Bài test : <b><a
                                                    href="{{ route('admin.contest.show.capatity', ['id' => $data->postable->id]) }}">{{ $data->postable->name }}</a></b>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($data->code_recruitment != null)
                            <div class="fs-4 text-white mt-5">
                                <div class="opacity-75">
                                    <div class="row">
                                        <div class="col-4">
                                            <h3>Mã tuyển dụng</h3>
                                        </div>
                                        <div class="col-8">
                                            <button type="button"
                                                class="btn btn-primary">{{ $data->code_recruitment }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fs-4 text-white mt-5">
                                <div class="opacity-75">
                                    <div class="row">
                                        <div class="col-4">
                                            <h3>Danh sách</h3>
                                        </div>
                                        <div class="col-8">
                                            <a href="{{ route('admin.candidate.list', ['post_id' => $data->id]) }}"
                                                class=" btn btn-primary">Danh
                                                sách ứng tuyển
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Trạng thái</h3>
                                    </div>
                                    <div class="col-8">
                                        @if ($data->status == 1)
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
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-8 mb-5 mb-xl-10">

            <div class="container-fluid  card card-flush">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="my-6">Nội dung bài viết</h2>
                        <div style="width:100%" class=" fs-3 pb-5">

                            @if ($data->link_to != null)
                                <div class="col-md-3 mx-auto">
                                    <a href="{{ $data->link_to }}">
                                        <div
                                            class="badge badge-primary badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                            <div class="m-0  ">
                                                <span class="text-white-700 fw-bold fs-6">Xem tại
                                                    đây</span>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            @else
                                <h2> {{ $data->title }}</h2>
                                {!! $data->content !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
@section('page-script')
@endsection
