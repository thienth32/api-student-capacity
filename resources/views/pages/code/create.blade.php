@extends('layouts.main')
@section('title', 'Quản lý bài thử thách')
@section('page-title', 'Quản lý bài thử thách')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.code.manager.list') }}" class="pe-3">
                        Danh sách bài thử thách
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới bài thử thách </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10  ">
                <form class="row" action="{{ route('admin.code.manager.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-6 row">
                        <div class="form-group mb-10 col-12">
                            <label for="" class="form-label">Tên thử thách </label>
                            <input type="text" name="name" value="{{ old('name') }}" class=" form-control"
                                placeholder="">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10 col-3">
                            <label for="" class="form-label">Top 1 </label>
                            <input type="number" min="0" name="top1" value="{{ old('top1') }}"
                                class=" form-control" placeholder="">
                            @error('top1')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10 col-3">
                            <label for="" class="form-label">Top 2 </label>
                            <input type="number" min="0" name="top2" value="{{ old('top2') }}"
                                class=" form-control" placeholder="">
                            @error('top2')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10 col-3">
                            <label for="" class="form-label">Top 3 </label>
                            <input type="number" min="0" name="top3" value="{{ old('top3') }}"
                                class=" form-control" placeholder="">
                            @error('top3')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10 col-3">
                            <label for="" class="form-label">Leave</label>
                            <input type="number" min="0" name="leave" value="{{ old('leave') }}"
                                class=" form-control" placeholder="">
                            @error('leave')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-10  col-6 ">
                        <label for="" class="form-label">Nội dung</label>
                        <textarea class="form-control " name="content" id="kt_docs_ckeditor_classic2" rows="3">
                            {{ old('content') }}
                        </textarea>
                        @error('content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10 col-12">
                        <!--begin::Repeater-->
                        <div id="test_case">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="test_case">
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="" class="form-label">Đầu vào </label>
                                                <input type="text" name="input" value="{{ old('input') }}"
                                                    class=" form-control" placeholder="">
                                                @error('input')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="form-label">Đầu ra </label>
                                                <input type="text" name="output" value="{{ old('output') }}"
                                                    class=" form-control" placeholder="">
                                                @error('output')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                    <input class="form-check-input" name="status" type="checkbox"
                                                        value="1" id="form_checkbox" />
                                                    <label class="form-check-label" for="form_checkbox">
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
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                    <i class="la la-plus"></i>Thêm mới
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->
                        @error('test_case')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Chọn mức độ bài thử thách </label>
                        <select name="type" class="form-select" data-control="select2"
                            data-placeholder="Select an option">
                            <option value="0">Dễ </option>
                            <option value="1">Trung bình </option>
                            <option value="2">Khó</option>
                        </select>
                        @error('type')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Chọn bộ ngôn ngữ </label>
                        <select name="languages[]" class="form-select" multiple data-control="select2"
                            data-placeholder="Select an option">
                            @foreach ($code_languages as $code_language)
                                <option value="{{ $code_language->id }}">{{ $code_language->name }}</option>
                            @endforeach
                        </select>
                        @error('languages')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id=""
                            class="btn btn-success btn-lg btn-block">Lưu
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection

@section('page-script')
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script>
        $('#test_case').repeater({
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
    </script>
@endsection
