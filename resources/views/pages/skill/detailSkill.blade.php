@extends('layouts.main')
@section('title', 'Quản lý kỹ năng ')
@section('page-title', 'Quản lý kỹ năng')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.skill.index') }}" class="pe-3">Kỹ năng</a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">Chi tiết kĩ năng : {{ $data->name }}</li>
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
                        <span class="fw-bolder text-white fs-2x mb-3">{{ $data->name }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">

                                <img style="width:100%"
                                    src="{{ $data->image_url ? $data->image_url : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                    alt="">
                            </div>
                        </div>

                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Mã Kỹ năng</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->short_name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thuộc chuyên ngành</h3>
                                    </div>
                                    <div class="col-8">
                                        @if (count($data->majorSkill) > 0)
                                            @foreach ($data->majorSkill as $item)
                                                <li style="padding-bottom: 10px;color:#ffff"><a style="color: #ffff"
                                                        href="{{ route('admin.major.skill', ['slug' => $item->slug]) }}">Ngành:
                                                        {{ $item->name }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            Chưa có chuyên ngành
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Ngày tạo</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($data->created_at)) }}
                                        <br>
                                        {{ $data->created_at }}
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
                        <h2 class="my-6">Mô tả kỹ năng</h2>
                        <div class=" fs-3 pb-5">
                            {!! $data->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
@endsection
