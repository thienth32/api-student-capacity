@extends('layouts.main')
@section('title', 'Thêm ' . $nameTypeContest)
@section('page-title', 'Thêm ' . $nameTypeContest)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formAddRound"
                    action="{{ route('admin.round.store', ['type' => request()->has('type') ? request('type') : config('util.TYPE_CONTEST')]) }}{{ request()->has('contest_id') ? '&contestHasId=' . request('contest_id') : '' }}"
                    method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tên {{ $nameTypeContest }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" form-control"
                            placeholder="">

                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="row">
                        <div class="col-8">
                            <div>
                                <input type="hidden" name="start_time"
                                    value="{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addDays(3)->format('Y/m/d h:i:s') }}">
                                <input type="hidden" name="end_time"
                                    value="{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addDays(5)->format('Y/m/d h:i:s') }}">

                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Thời gian bắt đầu & thời gian kết thúc </label>
                                <input id="app1" name="app1" class="form-control form-control-solid"
                                    placeholder="Pick date rage" />
                                @error('start_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @error('end_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian bắt đầu</label>
                                    <input id="begin" max="" type="datetime-local"
                                        value="{{ old('start_time') }}" name="start_time" class="form-control "
                        placeholder="">
                        @error('start_time')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group mb-10">

                        <label class="form-label" for="">Thời gian kết thúc</label>
                        <input id="end" min="" type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                            class="form-control  " placeholder="Pick date rage" />
                        @error('end_time')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div> --}}
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Thuộc cuộc thi (CT) & đánh giá năng lực
                                    (TNL)</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="contest_id"
                                    value="{{ old('contest_id') }}">
                                    @foreach ($contests as $contest)
                                        <option @selected(request()->has('contest_id') && request('contest_id') == $contest->id) value="{{ $contest->id }}">
                                            {{ $contest->type == 0 ? 'CT-' : 'TNL-' }}
                                            {{ $contest->name }} -
                                            {{ $contest->date_start }}
                                            ->
                                            {{ $contest->register_deadline }}
                                        </option>
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
                            @if (request()->has('type') && request('type') == config('util.TYPE_TEST'))
                                <div class="col-lg-12 row form-group mb-4">
                                    <div class="col-lg-6 form-group mb-4">
                                        <label class="form-label" for="">Kiểu thi </label>
                                        <select id="select-contest" name="time_type_exam"
                                            class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                            data-hide-search="false" tabindex="-1" aria-hidden="true">
                                            @forelse (config('util.TYPE_TIMES') as $time)
                                                <option @selected(old('time_type_exam') == $time['TYPE']) value="{{ $time['TYPE'] }}">
                                                    {{ $time['VALUE'] }}
                                                </option>
                                            @empty
                                                <option disabled>Không có cuộc thi</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group mb-4">
                                        <label class="form-label" for="">Thời gian </label>
                                        <input type="number" value="{{ old('time_exam') }}" name="time_exam"
                                            class="form-control" placeholder="">
                                        @error('time_exam')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 form-group mb-4">
                                        <label class="form-label" for="">Số câu hỏi cho đề trắc nghiệm </label>
                                        <input type="number" value="{{ old('max_questions_exam') }}"
                                            name="max_questions_exam" class="form-control" placeholder="">
                                        @error('max_questions_exam')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 form-group mb-4">
                                        <label class="form-label" for="">Cho phép truy cập từ bên ngoài</label>
                                        <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                                data-hide-search="false" data-placeholder="Select an option" tabindex="-1"
                                                aria-hidden="true" name="access_from_outside" value="{{ old('access_from_outside') }}">
                                            <option data-select2-id="select2-data-130-vofb"></option>
                                            <option
                                                value="0"
                                                @selected(old('time_type_exam') == 0)
                                            >Không cho phép</option>
                                            <option
                                                value="1"
                                                @selected(old('time_type_exam') == 1)
                                            >Cho phép</option>
                                        </select>
                                        @error('access_from_outside')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                        </div>
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="" class="form-label">Ảnh đại diện {{ $nameTypeContest }}</label>
                                <input id="file-input" name="image" type='file' accept=".png, .jpg, .jpeg"
                                    class="form-control" />
                                <img id="image-preview" class="w-100 mt-4 border rounded-3"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                            </div>
                        </div>

                    </div>



                    <div class="form-group mb-10">
                        <label class="form-label" for="">Mô tả {{ $nameTypeContest }}</label>
                        <textarea id="kt_docs_ckeditor_classic" class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mb-10 ">
                        <button id="" type="submit" name=""
                            class="btn btn-success btn-lg btn-block">Lưu
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
    <script src="assets/js/system/date-after/date-after.js"></script>
    <script src="assets/js/system/round/form.js"></script>
    <script>
        rules.image = {
            required: true,
        };
        messages.image = {
            required: 'Chưa nhập trường này !',
        };
        dateAfter('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
