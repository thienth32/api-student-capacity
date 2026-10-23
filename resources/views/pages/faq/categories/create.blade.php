@extends('layouts.main')
@section('title', 'Quản lý danh mục Q&A')
@section('page-title', 'Quản lý danh mục Q&A')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.faq_category.list') }}" class="pe-3">
                        Danh sách danh mục Q&A
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới danh mục</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formQA" action="{{ route('admin.faq_category.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên danh mục</label>
                                <input type="text" name="name" class=" form-control" />
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
                                <label for="" class="form-label">Danh mục cha</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="parent_id">
                                    <option disabled>Chọn danh mục cha</option>
                                    <option value="">Không có danh mục cha</option>
                                    @foreach ($parentCates as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                    @endforeach
                                </select>
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
