@extends('layouts.main')
@section('title', 'Quản lý bài thử thách ')
@section('page-title', 'Quản lý bài thử thách ')
@section('content')
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">

                    <h1>Danh sách bài thử thách
                    </h1>
                    <span data-bs-toggle="tooltip" title="Tải lại trang " role="button"
                        class="mx-2 refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                    fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    {{-- <a class="mx-2" href="{{ route('admin.sliders.soft.delete', 'slider_soft_delete=1') }}">

                        <span data-bs-toggle="tooltip" title="Kho lưu trữ bản xóa "
                            class=" svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Files/Deleted-folder.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M10.5857864,14 L9.17157288,12.5857864 C8.78104858,12.1952621 8.78104858,11.5620972 9.17157288,11.1715729 C9.56209717,10.7810486 10.1952621,10.7810486 10.5857864,11.1715729 L12,12.5857864 L13.4142136,11.1715729 C13.8047379,10.7810486 14.4379028,10.7810486 14.8284271,11.1715729 C15.2189514,11.5620972 15.2189514,12.1952621 14.8284271,12.5857864 L13.4142136,14 L14.8284271,15.4142136 C15.2189514,15.8047379 15.2189514,16.4379028 14.8284271,16.8284271 C14.4379028,17.2189514 13.8047379,17.2189514 13.4142136,16.8284271 L12,15.4142136 L10.5857864,16.8284271 C10.1952621,17.2189514 9.56209717,17.2189514 9.17157288,16.8284271 C8.78104858,16.4379028 8.78104858,15.8047379 9.17157288,15.4142136 L10.5857864,14 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </a> --}}
                </div>

            </div>
            <div class=" col-lg-6">
                <div class=" d-flex flex-row-reverse bd-highlight">
                    <a href="{{ route('admin.code.manager.create') }}" class=" btn btn-primary">Thêm mới bài thử thách
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="">Chọn mức độ</label>
                <select class="select-type form-control form-select mb-2 select2-hidden-accessible" data-control="select2"
                    data-hide-search="true" tabindex="-1" aria-hidden="true">
                    <option class="form-control" @selected(request('type') == 0) value="0">Dễ
                    </option>
                    <option class="form-control" @selected(request('type') == 1) value="1">Trung bình
                    </option>
                    <option class="form-control" @selected(request('type') == 2) value="2">Khó
                    </option>
                </select>
            </div>
            <div class="col-4">
                <label for="">Chọn ngôn ngữ</label>
                <select class="select-language form-control form-select mb-2 select2-hidden-accessible"
                    data-control="select2" data-hide-search="true" tabindex="-1" aria-hidden="true">
                    @foreach ($code_language as $item)
                        <option class="form-control" @selected(request('language_id') == $item->id) value="{{ $item->id }}">
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="">Tìm kiếm </label>
                <input type="text" class="form-control ip-search" placeholder="Tìm kiếm "
                    value="{{ request('q') ?? '' }}">
            </div>

        </div>
        <div class="">
            <table class=" table table-row-bordered table-row-gray-300 gy-7  table-hover  ">
                <thead>
                    <tr>

                        <th>Tên bài thử thách </th>
                        <th>Trạng thái </th>
                        <th>Điểm thưởng </th>
                        <th>Mức độ </th>
                        <th>Số bài test case </th>
                        <th>Ngôn ngữ hỗ trợ </th>
                        <th class="text-center" colspan="2">
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($challenges as $key => $challenge)
                        <tr>
                            <td>
                                <a
                                    href="{{ route('admin.code.manager.show', ['id' => $challenge->id]) }}">{{ $challenge->name }}</a>
                            </td>
                            <td>
                                <div data-bs-toggle="tooltip" title="Cập nhật trạng thái " class="form-check form-switch">
                                    <input value="{{ $challenge->status }}" data-id="{{ $challenge->id }}"
                                        class="form-select-status form-check-input" @checked($challenge->status == 1)
                                        type="checkbox" role="switch">
                                </div>
                            </td>
                            <td>
                                {{ 'TOP1 : ' . $challenge->rank_point->top1 }} <br>
                                {{ 'TOP2 : ' . $challenge->rank_point->top2 }} <br>
                                {{ 'TOP3 : ' . $challenge->rank_point->top3 }} <br>
                                {{ 'Leave : ' . $challenge->rank_point->leave }} <br>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ $challenge->type == 0 ? 'Dễ' : ($challenge->type == 1 ? 'Trung bình ' : 'Khó') }}</span>
                            </td>
                            <td>

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_{{ $challenge->id }}">
                                    Xem {{ count($challenge->test_case) }} test case
                                </button>

                                <div class="modal fade" tabindex="-1" id="kt_modal_{{ $challenge->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Test case {{ $challenge->name }}</h5>
                                            </div>

                                            <form
                                                action="{{ route('admin.code.manager.update.test.case', ['id' => $challenge->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="test_case">
                                                        <!--begin::Form group-->
                                                        <div class="form-group">
                                                            <div data-repeater-list="test_case">
                                                                @if (count($challenge->test_case) > 0)
                                                                    @foreach ($challenge->test_case as $test_case)
                                                                        <div data-repeater-item>
                                                                            <div class="form-group row">
                                                                                <input type="hidden"
                                                                                    value="{{ $test_case->id }}"
                                                                                    name="id_test_case">
                                                                                <div class="col-md-3">
                                                                                    <label for=""
                                                                                        class="form-label">Đầu
                                                                                        vào </label>
                                                                                    <input type="text" name="input"
                                                                                        value="{{ $test_case->input }}"
                                                                                        class=" form-control"
                                                                                        placeholder="">
                                                                                    @error('input')
                                                                                        <p class="text-danger">
                                                                                            {{ $message }}
                                                                                        </p>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for=""
                                                                                        class="form-label">Đầu
                                                                                        ra </label>
                                                                                    <input type="text" name="output"
                                                                                        value="{{ $test_case->output }}"
                                                                                        class=" form-control"
                                                                                        placeholder="">
                                                                                    @error('output')
                                                                                        <p class="text-danger">
                                                                                            {{ $message }}
                                                                                        </p>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-md-2">
                                                                                    <div
                                                                                        class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                                                        <input class="form-check-input"
                                                                                            name="status" type="checkbox"
                                                                                            value="1"
                                                                                            @checked($test_case->status == 0)
                                                                                            id="form_checkbox" />
                                                                                        <label class="form-check-label"
                                                                                            for="form_checkbox">
                                                                                            Test ẩn
                                                                                        </label>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <a href="javascript:;"
                                                                                        data-repeater-delete
                                                                                        class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                        <i class="la la-trash-o"></i>Xóa
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div data-repeater-item>
                                                                        <div class="form-group row">
                                                                            <input type="hidden" name="id_test_case">
                                                                            <div class="col-md-3">
                                                                                <label for=""
                                                                                    class="form-label">Đầu
                                                                                    vào </label>
                                                                                <input type="text" name="input"
                                                                                    class=" form-control" placeholder="">
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <label for=""
                                                                                    class="form-label">Đầu
                                                                                    ra </label>
                                                                                <input type="text" name="output"
                                                                                    class=" form-control" placeholder="">
                                                                            </div>

                                                                            <div class="col-md-2">
                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                                                    <input class="form-check-input"
                                                                                        name="status" type="checkbox"
                                                                                        value="1"
                                                                                        id="form_checkbox" />
                                                                                    <label class="form-check-label"
                                                                                        for="form_checkbox">
                                                                                        Test ẩn
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <a href="javascript:;" data-repeater-delete
                                                                                    class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                    <i class="la la-trash-o"></i>Xóa
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group mt-5">
                                                            <a href="javascript:;" data-repeater-create
                                                                class="btn btn-light-primary">
                                                                <i class="la la-plus"></i>Thêm mới
                                                            </a>
                                                        </div>

                                                    </div>

                                                    @error('test_case')
                                                        <script>
                                                            toastr.warning("{{ $message }}");
                                                        </script>
                                                    @enderror

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Thoát
                                                    </button>
                                                    <button class="btn btn-primary">Lưu lại</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_language_{{ $challenge->id }}">
                                    @if (count($challenge->sample_code) > 0)
                                        @foreach ($challenge->sample_code as $sample_code)
                                            <span class="badge badge-info"> {{ $sample_code->code_language->name }}</span>
                                        @endforeach
                                    @else
                                        Thêm ngôn ngữ
                                    @endif
                                </button>

                                <div class="modal fade" tabindex="-1" id="kt_modal_language_{{ $challenge->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Thêm ngôn ngữ </h5>
                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="svg-icon svg-icon-2x"></span>
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                            <form
                                                action="{{ route('admin.code.manager.update.sample.code', ['id' => $challenge->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    @php
                                                        $listIdSampleCode = $challenge->sample_code
                                                            ->map(function ($q) {
                                                                return $q->code_language_id;
                                                            })
                                                            ->toArray();
                                                    @endphp
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="Select an option" name="languages[]"
                                                        data-allow-clear="true" multiple="multiple">
                                                        @foreach ($code_language as $value)
                                                            <option @selected(in_array($value->id, $listIdSampleCode))
                                                                value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Thoát </button>
                                                    <button class="btn btn-primary">Lưu lại</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>


                            </td>
                            <td>


                                <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update_{{ $challenge->id }}">
                                    <span role="button" class="svg-icon svg-icon-success svg-icon-2x">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Edit.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                <rect fill="#000000" opacity="0.3" x="5" y="20"
                                                    width="15" height="2" rx="1" />
                                            </g>
                                        </svg>
                                    </span>
                                    Chỉnh sửa
                                </button>

                                <div class="modal fade" tabindex="-1" id="kt_modal_update_{{ $challenge->id }}">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cập nhật thông tin {{ $challenge->name }}</h5>

                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="svg-icon svg-icon-2x"></span>
                                                </div>
                                                <!--end::Close-->
                                            </div>

                                            <form
                                                action="{{ route('admin.code.manager.update', ['id' => $challenge->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body row">
                                                    <div class="col-6">
                                                        <div class="form-group mb-10  ">
                                                            <label for="" class="form-label">Tên thử thách
                                                            </label>
                                                            <input type="text" name="name"
                                                                value="{{ $challenge->name }}" class=" form-control"
                                                                placeholder="">
                                                            @error('name')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mb-10  ">
                                                            <label for="" class="form-label">Top 1 </label>
                                                            <input type="number" min="0" name="top1"
                                                                value="{{ $challenge->rank_point->top1 }}"
                                                                class=" form-control" placeholder="">
                                                            @error('top1')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mb-10  ">
                                                            <label for="" class="form-label">Top 2 </label>
                                                            <input type="number" min="0" name="top2"
                                                                value="{{ $challenge->rank_point->top2 }}"
                                                                class=" form-control" placeholder="">
                                                            @error('top2')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mb-10  ">
                                                            <label for="" class="form-label">Top 3 </label>
                                                            <input type="number" min="0" name="top3"
                                                                value="{{ $challenge->rank_point->top3 }}"
                                                                class=" form-control" placeholder="">
                                                            @error('top3')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mb-10  ">
                                                            <label for="" class="form-label">Leave</label>
                                                            <input type="number" min="0" name="leave"
                                                                value="{{ $challenge->rank_point->leave }}"
                                                                class=" form-control" placeholder="">
                                                            @error('leave')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-10  col-6">
                                                        <label for="" class="form-label">Nội dung</label>
                                                        <textarea class="form-control " name="content" id="kt_docs_ckeditor_classic{{ $challenge->id }}" rows="3">
                                                        {{ $challenge->content }}
                                                    </textarea>
                                                        @error('content')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <script>
                                                        ClassicEditor
                                                            .create(document.querySelector('#kt_docs_ckeditor_classic{{ $challenge->id }}'))
                                                            .then(editor => {})
                                                            .catch(error => {});
                                                    </script>

                                                    <div class="form-group mb-10">
                                                        <label for="" class="form-label">Chọn mức độ bài thử thách
                                                        </label>
                                                        <select name="type" class="form-select" data-control="select2"
                                                            data-placeholder="Select an option">
                                                            <option @selected($challenge->type == 0) value="0">Dễ
                                                            </option>
                                                            <option @selected($challenge->type == 1) value="1">Trung bình
                                                            </option>
                                                            <option @selected($challenge->type == 2) value="2">Khó
                                                            </option>
                                                        </select>
                                                        @error('type')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Thoát
                                                    </button>
                                                    <button class="btn btn-primary">Lưu lại </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{ $challenges->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>
    </div>



@endsection
@section('page-script')

    <script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script>
        let url = '/admin/code-manager?';
        const _token = "{{ csrf_token() }}";
        $('.test_case').slideDown();
        $('.test_case').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        $('.form-select-status').on('change', function() {
            toastr.info('Đang chạy ....');
            var status = $(this).val();
            if (status == 1) {
                status = 0;
                $(this).val(0);
            } else {
                status = 1;
                $(this).val(1);
            }
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: '/admin/code-manager/update-status/' + id,
                data: {
                    _token: _token,
                    status: status
                },
                success: function(response) {
                    if (response) toastr.success('Thành công !');
                    if (!response) toastr.info('Không thành công !');
                }
            });
        });
    </script>
    <script>
        let url = "/admin/contests?{{ request()->has('type') ? 'type=' . request('type') : '' }}&";
        const _token = "{{ csrf_token() }}";
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script>
        formatPage.searchDataType('.select-language', 'language_id');
        formatPage.searchDataType('.select-type', 'type');
    </script>
@endsection
