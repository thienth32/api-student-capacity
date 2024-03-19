@extends('layouts.main')
dd($round)
@if ($round->contest->type !== 1)
    @section('title', 'Quản lý cuộc thi')
    @section('page-title', 'Quản lý cuộc thi ')
@else
    @section('title', 'Quản lý đánh giá năng lực')
    @section('page-title', 'Quản lý đánh giá năng lực ')
@endif
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                @if ($round->contest->type !== 1)
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.list') }}" class="pe-3">Danh sách cuộc thi </a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}" class="pe-3">
                            {{ $round->contest->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.detail.round', ['id' => $round->contest->id], 'contest_id=' . $round->contest->id) }}"
                            class="pe-3">Danh sách vòng thi </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">
                        <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}">
                            {{ $round->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.exam.index', ['id' => $round->id]) }}">
                            Danh sách đề
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.list') . '?type=1' }}" class="pe-3">Danh sách test năng
                            lực </a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.contest.show.capatity', ['id' => $round->contest->id]) }}" class="pe-3">
                            Capacity {{ $round->contest->name }}
                        </a>
                    </li>
                @endif

                <li class="breadcrumb-item px-3 text-muted">Thêm nhanh đề thi</li>
            </ol>
        </div>

    </div>
    <div class=" card card-flush  p-5">
        <div class="row">
            <div class="col-lg-12">
                <form id="myForm" action="{{ route('admin.round.quick-add-exam', ['id' => $round->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Chọn kỹ năng liên quan</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" multiple tabindex="-1" aria-hidden="true" name="skill[]"
                                    value="{{ old('skill') }}">
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}"> {{ $skill->name }}</option>
                                    @endforeach
                                </select>
                                @error('skill')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Số đề thi sẽ tạo</label>
                                <input value="{{ old('total_exam') }}" type="number" name="total_exam" id=""
                                    class="form-control" placeholder="">
                                @error('total_exam')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 row">
                            <div class="col-lg-4 form-group mb-4">
                                <label class="form-label" for="">Số câu hỏi dễ</label>
                                <input value="{{ old('total_easy') }}" type="text" name="total_easy" id=""
                                    class="form-control" placeholder="">
                                @error('total_easy')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-lg-4 form-group mb-4">
                                <label class="form-label" for="">Số câu hỏi trung bình</label>
                                <input value="{{ old('total_medium') }}" type="text" name="total_medium" id=""
                                    class="form-control" placeholder="">
                                @error('total_medium')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-lg-4 form-group mb-4">
                                <label class="form-label" for="">Số câu hỏi khó</label>
                                <input value="{{ old('total_hard') }}" type="text" name="total_hard" id=""
                                    class="form-control" placeholder="">
                                @error('total_hard')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/js/system/quick-exam/validateForm.js"></script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
