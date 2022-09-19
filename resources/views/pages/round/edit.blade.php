@extends('layouts.main')
@section('title', 'Cập nhật ' . $nameContestType)
@section('page-title', 'Cập nhật ' . $nameContestType)
@section('content')

    <div class="row">

        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formAddRound"
                    action="{{ route('admin.round.update', ['id' => $round['id'], 'type' => request('type') ? request('type') : 0]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tên {{ $nameContestType }}</label>
                        <input type="text" name="name" value="{{ $round['name'] }}" class=" form-control"
                            placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">

                        <div class="row">
                            <div class="col-8">
                                <div>
                                    <input type="hidden" name="start_time" value="{{ $round['start_time'] }}">
                                    <input type="hidden" name="end_time" value="{{ $round['end_time'] }}">

                                </div>
                                @if ($round['start_time'] > now())
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian bắt đầu & thời gian kết thúc
                                        </label>
                                        <input name="app1" class="form-control form-control-solid"
                                            placeholder="Pick date rage" id="app1" />
                                        @error('start_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('end_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @else
                                    <!--begin::Alert-->
                                    <div class="alert alert-warning">
                                        <!--begin::Icon-->
                                        <span class="svg-icon svg-icon-2hx svg-icon-primary me-3"><i
                                                class="bi bi-bell-fill"></i></span>
                                        <!--end::Icon-->

                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column">
                                            <!--begin::Title-->
                                            <h4 class="mb-1 text-dark">{{ \Str::title($nameContestType) }} đang diễn ra
                                                hoặc đã diễn
                                                ra </h4>
                                            <!--end::Title-->
                                            <!--begin::Content-->
                                            <span>Thời gian bắt đầu đã bắt đầu vào {{ $round['start_time'] }} và sẽ không
                                                thể thay đổi !</span>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Alert-->

                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian kết thúc</label>
                                        <input type="text" value="{{ $round['end_time'] }}"
                                            class="form-control form-control-solid" name="app0" />
                                        @error('end_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

                                {{-- <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian bắt đầu</label>
                                    <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($round['start_time'])) }}"
                                        type="datetime-local" id="begin" max="" name="start_time"
                                        class="form-control" placeholder="">
                                    @error('start_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian kết thúc</label>
                                    <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($round['end_time'])) }}"
                                        id="end" min="" type="datetime-local" name="end_time"
                                        class="form-control" placeholder="">
                                    @error('end_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                <div class="form-group mb-10">

                                    <label for="" class="form-label">Thuộc cuộc thi</label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-placeholder="Select an option" tabindex="-1" aria-hidden="true"
                                        name="contest_id">
                                        <option data-select2-id="select2-data-130-vofb"></option>
                                        @foreach ($contests as $contest)
                                            <option @selected($round['contest_id'] == $contest->id) value="{{ $contest->id }}">
                                                {{ $contest->name }} -
                                                {{ $contest->date_start }}
                                                ->
                                                {{ $contest->register_deadline }}</option>
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
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="" class="form-label">Ảnh {{ $nameContestType }}</label>
                                    <input value="{{ old('image') }}" name="image" type='file' id="file-input"
                                        class="form-control" accept=".png, .jpg, .jpeg" />
                                    @error('image')
                                        <p class="text-danger">{{ $message }} </p>
                                    @enderror
                                    <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                        src="{{ $round['image'] !== null ? $round['image'] : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }} " />
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="form-group mb-10">
                        <label class="form-label" for="">Mô tả {{ $nameContestType }}</label>
                        <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">
                            {{ $round['description'] }}
                        </textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
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
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>

    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/date-after/date-after.js"></script>
    <script src="assets/js/system/round/form.js"></script>
    <script>
        dateAfterEdit('input[type=datetime-local]#begin', 'input[type=datetime-local]#end');
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>

@endsection
