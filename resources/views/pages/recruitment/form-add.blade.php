@extends('layouts.main')
@section('title', 'Quản lý tuyển dụng ')
@section('page-title', 'Quản lý tuyển dụng ')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.recruitment.list') }}" class="pe-3">
                        Danh sách tuyển dụng
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới tuyển dụng </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formRecruitment" action="{{ route('admin.recruitment.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-10">
                        <label class="form-label"for="">Tiêu đề tuyển dụng</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" form-control"
                            placeholder="">
                        @error('name')
                            <p id="checkname" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">




                        <div class="col-8">

                            <div class="form-group mb-10">
                                <label class="form-label" for="">Thời gian bắt đầu</label>
                                <input id="begin" max="" type="datetime-local" value="{{ old('start_time') }}"
                                    name="start_time" class="form-control " placeholder="">
                                @error('start_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="form-group mb-10">

                                <label class="form-label" for="">Thời gian kết thúc</label>
                                <input id="end" min="" type="datetime-local" name="end_time"
                                    value="{{ old('end_time') }}" class="form-control  " placeholder="Pick date rage" />
                                @error('end_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-10">
                                <label class="form-label" for="">Số lượng tuyển dụng</label>
                                <input min="1" type="number" value="{{ old('amount') }}" name="amount"
                                    class="form-control " placeholder="">
                                @error('amount')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Lương tuyển dụng</label>
                                <input min="1" type="number" value="{{ old('cost') }}" name="cost"
                                    class="form-control " placeholder="">
                                @error('cost')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Doanh nghiệp tuyển dụng</label>
                                <select placeholder="Chọn" multiple class="form-select mb-2 select2-hidden-accessible"
                                    data-control="select2" data-hide-search="false" tabindex="-1" aria-hidden="true"
                                    name="enterprise_id[]" value="{{ serialize(old('enterprise_id')) }}">
                                    @foreach ($enterprise as $item)
                                        <option {{ collect(old('enterprise_id'))->contains($item->id) ? 'selected' : '' }}
                                            value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>



                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Chọn phần test năng lực</label>
                                <select placeholder="Chọn" multiple class="form-select mb-2 select2-hidden-accessible"
                                    data-control="select2" data-hide-search="false" tabindex="-1" aria-hidden="true"
                                    name="contest_id[]" value="{{ serialize(old('contest_id')) }}">
                                    @foreach ($contest as $item)
                                        <option {{ collect(old('contest_id'))->contains($item->id) ? 'selected' : '' }}
                                            value="{{ $item->id }} ">
                                            {{ $item->name }} @if (count($item->skills) > 0)
                                                (
                                                <ol class="breadcrumb text-muted fs-6 fw-bold">
                                                    @foreach ($item->skills as $skill)
                                                        <li class="breadcrumb-item px-3 text-muted">
                                                            {{ $skill->name }} /</li>
                                                    @endforeach

                                                </ol>

                                                )
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="form-group ">
                                <label for="" class="form-label">Ảnh tuyển dụng</label>
                                <input name="image" type='file' id="file-input" accept=".png, .jpg, .jpeg"
                                    class="form-control" />
                                <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />

                            </div>
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>







                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Mô tả ngắn tuyển dụng</label>
                        <textarea class="form-control" name="short_description" id="kt_docs_ckeditor_classic2" rows="3">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Thông tin tuyển dụng</label>
                        <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id=""
                            class="btn btn-success btn-lg btn-block">Lưu
                        </button>
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
        rules.image = {
            required: true,
        };
        messages.image = {
            required: 'Chưa nhập trường này !',
        };
        preview.showFile('#file-input', '#image-preview');
        dateAfter('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
