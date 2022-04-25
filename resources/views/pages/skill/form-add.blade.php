@extends('layouts.main')
@section('title', 'Thêm kỹ năng')
@section('page-title', 'Thêm kỹ năng')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formAddRound" action="{{ route('admin.skill.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-10">
                        <label for="">Tên kỹ năng</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" form-control" placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">


                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label for="">Mã kỹ năng</label>
                                    <input type="text" name="short_name" value="{{ old('short_name') }}"
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
                                        <option value="0">
                                            Không có chuyên ngành
                                        </option>
                                        @foreach ($dataMajor as $itemMajor)
                                            @php
                                                $dash = '';
                                            @endphp
                                            <option @selected(request('major_id') == $itemMajor->id) value="{{ $itemMajor->id }}">
                                                Ngành: {{ $itemMajor->name }}
                                            </option>
                                            @include(
                                                'pages.major.include.listSelecterChislAdd',
                                                ['majorPrent' => $itemMajor]
                                            )
                                        @endforeach
                                    </select>

                                    @error('major_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="" class="form-label">Ảnh kỹ năng</label>
                                    <input name="image_url" type='file' id="file-input" accept=".png, .jpg, .jpeg"
                                        class="form-control" />
                                    <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                        src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />

                                </div>
                                @error('image_url')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>



                    </div>

                    <div class="form-group mb-10">
                        <label for="">Mô tả kỹ năng</label>
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

@section('page-script')
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
    </script>
@endsection
