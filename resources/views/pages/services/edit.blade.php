@extends('layouts.main')
@section('title', 'Quản lý dịch vụ')
@section('page-title', 'Quản lý dịch vụ')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.service.list') }}" class="pe-3">
                        Danh sách dịch vụ
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới dịch vụ</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formservice" action="{{ route('admin.service.update', ['service'=> $service->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên dịch vụ</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name', $service->name) }}"/>
                                @error('name')
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
                                <img class="mw-10 mt-4 border rounded-3" style="max-height:350px" id="image-preview"
                                    src="{{ $service->thumbnail }}" />
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
                                <input type="text" name="link" class=" form-control" value="{{ old('link', $service->link) }}"/>
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
                                <label class="form-label" for="">Trạng thái</label>
                                <select name="status" class="form-control mb-2" >
                                    <option @selected($service->status == config('util.ACTIVE_STATUS')) value="{{config('util.ACTIVE_STATUS')}}">Active</option>
                                    <option @selected($service->status == config('util.INACTIVE_STATUS')) value="{{config('util.INACTIVE_STATUS')}}">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mô tả ngắn</label>
                                <textarea type="text" name="short_description" class="form-control" id="kt_docs_ckeditor_classic">
                                    {{ old('short_description', $service->short_description) }}
                                </textarea>
                                @error('short_description')
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
                                    {{ old('description', $service->description) }}
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