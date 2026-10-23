@extends('layouts.main')
@section('title', 'Quản lý thiết lập')
@section('page-title', 'Quản lý thiết lập')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.stat.list') }}" class="pe-3">
                        Danh sách thiết lập
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formStat" action="{{ route('admin.stat.store', ['type' => $type] ) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($type == 1)
                    <h1>Thêm thống số count up</h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name') }}"/>
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
                                <label class="form-label" for="">Icon</label>
                                <input name="icon" type='file' id="file-input" class="form-control" />
                                <img class="mt-4 border rounded-3" style="max-height:50px" id="image-preview"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                                @error('icon')
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
                                <label class="form-label" for="">Giá trị</label>
                                <input type="number" name="data[0][value]" class=" form-control" value="{{ old('data[0][value]') }}"/>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Đơn vị đo</label>
                                <input type="text" name="data[0][unit]" class=" form-control" value="{{ old('data[0][unit]') }}"/>
                            </div>
                        </div>
                    </div>
                    @elseif ($type == 2)
                    <h1>Thêm card thông tin (bên dưới banner)</h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên thông số</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name') }}"/>
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
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Icon</label>
                                <input name="icon" type='file' id="file-input" class="form-control" />
                                <img class="mt-4 border rounded-3" style="max-height:250px" id="image-preview"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                                @error('icon')
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
                    <label for="">Danh sách nút bấm</label>
                    <div id="buttons-wrapper">
                        <div class="button-item border p-3 mb-2 row align-items-end">
                            <div class="col-4">
                                <label>Tiêu đề</label>
                                <input type="text" name="data[0][label]" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Đường dẫn (URL)</label>
                                <input type="text" name="data[0][url]" class="form-control">
                            </div>
                            <div class="col-2">
                                <button type="button" class="col-2 btn btn-success w-100" id="add-button">Add Button</button>
                            </div>
                        </div>
                    </div>
                    @else
                    <h1>Thêm phần ngày hội việc làm</h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên thông số</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name') }}"/>
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
                                <label class="form-label" for="">Icon</label>
                                <input name="icon" type='file' id="file-input" class="form-control" />
                                <img class="mt-4 border rounded-3" style="max-height:250px" id="image-preview"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                                @error('icon')
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
                                <label class="form-label" for="">Mô tả</label>
                                <textarea type="text" name="data[0][description]" class="form-control" id="kt_docs_ckeditor_classic2">
                                    {{ old('data[0][description]') }}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    @endif

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

        //thêm nút bấm trong form type == 2 
        let index = 1;
        document.getElementById('add-button').addEventListener('click', function () {

            const wrapper = document.getElementById('buttons-wrapper');

            const html = `
                <div class="button-item border p-3 mb-2 row align-items-end">
                    <div class="col-4">
                        <label>Tiêu đề</label>
                        <input type="text" name="data[${index}][label]" class="form-control">
                    </div>
                    <div class="col-6">
                        <label>Đường dẫn (URL)</label>
                        <input type="text" name="data[${index}][url]" class="form-control">
                    </div>
                    <div class="col-2">
                        <button type="button" class="remove-btn col-2 btn btn-danger w-100">Remove</button>
                    </div>
                </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', html);

            index++;
        });

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('remove-btn')){
                e.target.closest('.button-item').remove();
            }
        });
    </script>
@endsection
