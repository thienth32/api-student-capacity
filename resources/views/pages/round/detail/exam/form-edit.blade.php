@extends('layouts.main')
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
                        <a href="{{ route('admin.contest.list') . '?type=1' }}" class="pe-3">Danh sách đánh giá năng lực
                        </a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.contest.show.capatity', ['id' => $round->contest->id]) }}" class="pe-3">
                            Capacity :{{ $round->contest->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item px-3 text-muted">Chỉnh sửa đề thi</li>
            </ol>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <form id="myForm"
                    action="{{ route('admin.exam.update', ['id_exam' => $exam->id, 'id' => $round->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Tên đề bài</label>
                                <input value="{{ $exam->name }}" type="text" name="name" id=""
                                    class="form-control" placeholder="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Mô tả đề thi</label>
                                <textarea class="form-control" name="description" id="" rows="3">
                                    {{ trim($exam->description) }}
                                </textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Điểm tối đa</label>
                                <input value="{{ $exam->max_ponit }}" type="text" name="max_ponit" id=""
                                    class="form-control" placeholder="">
                                @error('max_ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Điểm qua vòng thi</label>
                                <input value="{{ $exam->ponit }}" type="text" name="ponit" id=""
                                    class="form-control" placeholder="">
                                @error('ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            @if ($round->contest->type == config('util.TYPE_CONTEST'))
                                <div class="form-group mb-4">
                                    <label class="form-label" for="">File đề thi</label>
                                    <input type="file" name="external_url" id="" class="form-control"
                                        placeholder="">
                                    @error('external_url')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        {{-- <div class="col-lg-12 row">

                            @if ($round->contest->type == config('util.TYPE_TEST'))
                                <div class="col-lg-6 form-group mb-4">
                                    <label class="form-label" for="">Kiểu thi </label>
                                    <select id="select-contest" name="time_type"
                                        class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" tabindex="-1" aria-hidden="true">
                                        @forelse (config('util.TYPE_TIMES') as $time)
                                            <option @selected($exam->time_type == $time['TYPE']) value="{{ $time['TYPE'] }}">
                                                {{ $time['VALUE'] }}
                                            </option>
                                        @empty
                                            <option disabled>Không có cuộc thi</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group mb-4">
                                    <label class="form-label" for="">Thời gian </label>
                                    <input type="number" value="{{ $exam->time }}" name="time" class="form-control"
                                        placeholder="">
                                    @error('time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div> --}}
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
            extension: "zip,docx,word|file",
            filesize: 1048576
        }
        messages.external_url = {
            extension: "Định dạng là zip,docx,word..",
            filesize: 'Dung lượng không quá 10MB'
        }
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
