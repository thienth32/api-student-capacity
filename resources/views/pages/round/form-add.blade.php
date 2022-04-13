@extends('layouts.main')
@section('title', 'Thêm vòng thi')
@section('page-title', 'Thêm vòng thi')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formAddRound" action="{{ route('admin.round.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-10">
                        <label for="">Tên vòng thi</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" form-control" placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">


                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label for="">Thời gian bắt đầu</label>
                                    <input id="begin" max="" type="datetime-local" value="{{ old('start_time') }}"
                                        name="start_time" class="form-control " placeholder="">
                                    @error('start_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">

                                    <label for="">Thời gian kết thúc</label>
                                    <input id="end" min="" type="datetime-local" name="end_time"
                                        value="{{ old('end_time') }}" class="form-control  "
                                        placeholder="Pick date rage" />
                                    @error('end_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">

                                    <label for="" class="form-label">Thuộc cuộc thi</label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="contest_id"
                                        value="{{ old('contest_id') }}">
                                        @foreach ($contests as $contest)
                                            <option @selected(request()->has('contest_id') && request('contest_id') == $contest->id) value="{{ $contest->id }}">
                                                {{ $contest->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('contest_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">

                                    <label for="" class="form-label">Thể loại cuộc thi</label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="type_exam_id"
                                        value="{{ old('type_exam_id') }}">

                                        @foreach ($typeexams as $typeexam)
                                            <option value="{{ $typeexam->id }}"> {{ $typeexam->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('type_exam_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="" class="form-label">Ảnh cuộc thi</label>
                                    <input name="image" type='file' id="file-input" accept=".png, .jpg, .jpeg"
                                        class="form-control" />
                                    <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                        src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="form-group mb-10">
                        <label for="">Mô tả cuộc thi</label>
                        <textarea class="form-control" name="description" id="" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id="" class="btn btn-success btn-lg btn-block">Lưu </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('page-script')
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/date-after/date-after.js"></script>
    <script src="assets/js/system/round/form.js"></script>
    <script>
        rules.image = {
            required: true,
        };
        messages.image = {
            required: 'Chưa nhập trường này !',
        };
        dateAfter('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
