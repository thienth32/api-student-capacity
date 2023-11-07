@extends('layouts.main')
@section('title', 'Quản lý kỹ năng ')
@section('page-title', 'Quản lý kỹ năng')
@section('content')

    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.skill.index') }}" class="pe-3">
                        Danh sách kĩ năng
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Cập nhập kĩ năng : {{ $data->name }} </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formSkill" action="{{ route('admin.skill.update', $data->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-10">
                        <label class=" form-label"for="">Tên kỹ năng</label>
                        <input type="text" name="name" value="{{ $data->name }}" class=" form-control"
                            placeholder="">
                        @error('name')
                            <p id="checkname" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">


                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label class=" form-label"for="">Mã kỹ năng</label>
                                    <input type="text" name="short_name" value="{{ $data->short_name }}"
                                        class=" form-control" placeholder="">
                                    @error('short_name')
                                        <p id="checkshort_name" class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thuộc chuyên ngành</label>
                                    <select multiple class="form-select mb-2 select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" tabindex="-1" aria-hidden="true"
                                        name="major_id[]" value="{{ serialize(old('major_id')) }}">
                                        @foreach ($dataMajor as $itemMajor)
                                            @php
                                                $dash = '';
                                            @endphp
                                            <option
                                                @foreach ($data->majorSkill as $item) @if ($item->id == $itemMajor->id)
                                        {{ 'selected="selected"' }} @endif @endforeach
                                                value="{{ $itemMajor->id }}">
                                                Ngành: {{ $itemMajor->name }}
                                            </option>
                                            @include('pages.skill.include.listSelecterChisl', [
                                                'majorPrent' => $itemMajor,
                                                'major' => $data,
                                            ])
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-10">
                                    <label class=" form-label"for="">Mô tả kỹ năng</label>
                                    <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">{{ $data->description }}</textarea>
                                    {{-- <textarea class="form-control" name="description" id="" rows="3">{{ $data->description }}</textarea> --}}
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="" class="form-label">Ảnh kỹ năng</label>
                                    <input value="{{ old('image_url') }}" name="image_url" type='file' id="file-input"
                                        class="form-control" accept=".png, .jpg, .jpeg" />
                                    <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                        src="{{ $data->image_url ? $data->image_url : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}" />
                                </div>
                            </div>

                        </div>



                    </div>


                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id="" class="btn btn-success btn-lg btn-block">Lưu
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
    <script type="text/javascript" src="assets/js/custom/documentation/general/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/skill/form.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
