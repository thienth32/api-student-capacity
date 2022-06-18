@extends('layouts.main')
@section('title', 'Thêm tuyển dụng')
@section('page-title', 'Thêm tuyển dụng')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formRecruitment" action="{{ route('admin.recruitment.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-10">
                        <label for="">Tiêu đề tuyển dụng</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" form-control" placeholder="">
                        @error('name')
                            <p id="checkname" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">



                        <div class="row">
                            <div class="col-6">

                                <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian bắt đầu</label>
                                    <input id="begin" max="" type="datetime-local" value="{{ old('start_time') }}"
                                        name="start_time" class="form-control " placeholder="">
                                    @error('start_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                </div>


                            </div>
                            <div class="col-6">
                                <div class="form-group mb-10">

                                    <label class="form-label" for="">Thời gian kết thúc</label>
                                    <input id="end" min="" type="datetime-local" name="end_time"
                                        value="{{ old('end_time') }}" class="form-control  "
                                        placeholder="Pick date rage" />
                                    @error('end_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>




                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Doanh nghiệp tuyển dụng</label>
                        <select placeholder="Chọn" multiple class="form-select mb-2 select2-hidden-accessible"
                            data-control="select2" data-hide-search="false" tabindex="-1" aria-hidden="true"
                            name="enterprise_id[]" value="{{ old('enterprise_id') }}">
                            @foreach ($enterprise as $item)
                                <option @selected(request('enterprise_id') == $item->id) value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>



                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Chọn phần test năng lực</label>
                        <select placeholder="Chọn" multiple class="form-select mb-2 select2-hidden-accessible"
                            data-control="select2" data-hide-search="false" tabindex="-1" aria-hidden="true"
                            name="contest_id[]" value="{{ old('contest_id') }}">
                            @foreach ($contest as $item)
                                <option @selected(request('contest_id') == $item->id) value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-10">
                        <label for="">Thông tin tuyển dụng</label>
                        <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">{{ old('description') }}</textarea>
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
    <script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/recruitment/form.js"></script>
    <script src="assets/js/system/recruitment/date-after.js"></script>
    <script>
        dateAfter('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
