@extends('layouts.main')
@section('title', 'Cập nhật cuộc thi ')
@section('page-title', 'Cập nhật cuộc thi')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formContest" action="{{ route('admin.contest.update', ['id' => $Contest->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tên vòng thi</label>
                        <input type="text" name="name" value="{{ $Contest->name }}" class=" form-control" placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">

                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian bắt đầu</label>
                                    <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($Contest->date_start)) }}"
                                        type="datetime-local" id="begin" max="" name="date_start" class="form-control"
                                        placeholder="">

                                    @error('date_start')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian kết thúc</label>
                                    <input
                                        value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($Contest->register_deadline)) }}"
                                        min="" type="datetime-local" name="register_deadline" id="end"
                                        class="form-control" placeholder="">
                                    @error('register_deadline')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-10 ms-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-3">
                                        <span>Ảnh Cuộc thi</span>
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
                                            style="background-image: url('{{ $Contest->img? $Contest->img: 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-100px h-100px"
                                                style="background-image: url('{{ $Contest->img? $Contest->img: 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">
                                            </div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Edit-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input value="{{ old('img') }}" type="file" name="img"
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
                            <label for="" class="form-label">Thuộc Chuyên Ngành</label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-placeholder="Select an option" tabindex="-1" aria-hidden="true" name="major_id">
                                <option data-select2-id="select2-data-130-vofb"></option>
                                @foreach ($major as $valueMajor)
                                    <option @selected($Contest->major_id == $valueMajor->id) value="{{ $valueMajor->id }}">
                                        {{ $valueMajor->name }}</option>
                                @endforeach
                            </select>
                            @error('major_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Mô tả cuộc thi</label>
                        <textarea class="form-control" name="description" id="" rows="3">
                            {{ $Contest->description }}
                        </textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Trạng thái cuộc thi</label>
                        <select class="form-control" name="status" id="">
                            <option @selected($Contest->status == 0) value="0"> Đóng Cuộc thi </option>
                            <option @selected($Contest->status == 1) value="1"> Mở đang Mở </option>
                        </select>
                    </div>
                    @error('status')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
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
    <script src="assets/js/system/contest/form.js"></script>
    <script>
        dateAfterEdit('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
