@extends('layouts.main')
@if ($round->contest->type !== 1)
    @section('title', 'Quản lý cuộc thi')
    @section('page-title', 'Quản lý cuộc thi ')
@else
    @section('title', 'Quản lý test năng lực')
    @section('page-title', 'Quản lý test năng lực ')
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

                <li class="breadcrumb-item px-3 text-muted">Thêm mới đề thi</li>
            </ol>
        </div>

    </div>
    <div class=" card card-flush  p-5">
        <div class="row">
            <div class="col-lg-12">
                <form id="myForm" action="{{ route('admin.exam.store', ['id' => $round->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Tên đề bài</label>
                                <input type="text" name="name" value="{{ old('name') }}" id=""
                                    class="form-control" placeholder="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Mô tả đề thi</label>
                                <textarea class="form-control" name="description" id="" rows="3">
                                   {{ old('description') }}
                                </textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Điểm tối đa</label>
                                <input value="{{ old('max_ponit') }}" type="text" name="max_ponit" id=""
                                    class="form-control" placeholder="">
                                @error('max_ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Điểm qua vòng thi</label>
                                <input type="text" value="{{ old('ponit') }}" name="ponit" id=""
                                    class="form-control" placeholder="">
                                @error('ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            @if ($round->contest->type == config('util.TYPE_CONTEST'))
                                <div class="form-group mb-4">
                                    <label class="form-label" for="">File đề thi</label>
                                    <input type="file" name="external_url" id=""
                                        value="{{ old('external_url') }}" class="form-control" placeholder="">
                                    @error('external_url')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                        </div>
                        @if ($round->contest->type == config('util.TYPE_TEST'))
                            <div class="col-lg-12 row form-group mb-4">
                                <div class="col-lg-6 form-group mb-4">
                                    <label class="form-label" for="">Kiểu thi </label>
                                    <select id="select-contest" name="time_type"
                                        class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" tabindex="-1" aria-hidden="true">
                                        @forelse (config('util.TYPE_TIMES') as $time)
                                            <option @selected(old('time_type') == $time['TYPE']) value="{{ $time['TYPE'] }}">
                                                {{ $time['VALUE'] }}
                                            </option>
                                        @empty
                                            <option disabled>Không có cuộc thi</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group mb-4">
                                    <label class="form-label" for="">Thời gian </label>
                                    <input type="number" value="{{ old('time') }}" name="time" class="form-control"
                                        placeholder="">
                                    @error('time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/js/system/exam/validateForm.js"></script>
    <script>
        rules.external_url = {
            required: true,
            extension: "zip,docx,word|file",
            filesize: 1048576
        }
        messages.external_url: {
            required: "Chưa nhập trường này !",
            extension: "Định dạng là zip,docx,word..",
            filesize: 'Dung lượng không quá 10MB'
        },
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
