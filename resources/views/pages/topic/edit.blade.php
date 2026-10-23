@extends('layouts.main')
@section('title', 'Quản lý lĩnh vực')
@section('page-title', 'Quản lý lĩnh vực')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.topic.list') }}" class="pe-3">
                        Danh sách lĩnh vực
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Chỉnh sửa lĩnh vực</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formTopic" action="{{ route('admin.topic.update', ['topic'=> $topic->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <h1>Ngày hội việc làm</h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name', $topic->name) }}"/>
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

