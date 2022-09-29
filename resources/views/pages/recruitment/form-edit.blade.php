@extends('layouts.main')
@section('title', 'Quản lý tuyển dụng ')
@section('page-title', 'Quản lý tuyển dụng ')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formRecruitment" action="{{ route('admin.recruitment.update', $data->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-10">
                        <label for="">Tiêu đề tuyển dụng</label>
                        <input type="text" name="name" value="{{ $data->name }}" class=" form-control"
                            placeholder="">
                        @error('name')
                            <p id="checkname" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">




                        <div class="col-8">

                            <div class="form-group mb-10">
                                <label class="form-label" for="">Thời gian bắt đầu</label>
                                <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($data['start_time'])) }}"
                                    type="datetime-local" min="" id="begin" max="" name="start_time"
                                    class="form-control" placeholder="">
                                @error('start_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="form-group mb-10">

                                <label class="form-label" for="">Thời gian kết thúc</label>
                                <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($data['end_time'])) }}"
                                    id="end" min="" type="datetime-local" name="end_time" class="form-control"
                                    placeholder="">
                                @error('end_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Số lượng tuyển dụng</label>
                                <input min="1" type="number" value="{{ $data->amount }}" name="amount"
                                    class="form-control " placeholder="">
                                @error('amount')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Lương tuyển dụng</label>
                                <input min="1" type="number" value="{{ $data->cost }}" name="cost"
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
                                    @foreach ($enterprises as $item)
                                        <option
                                            @foreach ($data->enterprise as $value) @if ($value->id == $item->id)
                                        {{ 'selected="selected"' }} @endif @endforeach
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
                                    @foreach ($contests as $item)
                                        <option
                                            @foreach ($data->contest as $value)
                                             @if ($value->id == $item->id)
                                                {{ 'selected="selected"' }}
                                                 @endif @endforeach
                                            value="{{ $item->id }}">
                                            {{ $item->name }}
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
                                    src="{{ $data->image ? $data->image : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}" />
                            </div>
                        </div>








                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Mô tả ngắn tuyển dụng</label>
                        <textarea class="form-control" name="short_description" id="kt_docs_ckeditor_classic2" rows="3">{{ $data->short_description }}</textarea>
                        @error('short_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label for="">Thông tin tuyển dụng</label>
                        <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">{{ $data->description }}</textarea>
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
    <script src="assets/js/system/recruitment/formEdit.js"></script>
    <script src="assets/js/system/recruitment/date-after.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
        dateAfterEdit('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
