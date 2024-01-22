@extends('layouts.main')
@section('title', 'Doanh nghiệp tuyển dụng')
@section('page-title', 'Doanh nghiệp tuyển dụng')
@section('content')
    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h1>
                        Danh sách doanh nghiệp đã tuyển dụng
                    </h1>
                    <a class="mx-2" href="{{ route('admin.candidate.list') }}">
                    <span data-bs-toggle="tooltip" title="Tải lại trang " role="button"
                          class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path
                                    d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                    fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    </a>
                </div>

            </div>
        </div>
        <div class="row card-format">
            <div class="col-12 col-lg-12 col-sx-12 col-md-12 col-sm-12 col-xxl-12 col-xl-12">
                <div class="form-group p-2">
                    <label class="form-label">Doanh nghiệp tuyển dụng</label>
                    <select id="select-enterprise" class="form-select mb-2 select2-hidden-accessible"
                            name="post_id" data-control="select2" data-hide-search="false" tabindex="-1"
                            aria-hidden="true">
                        <option value="">Chọn doanh tuyển dụng</option>
                        @foreach ($enterprises as $enterprise)
                            <option @selected(request('enterprise_id')==$enterprise->id) value="{{ $enterprise->id }}">
                                {{ $enterprise->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-sx-12 col-md-12 col-sm-12 col-xxl-6 col-xl-6">
                <div class="form-group p-2">
                    <label class="form-label">Mã tuyển dụng</label>
                    <select id="select-code-recruitment" class="form-select mb-2 select2-hidden-accessible"
                            name="post_id" data-control="select2" data-hide-search="false" tabindex="-1"
                            aria-hidden="true">
                        <option value="">Chọn mã tuyển dụng</option>
                        @foreach ($code_recruitments as $post)
                            <option @selected(request('post_id')==$post->id) value="{{ $post->id }}">
                                {{ $post->code_recruitment }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-sx-12 col-md-12 col-sm-12 col-xxl-6 col-xl-6">
                <div class="form-group p-2">
                    <label class="form-label">Ngành</label>
                    <select id="select-major-recruitment" class="form-select mb-2 select2-hidden-accessible"
                            name="major_id" data-control="select2" data-hide-search="false" tabindex="-1"
                            aria-hidden="true">
                        <option value="">Chọn ngành tuyển dụng</option>
                        @foreach ($majors as $major)
                            <option @selected(request('major_id')==$major->id) value="{{ $major->id }}">
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <div class="back">
                    <span data-bs-toggle="tooltip" title="Đóng lọc"
                          class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero"/>
                    </g>
                </svg>
                </span>

                <span data-bs-toggle="tooltip" title="Mở lọc" style="display: none"
                      class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) "/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>

            </div>
            <span class="text-primary">{{ $count }} kết quả</span>
        </div>
        <div class="table-responsive p-4 card card-flush ">

            @if (count($posts) > 0)
                <table class=" table table-hover table-responsive-md ">
                    <thead>
                    <tr>
                        <th scope="col">Tháng</th>
                        <th scope="col">Ngày cập nhật</th>
                        <th scope="col">Mã tuyển dụng
                        </th>
                        <th scope="col">Thông tin doanh nghiệp
                        </th>
                        <th scope="col"> Người liên hệ
                        </th>
                        <th scope="col"> Ngành
                        </th>
                        <th>Vị trí tuyển dụng</th>
                        <th>Loại hình</th>
                        <th>Số lượng</th>
                        <th>Thời hạn</th>
                        <th class="text-center" colspan="2">

                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">
                            <span class="fw-bold text-primary">
                                ({{ $posts->pluck('enterprise_id')->filter()->unique()->count() }})
                            </span>
                        </th>
                        <th scope="col"></th>
                        <th scope="col">
                            <span class="fw-bold text-primary">
                                ({{ $posts->pluck('major_id')->filter()->unique()->count() }})
                            </span>
                        </th>
                        <th>
                            <span class="fw-bold text-primary">
                                ({{ $posts->pluck('position')->filter()->unique()->count() }})
                            </span>
                        </th>
                        <th></th>
                        <th>
                            <span class="fw-bold text-primary">
                                ({{ $posts->sum(fn ($item) => is_numeric($item->total) ? $item->total : 0) }})
                            </span>
                        </th>
                        <th></th>
                        <th class="text-center" colspan="2">
                        </th>

                    </tr>

                    @foreach ($posts as $index => $key)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($key->getRawOriginal('created_at'))->format('m/Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($key->getRawOriginal('updated_at'))->format('d/m/Y') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.post.detail', ['slug' => $key->slug]) }}">
                                    {{ $key->code_recruitment }}</a>
                            </td>
                            <td>
                                @if($key->enterprise)
                                    <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                            data-bs-target="#introduce_{{ $key->id }}">
                                        {{ $key?->enterprise?->name ?? 'Chưa có' }}
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="introduce_{{ $key->id }}" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Thông tin doanh nghiệp
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body  ">
                                                    <ul>
                                                        <li>Doanh nghiệp : {{ $key?->enterprise?->name ?? 'Chưa có' }}
                                                            .
                                                        </li>
                                                        <li>Mã số thuế
                                                            : {{ $key?->tax_number ?? 'Chưa có' }} .
                                                        </li>
                                                        <li>Địa chỉ : {{ $key?->enterprise?->address ?? 'Chưa có' }}.
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    @if($key->enterprise)
                                                        <a
                                                            class="btn btn-primary"
                                                            href="{{ route('admin.enterprise.edit', $key->enterprise->id) }}"
                                                            target="_blank"
                                                        >
                                                            Sửa thông tin
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="btn  btn-danger btn-sm">Chưa có</span>
                                @endif
                            </td>

                            <td>
                                <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#introduce_contact_{{ $key->id }}">
                                    {{ $key?->contact_name ?? 'Chưa có' }}
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="introduce_contact_{{ $key->id }}" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Thông tin người liên hệ
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body  ">
                                                <ul>
                                                    <li>Tên người liên hệ : {{ $key?->contact_name ?? 'Chưa có' }}.
                                                    </li>
                                                    <li>Số điện thoại : {{ $key?->contact_phone ?? 'Chưa có' }} .</li>
                                                    <li>Email liên hệ : {{ $key?->contact_email ?? 'Chưa có' }} .</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $key->major->name ?? 'Chưa có' }}
                            </td>
                            <td>
                                {{ $key->position ?? 'Chưa có' }}
                            </td>
                            <td>
                                {{ config('util.CAREER_TYPES.' . $key->career_type) ?? 'Chưa có', }}
                            </td>
                            <td>
                                {{ $key->total ?? 'Chưa có' }}
                            </td>
                            <td>
                                {{ $key->deadline ? \Carbon\Carbon::parse($key->deadline)->format('d/m/Y') : 'Chưa có' }}
                            </td>
                            <td>
                                <div data-bs-toggle="tooltip" title="Thông tin thêm " class="btn-group dropstart">
                                    <button
                                        type="button"
                                        class="btn btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#info_{{ $key->id }}"
                                    >
                                        <span class="svg-icon svg-icon-success svg-icon-2x">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1 18h-2v-8h2v8zm-1-12.25c.69 0 1.25.56 1.25 1.25s-.56 1.25-1.25 1.25-1.25-.56-1.25-1.25.56-1.25 1.25-1.25z"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                <div class="modal fade" id="info_{{ $key->id }}" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Thông tin thêm
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body  ">
                                                <ul>
                                                    <li>Nguồn : {{ $key?->career_source ?? 'Chưa có' }} .</li>
                                                    <li>Yêu cầu kinh nghiệm
                                                        : {{ $key?->career_require ?? 'Chưa có' }} .
                                                    </li>
                                                    <li>Người phụ trách : {{ $key?->user?->name ?? 'Chưa có' }}.
                                                    </li>
                                                    <li>Email người phụ trách : {{ $key?->user?->email ?? 'Chưa có' }}.
                                                    </li>
                                                    <li>Ghi chú : {{ $key?->note ?? 'Chưa có' }} .</li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                {{ $posts->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Chưa có thông tin tuyển dụng !!!</h2>
            @endif

        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript" src="assets/js/custom/documentation/general/moment.min.js"></script>
    <script type="text/javascript" src="assets/js/custom/documentation/general/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script src="assets/js/system/enterprise/recruitment.js"></script>

    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script>
        const _token = "{{ csrf_token() }}";
        $('.select-status').on('change', function () {
            let status = $(this).val();
            $.ajax({
                url: `admin/candidates/change-status`,
                method: "POST",
                data: {
                    _token: _token,
                    status: status,
                },
                success: function (data) {
                    if (data.status == true) {
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    } else {
                        loadTast(
                            data.payload,
                            "toastr-bottom-left",
                            "info"
                        );
                    }
                },
            });
        });

        $('.select-result').on('change', function () {
            let result = $(this).val();
            $.ajax({
                url: `admin/candidates/change-result`,
                method: "POST",
                data: {
                    _token: _token,
                    result: result,
                },
                success: function (data) {
                    if (data.status == true) {
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    } else {
                        loadTast(
                            data.payload,
                            "toastr-bottom-left",
                            "info"
                        );
                    }
                },
            });
        });
    </script>
@endsection
