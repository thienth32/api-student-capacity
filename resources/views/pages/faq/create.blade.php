@extends('layouts.main')
@section('title', 'Quản lý Q&A')
@section('page-title', 'Quản lý Q&A')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.faq.list') }}" class="pe-3">
                        Danh sách Q&A
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới câu hỏi</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formQA" action="{{ route('admin.faq.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Câu hỏi</label>
                                <textarea type="text" id="kt_docs_ckeditor_classic" name="question" class=" form-control"
                                    rows="3"></textarea>
                                @error('question')
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
                                <label for="" class="form-label">Danh mục</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="category_id">
                                    <option value="" disabled selected>Chọn danh mục</option>
                                    @foreach ($categories as $root)
                                        <option value="{{$root->id}}"> {{ $root->name }} </option>
                                        @foreach ($root->children as $child)
                                            <option value="{{$child->id}}">&nbsp;&nbsp;&nbsp;&nbsp;└─ {{$child->name}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Câu trả lời</label>
                                <textarea type="text" id="kt_docs_ckeditor_classic2" name="answer" class=" form-control"
                                    rows="3"></textarea>
                                @error('answer')
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
                        <button type="submit" id="buttonQA" class="btn btn-success btn-lg btn-block">Lưu </button>
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
    <link rel="stylesheet" href="{{ asset('assets/js/system/ckeditor/ckeditor5.css') }}">
    <script type="module" src="{{ asset('assets/js/system/ckeditor/ckeditorUploadImage.js') }}"></script>
    <script src="{{ asset('assets/js/system/question-and-answer/validateForm.js') }}"></script>
    <script src="{{ asset('assets/js/system/validate/validate.js') }}"></script>
@endsection
