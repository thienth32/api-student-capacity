@extends('layouts.main')
@section('title', 'Quản lý bộ câu hỏi')
@section('page-title', 'Quản lý bộ câu hỏi')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.question.index') }}" class="pe-3">
                        Danh sách câu hỏi
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Cập nhập câu hỏi </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">

                <form id="formQuestion" action="{{ route('admin.question.update', ['id' => $question->id]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-10">
                        <label for="" class="form-label">Nội dung câu hỏi</label>
                        <textarea class="form-control " name="content" id="kt_docs_ckeditor_classic" rows="3">
                            {{ old('content', $question->content) }}
                        </textarea>
                        @error('content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group pb-10 position-relative skill">
                                <label for="" class="form-label">Skill câu hỏi</label>
                                <select multiple class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" data-placeholder="Chọn skill cho câu hỏi" tabindex="-1"
                                    aria-hidden="true" name="skill[]" value="{{ old('skill[]') }}">
                                    <option data-select2-id="select2-data-130-vofb"></option>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                            {{ collect(old('skill'))->contains($skill->id) ? 'selected' : '' }}
                                            @if ($question->skills) @foreach ($question->skills as $q_skil)
                                                {{ $q_skil->id == $skill->id ? 'selected' : '' }}
                                            @endforeach @endif>
                                            {{ $skill->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('skill*')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <style>
                                    .skill label.error {
                                        left: 0;
                                        position: absolute;
                                        bottom: 16px;
                                    }
                                </style>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group pb-10">
                                <label for="" class="form-label">Mức độ</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="true" data-placeholder="Chọn rank cho câu hỏi" tabindex="-1"
                                    aria-hidden="true" name="rank" value="{{ old('rank') }}">
                                    <option {{ old('rank', $question->rank) == 0 ? 'selected' : '' }} value="0">
                                        Dễ
                                    </option>
                                    <option {{ old('rank', $question->rank) == 1 ? 'selected' : '' }} value="1">
                                        Trung bình
                                    </option>
                                    <option {{ old('rank', $question->rank) == 2 ? 'selected' : '' }} value="2">
                                        Khó
                                    </option>
                                </select>
                                @error('rank')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group pb-10">
                                <label for="" class="form-label">Thể loại câu hỏi</label>
                                <select class="answer-select form-select mb-2 select2-hidden-accessible"
                                    data-control="select2" data-hide-search="true" data-placeholder="Chọn trạng thái"
                                    tabindex="-1" aria-hidden="true" name="type" value="{{ old('type') }}">
                                    <option data-select2-id="select2-data-130-vofb"></option>
                                    <option {{ old('type', $question->type) == 0 ? 'selected' : '' }} value="0">
                                        Một đáp án
                                    </option>
                                    <option {{ old('type', $question->type) == 1 ? 'selected' : '' }} value="1">
                                        Nhiều đáp
                                        án
                                    </option>
                                </select>
                                @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group pb-10">
                                <label for="" class="form-label">Trạng thái </label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="true" data-placeholder="Chọn trạng thái" tabindex="-1"
                                    aria-hidden="true" name="status" value="{{ old('status') }}">
                                    <option data-select2-id="select2-data-130-vofb"></option>
                                    <option {{ old('status') == 0 ? 'selected' : '' }} value="0">Không kích hoạt
                                    </option>
                                    <option selected {{ old('status') == 1 ? 'selected' : '' }} value="1">Kích hoạt
                                    </option>
                                </select>
                                @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!--begin::Repeater-->
                    <div id="kt_docs_repeater_basic">
                        <div class="d-flex justify-content-start align-content-center mb-10">
                            <h4 class="me-10  mt-3">
                                Đáp án
                            </h4>
                            <div class="form-group ">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                    <i class="la la-plus"></i>Thêm nội dung đáp án
                                </a>
                            </div>
                        </div>
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div data-repeater-list="answers">
                                @if (count($question->answers) > 0)
                                    @foreach ($question->answers as $i => $answer)
                                        <div data-repeater-item>
                                            <div class="form-group row pb-5">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nội dung đáp án</label>
                                                    <input value="{{ old("answers.$i.content", $answer->content) }}"
                                                        name="content" type="text" class="form-control mb-2 mb-md-0" />
                                                    <input hidden value="{{ $answer->id }}" name="answer_id"
                                                        type="text" />
                                                    @if ($errors->has("answers.$i.content"))
                                                        <p class="text-danger">
                                                            {{ $errors->first("answers.$i.content") }}
                                                        </p>
                                                    @endif
                                                </div>
                                                {{-- || $answer->is_correct == 1 --}}
                                                <div class="col-md-2">
                                                    <div
                                                        class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                        <label class="form-check-label">
                                                            {{-- @if ($answer->is_correct == 1)
                                                                <input name="is_correct" class="form-check-input is_correct"
                                                                    checked type="radio" value="1" />
                                                            @else
                                                                <input name="is_correct" class="form-check-input is_correct"
                                                                    type="radio" value="1" />
                                                            @endif --}}
                                                            <input name="is_correct" class="form-check-input is_correct"
                                                                {{ $answer->is_correct == 1 ? 'checked' : '' }}
                                                                type="radio" value="1" />
                                                            Đúng
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <a href="javascript:;" data-repeater-delete
                                                        class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                        <i class="la la-trash-o"></i>Xóa
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @for ($i = 0; $i < 3; $i++)
                                        <div data-repeater-item>
                                            <div class="form-group row pb-5">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nội dung đáp án</label>
                                                    <input value="{{ old("answers.$i.content") }}" name="content"
                                                        type="text" class="form-control mb-2 mb-md-0" />
                                                    @if ($errors->has("answers.$i.content"))
                                                        <p class="text-danger">
                                                            {{ $errors->first("answers.$i.content") }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-md-2">
                                                    <div
                                                        class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                        <label class="form-check-label">
                                                            <input name="is_correct" class="form-check-input is_correct"
                                                                {{ $i == 2 ? 'checked' : '' }} type="radio"
                                                                value="1" />
                                                            Đúng
                                                        </label>
                                                    </div>
                                                </div>
                                                @if ($i == 0)
                                                    <div class="col-md-4">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="la la-trash-o"></i>Xóa
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                                @if (session()->has('errorAnswerConten'))
                                    <p class="text-danger">{{ session()->get('errorAnswerConten') }}</p>
                                    @php
                                        Session::forget('errorAnswerConten');
                                    @endphp
                                @endif
                            </div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <!--end::Form group-->
                    </div>
                    <!--end::Repeater-->
                    <div class="form-group mb-10 mt-10">
                        <button type="submit" class="btn btn-success btn-lg btn-block">Lưu </button>
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

    <script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="assets/js/system/form-repeater/basic.js"></script>

    <script src="{{ asset('assets/js/system/question/index.js') }}"></script>
    <script src="{{ asset('assets/js/system/question/questionValidate.js') }}"></script>
    <script src="{{ asset('assets/js/system/validate/validate.js') }}"></script>
    <script>
        question.selectAnswer();
        question.inputCheckedRadioClick();
    </script>
@endsection
