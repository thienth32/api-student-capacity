@extends('layouts.main')
@section('title', 'Chỉnh đề thi')
@section('page-title', 'Chỉnh đề thi ')
@section('content')
    <div class=" card card-flush p-5">
        <div class=" mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb text-muted fs-6 fw-bold">
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 ">
                            <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}"
                                class="pe-3">
                                {{ $round->contest->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.round.list') }}" class="pe-3">Vòng thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}">
                                {{ $round->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.exam.index', ['id' => $round->id]) }}">
                                Danh sách đề
                            </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">Chỉnh sửa đề thi</li>
                    </ol>
                </div>

            </div>
        </div>


    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <form id="myForm" action="{{ route('admin.exam.update', ['id_exam' => $exam->id, 'id' => $round->id]) }}"
                    method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Tên đề bài</label>
                                <input value="{{ $exam->name }}" type="text" name="name" id="" class="form-control"
                                    placeholder="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Mô tả đề thi</label>
                                <textarea class="form-control" name="description" id="" rows="3">
                                    {{ trim($exam->description) }}
                                </textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Điểm tối đa</label>
                                <input value="{{ $exam->max_ponit }}" type="text" name="max_ponit" id=""
                                    class="form-control" placeholder="">
                                @error('max_ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Điểm qua vòng thi</label>
                                <input value="{{ $exam->ponit }}" type="text" name="ponit" id="" class="form-control"
                                    placeholder="">
                                @error('ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="">File đề thi</label>
                                <input type="file" name="external_url" id="" class="form-control" placeholder="">
                                @error('external_url')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>


        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/js/system/exam/validateForm.js"></script>
    <script>
        rules.external_url = {
            extension: "zip,docx,word|file",
            filesize: 1048576
        }
        messages.external_url = {
            extension: "Định dạng là zip,docx,word..",
            filesize: 'Dung lượng không quá 10MB'
        }
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
