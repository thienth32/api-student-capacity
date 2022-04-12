@extends('layouts.main')
@section('title', 'Thêm mới slider ')
@section('page-title', 'Thêm mới slider ')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">

                <form id="formAddSlider" action="{{ route('admin.sliders.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="text-center">

                        <img class="pb-4" style="max-height:200px , width: 100%" id="previewImg">

                    </div>
                    <div>
                        <label for="" class="form-label">Ảnh</label>
                        <input name="image_url" type="file" class="file-change form-control">
                        @error('image_url')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="" class="form-label">Hình thức lọc ảnh </label>
                        <select class="form-select" data-control="select2" data-placeholder="Select an option">
                            <option value="1">Dạng cột </option>
                            <option value="2">Dạng ngang </option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group mb-10">
                                <label class="form-label">Thời gian bắt đầu</label>
                                <input id="begin" max="" type="datetime-local" value="{{ old('start_time') }}"
                                    name="start_time" class="form-control " placeholder="">
                                @error('start_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">

                                <label class="form-label">Thời gian kết thúc</label>
                                <input id="end" min="" type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                                    class="form-control  " placeholder="Pick date rage" />
                                @error('end_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 row ">
                            <div class="col-12">
                                <label class="form-label">URL chuyển hướng </label>
                                <input type=" text" name="link_to" value="{{ old('link_to') }}" class=" form-control"
                                    placeholder="">
                                @error('link_to')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Chuyên ngành</label>
                                <select name="major_id" class="form-select " data-control="select2"
                                    data-placeholder="Chọn chuyên ngành ">
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
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

    <script src="assets/js/system/date-after/date-after.js"></script>
    <script src="assets/js/system/slider/form.js"></script>
    <script>
        rules.image_url = {
            required: true,
        }
        messages.image_url = {
            required: "Chưa nhập trường này !",
        }
        dateAfter('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
