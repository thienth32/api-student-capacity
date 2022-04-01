@extends('layouts.main')
@section('title', 'Thêm vòng thi')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Thêm mới vòng thi</h1>
        </div>
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
                                    <input value="{{ old('start_time') }}" type="datetime-local" max="" name="start_time"
                                        class="form-control" placeholder="">
                                    @error('start_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label for="">Thời gian kết thúc</label>
                                    <input value="{{ old('end_time') }}" min="" type="datetime-local" name="end_time"
                                        id="" class="form-control" placeholder="">
                                    @error('end_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-10 ms-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-3">
                                        <span>Ảnh vòng thi</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Allowed file types: png, jpg, jpeg."
                                            aria-label="Allowed file types: png, jpg, jpeg."></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Image input wrapper-->
                                    <div class="mt-1">
                                        <!--begin::Image input-->
                                        <div style="position: relative" class="image-input image-input-outline"
                                            data-kt-image-input="true"
                                            style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-100px h-100px"
                                                style="background-image: url('assets/media/svg/avatars/blank.svg')"></div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Edit-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input value="{{ old('image') }}" type="file" name="image"
                                                    accept=".png, .jpg, .jpeg">
                                                {{-- <input type="hidden" name="avatar_remove"> --}}
                                                <!--end::Inputs-->
                                                <style>
                                                    label#image-error {
                                                        position: absolute;
                                                        min-width: 150px;
                                                        top: 500%;
                                                        right: -100%;
                                                    }

                                                </style>
                                            </label>
                                            <!--end::Edit-->
                                            <!--begin::Cancel-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                    </div>
                                    <!--end::Image input wrapper-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-10">

                            <label for="" class="form-label">Thuộc cuộc thi</label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="contest_id"
                                value="{{ old('contest_id') }}">
                                @foreach ($contests as $contest)
                                    <option value="{{ $contest->id }}"> {{ $contest->name }}</option>
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

                    <div class="form-group mb-10">
                        <label for="">Mô tả cuộc thi</label>
                        <textarea class="form-control" name="description" id="" rows="3"></textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label">Mô tả cuộc thi</label>

                        <div class="ql-toolbar ql-snow"><span class="ql-formats"><span class="ql-header ql-picker"><span
                                        class="ql-picker-label" tabindex="0" role="button" aria-expanded="false"
                                        aria-controls="ql-picker-options-1"><svg viewBox="0 0 18 18">
                                            <polygon class="ql-stroke" points="7 11 9 13 11 11 7 11"></polygon>
                                            <polygon class="ql-stroke" points="7 7 9 5 11 7 7 7"></polygon>
                                        </svg></span><span class="ql-picker-options" aria-hidden="true" tabindex="-1"
                                        id="ql-picker-options-1"><span tabindex="0" role="button" class="ql-picker-item"
                                            data-value="1"></span><span tabindex="0" role="button" class="ql-picker-item"
                                            data-value="2"></span><span tabindex="0" role="button"
                                            class="ql-picker-item ql-selected"></span></span></span><select
                                    class="ql-header" style="display: none;">
                                    <option value="1"></option>
                                    <option value="2"></option>
                                    <option selected="selected"></option>
                                </select></span><span class="ql-formats"><button type="button"
                                    class="ql-bold"><svg viewBox="0 0 18 18">
                                        <path class="ql-stroke"
                                            d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                        </path>
                                        <path class="ql-stroke"
                                            d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                        </path>
                                    </svg></button><button type="button" class="ql-italic"><svg viewBox="0 0 18 18">
                                        <line class="ql-stroke" x1="7" x2="13" y1="4" y2="4"></line>
                                        <line class="ql-stroke" x1="5" x2="11" y1="14" y2="14"></line>
                                        <line class="ql-stroke" x1="8" x2="10" y1="14" y2="4"></line>
                                    </svg></button><button type="button" class="ql-underline"><svg viewBox="0 0 18 18">
                                        <path class="ql-stroke"
                                            d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3"></path>
                                        <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="12" x="3" y="15">
                                        </rect>
                                    </svg></button></span><span class="ql-formats"><button type="button"
                                    class="ql-image"><svg viewBox="0 0 18 18">
                                        <rect class="ql-stroke" height="10" width="12" x="3" y="4"></rect>
                                        <circle class="ql-fill" cx="6" cy="7" r="1"></circle>
                                        <polyline class="ql-even ql-fill" points="5 12 5 11 7 9 8 10 11 7 13 9 13 12 5 12">
                                        </polyline>
                                    </svg></button><button type="button" class="ql-code-block"><svg viewBox="0 0 18 18">
                                        <polyline class="ql-even ql-stroke" points="5 7 3 9 5 11"></polyline>
                                        <polyline class="ql-even ql-stroke" points="13 7 15 9 13 11"></polyline>
                                        <line class="ql-stroke" x1="10" x2="8" y1="5" y2="13"></line>
                                    </svg></button></span></div>
                        <div id="kt_ecommerce_add_product_meta_description" name="kt_ecommerce_add_product_meta_description"
                            class="min-h-100px mb-2 ql-container ql-snow">
                            <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true">
                                <p><br></p>
                            </div>
                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                            <div class="ql-tooltip ql-hidden"><a class="ql-preview" rel="noopener noreferrer"
                                    target="_blank" href="about:blank"></a>
                                <input type="text" value="" name="description" data-formula="e=mc^2"
                                    data-link="https://quilljs.com" data-video="Embed URL">
                                <a class="ql-action"></a><a class="ql-remove"></a>
                            </div>
                        </div>
                        <!--end::Editor-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Set a meta tag description to the product for increased SEO ranking.
                        </div>
                        <!--end::Description-->
                    </div> --}}
                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id="" class="btn btn-success btn-lg btn-block">Lưu </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('js_admin')

    <script>
        $("#formAddRound").validate({
            onkeyup: true,
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                image: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                },
                description: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Chưa nhập trường này !',
                    maxlength: 'Tối đa là 255 kí tự !'
                },
                image: {
                    required: 'Chưa nhập trường này !',
                },
                start_time: {
                    required: 'Chưa nhập trường này !',
                    date: true
                },
                end_time: {
                    required: 'Chưa nhập trường này !',
                    date: true
                },
                description: {
                    required: 'Chưa nhập trường này !',
                },
            },
        });
    </script>


@endsection
