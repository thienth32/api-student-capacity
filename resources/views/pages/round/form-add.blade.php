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
                                    <input type="datetime-local" value="{{ old('start_time') }}" name="start_time"
                                        class="form-control " placeholder="">
                                    @error('start_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">

                                    <label for="">Thời gian kết thúc</label>
                                    <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                                        class="form-control  " placeholder="Pick date rage" />


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

@section('js_admin')
    <script>

    </script>
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
