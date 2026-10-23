@extends('layouts.main')
@section('title', 'Quản lý đặc quyền')
@section('page-title', 'Quản lý đặc quyền')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.privilege.list') }}" class="pe-3">
                        Danh sách đặc quyền
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới đặc quyền</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formPrivilege" action="{{ route('admin.privilege.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên đặc quyền</label>
                                <input type="text" name="title" class=" form-control" value="{{ old('title') }}"/>
                                @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Ảnh bìa</label>
                                <input name="thumbnail" type='file' id="file-input" class="form-control" />
                                <img class="mw-10 mt-4 border rounded-3" id="image-preview"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                                @error('thumbnail')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Link đăng ký</label>
                                <input type="text" name="link" class=" form-control" value="{{ old('link') }}"/>
                                @error('link')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Hạn đăng ký</label>
                                <input type="date" name="register_deadline" class=" form-control" value="{{ old('register_deadline') }}"/>
                                @error('register_deadline')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Hạn sử dụng</label>
                                <input type="date" name="expire_date" class=" form-control" value="{{ old('expire_date') }}"/>
                                @error('expire_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mô tả ngắn</label>
                                <textarea type="text" name="short_description" class="form-control" id="kt_docs_ckeditor_classic"> 
                                    {{ old('short_description') }}
                                </textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mô tả đầy đủ</label>
                                <textarea type="text" name="description" class="form-control" id="kt_docs_ckeditor_classic2"> 
                                    {{ old('description') }}
                                </textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-10 ">
                        <button type="submit" id="buttonQA" class="btn btn-success btn-lg btn-block">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session()->has('userArray'))
        @php
            $userArray = session()->get('userArray');
            Session::forget('userArray');
        @endphp
    @endif
@endsection
@section('page-script')
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
    </script>
@endsection