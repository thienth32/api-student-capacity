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
    <div class="col-12 row">
        @if($data->postable_type == \App\Models\Recruitment::class)
            <div class="row col-12 mx-auto my-5">

                <button
                    class="click-info btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">
                    Thông tin bài viết
                </button>
                <button
                    class="click-candidates  btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">
                    Danh sách ứng tuyển
                </button>
            </div>
            <div class="col-12 pb-2">
                <div style="display:none" id="info">
                    <div class="row">
                        <div class="col-xl-4 mb-5 mb-xl-10">
                            <div class="card card-flush ">
                                <!--begin::Heading-->
                                <div
                                    class=" rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
                                    style="background-image:url('assets/media/svg/shapes/top-green.png')">
                                    <!--begin::Title-->
                                    <div class="p-5">
                                        <span class="fw-bolder text-white fs-2x mb-3">{{ $data->title }}</span>
                                        <div class="fs-4 text-white mt-5">
                                            <div class="opacity-75">
                                                <img style="width:100%"
                                                     src="{{ $data->thumbnail_url ? $data->thumbnail_url : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}"/>

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
                                                        Tuyển dụng
                                                        @if($data->postable)
                                                            :
                                                            <b><a
                                                                    href="{{ route('admin.recruitment.detail', ['id' => $data->postable->id]) }}">{{ $data->postable->name }}</a></b>
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

                </div>
                <div style="display:none" id="candidates">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="my-6 d-flex justify-content-between align-items-center">
                                <h2 class="my-6">Danh sách ứng tuyển</h2>
                                <button
                                    disabled
                                    class="btn btn-primary my-3"
                                    id="collectDataButton"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sendCVModal"
                                >
                                    Gửi CV tới doanh nghiệp
                                </button>
                                <div class="modal fade" id="sendCVModal" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Gửi CV tới doanh nghiệp
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="email"
                                                           value="{{ $data->contact_email }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" id="submitBtn">
                                                    Gửi
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="width:100%" class=" fs-3 pb-5">
                                <div class="my-6 d-flex justify-content-end">
                                    <div class="filter d-flex justify-content-between align-items-end">
                                        <div class="me-5">
                                            <label class="form-label" for="statusFilter">Lọc theo trạng thái:</label>
                                            <select id="statusFilter"
                                                    class="select-date-time form-select mb-2 select2-hidden-accessible"
                                                    data-control="select2"
                                                    data-hide-search="true" tabindex="-1" aria-hidden="true">
                                                <option value="">Tất cả</option>
                                                @foreach(config('util.CANDIDATE_OPTIONS.STATUSES') as $key => $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="me-5">
                                            <label class="form-label" for="resultFilter">Lọc theo kết quả:</label>
                                            <select id="resultFilter"
                                                    class="select-date-time form-select mb-2 select2-hidden-accessible"
                                                    data-control="select2"
                                                    data-hide-search="true" tabindex="-1" aria-hidden="true">
                                                <option value="">Tất cả</option>
                                                <option value="Chưa có">Chưa có</option>
                                                @foreach(config('util.CANDIDATE_OPTIONS.RESULTS') as $key => $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button id="applyFiltersButton" class="btn btn-primary mb-2">Áp dụng bộ lọc
                                        </button>
                                    </div>
                                </div>
                                <table id="myTable" class="my-3 table-hover">
                                    <thead>
                                    <tr>
                                        <th><input class="form-check-input" type="checkbox" id="selectAll"></th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Mã sinh viên</th>
                                        <th>Trạng thái</th>
                                        <th>Kết quả</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($candidates as $candidate)
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox" name="candidate_ids"
                                                       id=""
                                                       value="{{ $candidate->id }}">
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.candidate.showcv', $candidate->id) }}" target="_blank">
                                                    {{ $candidate->name }}
                                                </a>
                                            </td>
                                            <td>{{ $candidate->email }}</td>
                                            <td>{{ $candidate->student_code }}</td>
                                            <td>{{ config('util.CANDIDATE_OPTIONS.STATUSES')[$candidate->status] }}</td>
                                            <td>{{ config('util.CANDIDATE_OPTIONS.RESULTS')[$candidate->result] ?? "Chưa có" }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-xl-4 mb-5 mb-xl-10">
                    <div class="card card-flush ">
                        <!--begin::Heading-->
                        <div
                            class=" rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
                            style="background-image:url('assets/media/svg/shapes/top-green.png')">
                            <!--begin::Title-->
                            <div class="p-5">
                                <span class="fw-bolder text-white fs-2x mb-3">{{ $data->title }}</span>
                                <div class="fs-4 text-white mt-5">
                                    <div class="opacity-75">
                                        <img style="width:100%"
                                             src="{{ $data->thumbnail_url ? $data->thumbnail_url : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}"/>

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
                                                @if ($data->postable_type == \App\Models\Round::class)
                                                    Vòng thi : <b><a
                                                            href="{{ route('admin.round.detail', ['id' => $data->postable->id]) }}">{{ $data->postable->name }}</a></b>
                                                @elseif ($data->postable_type == \App\Models\Recruitment::class)
                                                    Tuyển dụng
                                                    @if($data->postable)
                                                        :
                                                        <b><a
                                                                href="{{ route('admin.recruitment.detail', ['id' => $data->postable->id]) }}">{{ $data->postable->name }}</a></b>
                                                    @endif
                                                @elseif($data->postable_type == \App\Models\Contest::class && $data->postable->type == 0)
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
        @endif

    </div>

@endsection

@section('page-style')
    <style>
        table.dataTable tbody tr.selected {
            color: #181c32;
        }

        table.dataTable tbody > tr.selected {
            background-color: #F1FAFF;
        }
    </style>
@endsection
@section('page-script')
    @if($data->postable_type == \App\Models\Recruitment::class)
        <script src="assets/js/system/formatlist/formatlis.js"></script>
        <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="assets/js/system/post/detail-datatables.js"></script>
        <script>
            const csrfToken = "{{ csrf_token() }}";
            const infoBtn = $(".click-info");
            const candidatesBtn = $(".click-candidates");
            const info = $("#info");
            const candidates = $("#candidates");
            let selectedIDs = [];
            const submitBtn = $("#submitBtn");

            infoBtn.click(function () {
                candidatesBtn.removeClass("btn-primary");
                $(this).addClass("btn-primary");
                candidates.hide(100)
                info.show(300);
            });
            candidatesBtn.click(function () {
                infoBtn.removeClass("btn-primary");
                info.hide(100);
                $(this).addClass("btn-primary");
                candidates.toggle(300);
            });
            infoBtn.click();

            submitBtn.click(function () {

                submitBtn.text('Đang gửi...');

                submitBtn.attr("disabled", true);

                selectedIDs = [];
                let selectedRows = table.rows({selected: true}).nodes();
                $(selectedRows).each(function () {
                    var checkbox = $(this).find('input[type="checkbox"]');
                    if (checkbox.is(':checked')) {
                        var id = checkbox.val();
                        selectedIDs.push(id);
                    }
                });

                $.ajax({
                    url: `{{ route('admin.post.sendCvToEnterprise', ['slug' => $data->slug]) }}`,
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        email: $("input[name='email']").val(),
                        candidate_ids: selectedIDs
                    },
                    success: function (data) {
                        if (data.status == true) {

                            submitBtn.text('Gửi');

                            submitBtn.attr("disabled", false);

                            loadTast(
                                "Thành công !",
                                "toastr-top-right",
                                "success"
                            );

                            // setTimeout(() => {
                            //     window.location.reload();
                            // }, 1000);
                        } else {
                            submitBtn.text('Gửi');

                            submitBtn.attr("disabled", false);

                            loadTast(
                                data?.payload ?? "Có lỗi xảy ra !",
                                "toastr-top-right",
                                "info"
                            );

                        }
                    },
                    error: function (data) {

                        submitBtn.text('Gửi');

                        submitBtn.attr("disabled", false);

                        loadTast(
                            data?.responseJSON?.message ?? "Có lỗi xảy ra !",
                            "toastr-top-right",
                            "info"
                        );

                    }
                });
            });
        </script>
    @endif
@endsection
