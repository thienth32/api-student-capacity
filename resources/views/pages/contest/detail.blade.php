@extends('layouts.main')
@section('title', 'Chi tiết cuộc thi')
@section('page-title', 'Chi tiết cuộc thi')
@section('content')


    <div id="kt_ecommerce_add_product_form"
        class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
        data-kt-redirect="../../demo1/dist/apps/ecommerce/catalog/products.html">
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush ">
                <div class="text-center py-20">
                    <div class="image-input image-input-empty image-input-outline" style="">
                        <div class="image-input-wrapper w-200px h-200px"
                            style="background-image: url({{ $contest->img == null
                                ? 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg'
                                : $contest->img }})">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">

                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#kt_ecommerce_add_product_general">Cuộc thi</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_ecommerce_add_product_advanced">Vòng thi</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_ecommerce_add_product_reviews">Đội thi</a>
                </li>

            </ul>

            <div class="tab-content card card-flush">
                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="container-fluid mt-3">

                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="list-group list-group-flush fs-2 ">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-4">
                                                    Tên cuộc thi
                                                </div>
                                                <div class="col-8">
                                                    {{ $contest->name }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-4">
                                                    Thời gian bắt đầu
                                                </div>
                                                <div class="col-8">
                                                    {{ date('d-m-Y H:i', strtotime($contest->date_start)) }}
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($contest->date_start)->diffforHumans() }}
                                                </div>
                                            </div>

                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-4">
                                                    Thời gian kết thúc
                                                </div>
                                                <div class="col-8">
                                                    {{ date('d-m-Y H:i', strtotime($contest->register_deadline)) }}
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($contest->register_deadline)->diffforHumans() }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-4">
                                                    Trạng thái
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
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-flush ">

                                        <h1 class="ps-2">Mô tả cuộc thi</h1>
                                        <div class="card-body fs-3">
                                            {!! $contest->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="">
                                        <table class="table table-striped table-responsive gy-7 gs-7">
                                            <thead>
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                    <th>Tên</th>
                                                    <th>Ảnh</th>
                                                    <th>Thời gian bắt đầu</th>
                                                    <th>Thời gian kết thúc</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contest->rounds as $round)
                                                    <tr>
                                                        <td>{{ $round->name }}</td>
                                                        <td>
                                                            <img class="image-input-wrapper w-100px h-100px"
                                                                src="{{ (\Storage::disk('google')->has($round->image) ? 111 : null) == null
                                                                    ? 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg'
                                                                    : \Storage::disk('google')->url($round->image) }}"
                                                                alt="">

                                                        </td>
                                                        <td>
                                                            {{ date('d-m-Y H:i', strtotime($round->start_time)) }}
                                                            <br>
                                                            {{ \Carbon\Carbon::parse($round->start_time)->diffforHumans() }}
                                                        </td>
                                                        <td>
                                                            {{ date('d-m-Y H:i', strtotime($round->end_time)) }}
                                                            <br>
                                                            {{ \Carbon\Carbon::parse($round->end_time)->diffforHumans() }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="kt_ecommerce_add_product_reviews" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped gy-7 gs-7">
                                            <thead>
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                    <th>Tên</th>
                                                    <th>Ảnh</th>
                                                    <th>Thành viên</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contest->teams as $team)
                                                    <tr>
                                                        <td>{{ $team->name }}</td>
                                                        <td>
                                                            <img class="image-input-wrapper w-100px h-100px"
                                                                src="{{ (\Storage::disk('google')->has($team->image) ? 111 : null) == null
                                                                    ? 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg'
                                                                    : \Storage::disk('google')->url($team->image) }}"
                                                                alt="">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_{{ $team->id }}">
                                                                Xem
                                                            </button>

                                                            <div class="modal fade" tabindex="-1"
                                                                id="kt_modal_{{ $team->id }}">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Thành viên</h5>

                                                                            <!--begin::Close-->
                                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                                <span class="svg-icon svg-icon-2x"></span>
                                                                            </div>
                                                                            <!--end::Close-->
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <table
                                                                                class="table table-striped table-responsive gy-7 gs-7">
                                                                                <thead>
                                                                                    <tr
                                                                                        class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                                                        <th>Tên</th>
                                                                                        <th>Email</th>

                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($team->members as $user)
                                                                                        <tr>
                                                                                            <td>{{ $user->name }}</td>
                                                                                            <td>{{ $user->email }}</td>
                                                                                            {{-- <td>
                                                                                                <img class="image-input-wrapper w-100px h-100px"
                                                                                                    src="{{ (\Storage::disk('google')->has($round->image) ? 111 : null) == null
                                                                                                        ? 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg'
                                                                                                        : \Storage::disk('google')->url($round->image) }}"
                                                                                                    alt="">

                                                                                            </td> --}}

                                                                                        </tr>
                                                                                    @endforeach

                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light"
                                                                                data-bs-dismiss="modal">Close</button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>


    </div>


@endsection

@section('js_admin')
@endsection
