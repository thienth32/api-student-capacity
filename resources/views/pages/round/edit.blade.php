@extends('layouts.main')
@section('title', 'Cập nhật vòng thi ')
@section('page-title', 'Cập nhật vòng thi')
@section('content')

    <div class="row">

        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formAddRound" action="{{ route('admin.round.update', ['id' => $round['id']]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group mb-10">
                        <label for="">Tên vòng thi</label>
                        <input type="text" name="name" value="{{ $round['name'] }}" class=" form-control" placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">

                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label for="">Thời gian bắt đầu</label>
                                    <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($round['start_time'])) }}"
                                        type="datetime-local" max="" name="start_time" class="form-control"
                                        placeholder="">
                                    @error('start_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label for="">Thời gian kết thúc</label>
                                    <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($round['end_time'])) }}"
                                        min="" type="datetime-local" name="end_time" id="" class="form-control"
                                        placeholder="">
                                    @error('end_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-10 ms-4">

                                    <label class="fs-6 fw-bold mb-3">
                                        <span>Ảnh vòng thi</span>

                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Allowed file types: png, jpg, jpeg."
                                            aria-label="Allowed file types: png, jpg, jpeg."></i>
                                    </label>
                                    @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-1">

                                        <div style="position: relative" class="image-input image-input-outline"
                                            data-kt-image-input="true"
                                            style="background-image: url('{{ $round['image'] !== null? $round['image']: 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">

                                            <div class="image-input-wrapper w-100px h-100px"
                                                style="background-image: url('{{ $round['image'] !== null? $round['image']: 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">
                                            </div>

                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>

                                                <input value="{{ old('image') }}" type="file" name="image"
                                                    accept=".png, .jpg, .jpeg">

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
                                data-placeholder="Select an option" tabindex="-1" aria-hidden="true" name="contest_id">
                                <option data-select2-id="select2-data-130-vofb"></option>
                                @foreach ($contests as $contest)
                                    <option @selected($round['contest_id'] == $contest->id) value="{{ $contest->id }}">
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
                                data-hide-search="false" data-placeholder="Select an option" tabindex="-1"
                                aria-hidden="true" name="type_exam_id" value="{{ old('type_exam_id') }}">
                                <option data-select2-id="select2-data-130-vofb"></option>
                                @foreach ($type_exams as $typeexam)
                                    <option @selected($round['type_exam_id'] == $typeexam->id) value="{{ $typeexam->id }}">
                                        {{ $typeexam->name }}</option>
                                @endforeach
                            </select>
                            @error('type_exam_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group mb-10">
                        <label for="">Mô tả cuộc thi</label>
                        <textarea class="form-control" name="description" id="" rows="3">
                            {{ $round['description'] }}
                        </textarea>
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
        $("#formAddRound").validate({
            onkeyup: true,
            rules: {
                name: {
                    required: true,
                    maxlength: 255
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
