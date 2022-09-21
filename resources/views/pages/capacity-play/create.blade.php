@extends('layouts.main')
@section('title', 'Thêm mới trò chơi trực tiếp ')
@section('page-title', 'Thêm mới trò chơi trực tiếp ')
@section('content')

    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h1>Thêm mới trò chơi trực tiếp | <a href="{{ route('admin.capacit.play.index') }}"> Quản lý </a>
                    </h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-flush h-lg-100 p-10">

                    <form id="formAddSlider" action="{{ route('admin.capacit.play.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <label class="form-label">Tên trò chơi </label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    placeholder="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-4 row ">
                                <div class="col-12">
                                    <label class="form-label">Số điểm </label>
                                    <input type="number" min="0" name="max_ponit" value="{{ old('max_ponit') }}"
                                        class=" form-control" placeholder="">
                                    @error('max_ponit')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12">
                                </div>

                            </div>
                            <div class="col-12 pb-2">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="">Mô tả trò chơi</label>
                                    <textarea class="form-control" name="description" id="" rows="3"></textarea>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 pb-2">
                                <div class="form-group mb-4">
                                    <label for="" class="form-label">Hình thức chọ bộ câu hỏi </label>
                                    <select multiple class="form-select" data-control="select2" name="questions[]"
                                        data-placeholder="Select an option">
                                        @foreach ($questions as $question)
                                            <option value="{{ $question->id }}">
                                                {{ $question->content }} -
                                                {{ $question->type == 1 ? 'Nhiều câu trả lời' : 'Một câu trả lời' }} -
                                                {{ ($question->rank == 0 ? 'Dễ' : $question->rank == 1) ? 'Trung bình' : 'Khó ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('questions')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-10 ">
                            <button type="submit" class="btn btn-success btn-lg btn-block">Lưu
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('page-script')
@endsection
