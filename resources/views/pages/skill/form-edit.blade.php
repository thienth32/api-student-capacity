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
                                            @php
                                                $dash = '';
                                            @endphp
                                            <option @selected($data->majorSkill->first()->id == $Major->id) value="{{ $Major->id }}">Chuyên
                                                ngành:
                                                {{ $Major->name }}</option>
                                            @include(
                                                'pages.skill.include.listSelecterChisl',
                                                ['majorPrent' => $Major, 'major' => $data]
                                            )
                                        @endforeach

                                        {{-- @foreach ($dataMajor as $Major)
                                            <option @selected($data->majorSkill[0]->id == $Major->id) value="{{ $Major->id }}">Chuyên ngành:
                                                {{ $Major->name }}</option>
                                            @foreach ($Major['parent_chils'] as $child)
                                                <option @selected($data->majorSkill[0]->id == $child->id) value="{{ $child->id }}">
                                                    ---- Ngành: {{ $child->name }}
                                                </option>
                                                {{-- <li style="padding-left: 15px;padding-top:25px"> {{ $child->slug }}</li> --}}
                                        {{-- @endforeach --}}
                                        {{-- @endforeach --}}
                                    </select>
                                    <input type="hidden" value="{{ $data->majorSkill[0]->id }}" name="oldMajor">
                                    @error('major_id')
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
                                        src="{{ Storage::disk('google')->has($data->image_url)? Storage::disk('google')->url($data->image_url): 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}" />
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
    <script src="assets/js/system/preview-file/previewImg.js"></script>

    <script>
        preview.showFile('#file-input', '#image-preview');
    </script>
@endsection
