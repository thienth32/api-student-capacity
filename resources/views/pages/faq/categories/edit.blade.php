@extends('layouts.main')
@section('title', 'Cập nhật danh mục Q&A')
@section('page-title', 'Cập nhật danh mục Q&A')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formQA" action="{{ route('admin.faq_category.update', ['faqCategory' => $faqCategory->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên danh mục</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name', $faqCategory->name) }}"/>
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
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="parent_id" value="{{ old('parent_id', $faqCategory->parent_id) }}">
                                    <option disabled>Chọn danh mục cha</option>
                                    <option @selected($faqCategory->parent_id == null) value="">Không có danh mục cha</option>
                                    @foreach ($parentCates as $cate)
                                        <option @selected($faqCategory->parent_id == $cate->id) value="{{ $cate->id }}">{{ $cate->name }}</option>
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
