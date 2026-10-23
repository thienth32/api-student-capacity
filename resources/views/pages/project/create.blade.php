@extends('layouts.main')
@section('title', 'Quản lý dự án')
@section('page-title', 'Quản lý dự án')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.project.list') }}" class="pe-3">
                        Danh sách dự án
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới dự án</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formProject" action="{{ route('admin.project.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên dự án</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name') }}"/>
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
                                <label class="form-label" for="">Doanh nghiệp đồng hành</label>
                                <select id="select-enterprise" name="enterprise_ids[]" multiple class="form-select"
                                    data-control="select2" data-placeholder="Chọn doanh nghiệp">
                                    <option value="">Chọn doanh nghiệp</option>
                                    @foreach ($enterprises as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }} 
                                        </option>
                                    @endforeach
                                </select>
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
                                <label class="form-label" for="">Người thực hiện</label>
                                <input type="text" name="contact_name" class=" form-control" value="{{ old('contact_name') }}"/>
                                @error('contact_name')
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
                                <label class="form-label" for="">Mentors</label>
                                <select id="select-mentor" name="mentor_ids[]" multiple class="form-select"
                                    data-control="select2" data-placeholder="Chọn mentor">
                                    <option value="">Chọn mentor</option>
                                    @foreach ($mentors as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }} ({{$item->email}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Lĩnh vực</label>
                                <select id="select-topic" name="topic_ids[]" multiple class="form-select"
                                    data-control="select2" data-placeholder="Chọn lĩnh vực">
                                    <option value="">Chọn lĩnh vực</option>
                                    @foreach ($topics as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Trạng thái</label>
                                <select class="form-control" name="status" id="">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mô tả</label>
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
        $(document).ready(function() {
            $('#select-mentor').select2({
                closeOnSelect: false
            });
            $('#select-topic').select2({
                closeOnSelect: false
            });
            $('#select-enterprise').select2({
                closeOnSelect: false
            });
        });
    </script>
@endsection