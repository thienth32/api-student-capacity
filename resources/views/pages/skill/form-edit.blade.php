@extends('layouts.main')
@section('title', 'sửa kỹ năng')
@section('page-title', 'sửa kỹ năng')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formAddRound" action="{{ route('admin.skill.update', $data->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-10">
                        <label for="">Tên kỹ năng</label>
                        <input type="text" name="name" value="{{ $data->name }}" class=" form-control" placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">


                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label for="">Mã kỹ năng</label>
                                    <input type="text" name="short_name" value="{{ $data->short_name }}"
                                        class=" form-control" placeholder="">
                                    @error('short_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">

                                    <label for="" class="form-label">Thuộc chuyên ngành</label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="major_id"
                                        value="{{ old('major_id') }}">
                                        @foreach ($dataMajor as $Major)
                                            <option @selected($data->majorSkill[0]->id == $Major->id) value="{{ $Major->id }}">Chuyên ngành:
                                                {{ $Major->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" value="{{ $data->majorSkill[0]->id }}" name="oldMajor">
                                    @error('major_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group mb-10 ms-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-3">
                                        <span>Ảnh kỹ năng</span>
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
                                            style="background-image: url('{{ Storage::disk('google')->has($data->image_url)? Storage::disk('google')->url($data->image_url): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-100px h-100px"
                                                style="background-image: url('{{ Storage::disk('google')->has($data->image_url)? Storage::disk('google')->url($data->image_url): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">
                                            </div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Edit-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input value="{{ $data->image_url }}" type="file" name="image_url"
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



                    </div>

                    <div class="form-group mb-10">
                        <label for="">Mô tả kỹ năng</label>
                        <textarea class="form-control" name="description" id="" rows="3">{{ $data->description }}</textarea>
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

@endsection
