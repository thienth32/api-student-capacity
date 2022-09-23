@extends('layouts.main')
@section('title', 'Quản lý từ khóa tìm kiếm')
@section('page-title', 'Quản lý từ khóa tìm kiếm')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.keyword.list') }}" class="pe-3">
                        Danh sách từ khóa tìm kiếm
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới từ khóa tìm kiếm </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formKeyword" action="{{ route('admin.keyword.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="form-group mb-10">
                        <label for="">Từ khóa</label>
                        <input type="text" name="keyword" value="{{ old('keyword') }}" class=" form-control"
                            placeholder="">
                        @error('keyword')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label for="">Từ khóa không dấu</label>
                        <input readonly='true' type="text" name="keyword_en" value="{{ old('keyword_en') }}"
                            class=" form-control" placeholder="">
                        @error('keyword_en')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label for="">Slug</label>
                        <input readonly='true' type="text" name="keyword_slug" value="{{ old('keyword_slug') }}"
                            class=" form-control" placeholder="">
                        @error('keyword_slug')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Loại tìm kiếm</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="true" tabindex="-1" aria-hidden="true" name="type"
                                    value="{{ old('type') }}">
                                    <option value="{{ config('util.TYPE_POSTS') }}"> Bài viết</option>
                                    <option value="{{ config('util.TYPE_RECRUITMENTS') }}"> Tuyển dụng</option>
                                    <option value="{{ config('util.TYPE_CAPACITY_TEST') }}"> Test năng lực</option>
                                </select>
                                @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Trạng thái</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="true" tabindex="-1" aria-hidden="true" name="status"
                                    value="{{ old('status') }}">

                                    <option value="{{ config('util.INACTIVE_STATUS') }}"> Không kích hoạt</option>
                                    <option selected value="{{ config('util.ACTIVE_STATUS') }}"> Kích hoạt</option>

                                </select>
                                @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id="" class="btn btn-success btn-lg btn-block">Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/js/system/keyword/keyword.js"></script>
    <script src="assets/js/system/keyword/form.js"></script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script>
        keyword.changeSlug();
    </script>
@endsection
