@extends('layouts.main')
@section('title', 'Cập nhật ' . $contest_type_text)
@section('page-title', 'Cập nhật ' . $contest_type_text)
@section('content')

    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    @if (request('type') == 0)
                        <a href="{{ route('admin.contest.list') }}" class="pe-3">
                            Danh sách cuộc thi
                        </a>
                    @else
                        <a href="{{ route('admin.contest.list', ['type' => 1]) }}" class="pe-3">
                            Danh sách test năng lực
                        </a>
                    @endif
                </li>
                <li class="breadcrumb-item px-3 text-muted">Cập nhập {{ $contest_type_text . ' ' . $contest->name }} </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formContest"
                    action="{{ route('admin.contest.update', ['id' => $contest->id]) . '?type=' . request('type') ?? 0 }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tên {{ $contest_type_text }}</label>
                        <input type="text" name="name" value="{{ old('name', $contest->name) }}"
                            class=" form-control" placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">

                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian bắt đầu</label>
                                    <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->date_start)) }}"
                                        type="datetime-local" id="begin" max="" name="date_start"
                                        class="form-control" placeholder="">

                                    @error('date_start')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian kết thúc</label>
                                    <input
                                        value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->register_deadline)) }}"
                                        min="" type="datetime-local" name="register_deadline" id="end"
                                        class="form-control" placeholder="">
                                    @error('register_deadline')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @if (request('type') != config('util.TYPE_TEST'))
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian bắt đầu đăng ký</label>
                                        <input max="" min=""
                                            value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->start_register_time)) }}"
                                            type="datetime-local" name="start_register_time" id="start_time"
                                            class="form-control" placeholder="">
                                        @error('start_register_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian kết thúc đăng ký</label>
                                        <input min="" max=""
                                            value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->end_register_time)) }}"
                                            type="datetime-local" name="end_register_time" id="end_time"
                                            class="form-control" placeholder="">
                                        @error('end_register_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thuộc Chuyên Ngành</label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-placeholder="Select an option" tabindex="-1" aria-hidden="true"
                                        name="major_id">
                                        <option data-select2-id="select2-data-130-vofb"></option>
                                        @foreach ($major as $valueMajor)
                                            <option @selected($contest->major_id == $valueMajor->id) value="{{ $valueMajor->id }}">
                                                {{ $valueMajor->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('major_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                @if (request('type') != config('util.TYPE_TEST'))
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Giới hạn thành viên trong đội</label>
                                        <input value="{{ old('max_user', $contest->max_user) }}" name="max_user"
                                            type='number' class="form-control" />
                                    </div>
                                @endif
                                <div class="form-group ">
                                    <label for="" class="form-label">Ảnh {{ $contest_type_text }}</label>
                                    <input value="{{ old('img') }}" name="img" type='file' id="file-input"
                                        class="form-control" accept=".png, .jpg, .jpeg" />
                                    <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                        src="{{ $contest->img ? $contest->img : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }} " />
                                </div>
                            </div>

                        </div>

                    </div>
                    <label for="" class="form-label">Phần thưởng theo mức điểm</label>
                    <div class="row mb-5 pb-5">
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 1</label>
                                <input value="{{ old('top1', $rewardRankPoint->top1 ?? null) }}" name="top1"
                                    type='number' class="form-control" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 2</label>
                                <input value="{{ old('top2', $rewardRankPoint->top2 ?? null) }}" name="top2"
                                    type='number' class="form-control" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 3</label>
                                <input value="{{ old('top3', $rewardRankPoint->top3 ?? null) }}" name="top3"
                                    type='number' class="form-control" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Còn lại</label>
                                <input value="{{ old('leave', $rewardRankPoint->leave ?? null) }}" name="leave"
                                    type='number' class="form-control" />
                            </div>
                        </div>

                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Mô tả {{ $contest_type_text }}</label>
                        <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">
                            {{ $contest->description }}
                        </textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tin tức</label>
                        <textarea class="form-control" name="post_new" id="kt_docs_ckeditor_classic2" rows="3">
                            {{ $contest->post_new }}
                        </textarea>
                        @error('post_new')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="form-group mb-10">
                        <label class="form-label" for="">Trạng thái {{ $contest_type_text }}</label>
                        <select class="form-control" name="status" id="">
                            <option @selected($contest->status == 0) value="0"> Đóng {{ $contest_type_text }} </option>
                            <option @selected($contest->status == 1) value="1"> Mở đang Mở </option>
                        </select>
                    </div> --}}
                    {{-- @error('status')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror --}}
                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id=""
                            class="btn btn-success btn-lg btn-block">Lưu </button>
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
    <script src="assets/js/system/contest/form.js"></script>
    <script>
        pageCkeditor.classicCk2();

        dateAfterEdit('input[type=datetime-local]#begin', 'input[type=datetime-local]#end',
            'input[type=datetime-local]#start_time', 'input[type=datetime-local]#end_time')
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
