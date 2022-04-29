@extends('layouts.main')
@section('title', 'Chấm điểm đội thi')
@section('page-title', 'Chấm điểm đội thi')
@section('content')
    <div class=" card card-flush p-5">
        {{-- Breadcrumb --}}
        <div class=" mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb text-muted fs-6 fw-bold">
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 ">
                            <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}"
                                class="pe-3">
                                {{ $round->contest->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.round.list') }}" class="pe-3">Vòng thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}">
                                {{ $round->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail.team', ['id' => $round->id]) }}"> Đội thi</a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            {{ $team->name }}
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            Chấm bài
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- Main --}}
        <div>
            <div class="row mb-4">
                <div class="col-6">
                    <h2>Đề bài {{ $takeExam->exam->name }}</h2>
                    <iframe width="100%" height="100%"
                        src="https://drive.google.com/file/d/{{ explode(
                            '=',
                            explode('&', explode('?', Storage::disk('google')->url($takeExam->exam->external_url))[1])[0],
                        )[1] }}/preview"></iframe>
                </div>
                <div class="col-6 row ">
                    <div class="col-12">

                        <h2>Mô tả </h2>
                        <div>{{ $takeExam->exam->description }}</div>
                    </div>
                    <div class="col-12">
                        <p>Vòng thi : {{ $round->name }}</p>
                        <p>Thang điểm : {{ $takeExam->exam->max_ponit }}</p>
                        <p>Điểm pass : {{ $takeExam->exam->ponit }}</p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row mt-4">
                <div class="col-6">
                    <h2>Bài làm :</h2>
                    @if (Storage::disk('google')->has($takeExam->result_url))
                        <iframe width="100%" height="100%"
                            src="https://drive.google.com/file/d/{{ explode('=', explode('&', explode('?', Storage::disk('google')->url($takeExam->result_url))[1])[0])[1] }}/preview"></iframe>
                    @else
                        {{ $takeExam->result_url }}
                    @endif
                </div>
                <div class="col-6">
                    @if (count($takeExam->evaluations) > 0)
                        <h2>Chấm điểm :</h2>
                        <form
                            action="{{ route('admin.round.detail.team.update.make.exam', ['id' => $round->id, 'teamId' => $team->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-input">
                                <label for="" class="form-label">Điểm </label>
                                <input value="{{ $takeExam->evaluations[0]->ponit }}" min="0"
                                    max="{{ $takeExam->exam->max_ponit }}" type="number" name="ponit"
                                    placeholder="Nhập điểm" class="form-control">
                                @error('ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="" class="form-label">Nhận xét</label>
                                <textarea name="comment" class="textarea form-control">{{ $takeExam->evaluations[0]->comment }}</textarea>
                                @error('comment')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="" class="form-label">Tình trạng</label>
                                <select class=" select2-hidden-accessible" data-control="select2" data-hide-search="false"
                                    tabindex="-1" aria-hidden="true" name="status" value="{{ old('status') }}">
                                    <option @selected($takeExam->evaluations[0]->status == 1) value="1"> Mở</option>
                                    <option @selected($takeExam->evaluations[0]->status == 0) value="0"> Khóa </option>
                                </select>
                                @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <br>
                            <button class="btn btn-success">Cập nhật điểm</button>
                        </form>
                    @else
                        <h2>Chấm điểm :</h2>
                        <form
                            action="{{ route('admin.round.detail.team.final.make.exam', ['id' => $round->id, 'teamId' => $team->id]) }}"
                            method="POST">
                            @csrf
                            <div class="form-input">
                                <label for="" class="form-label">Điểm </label>
                                <input value="{{ old('ponit') }}" min="0" max="{{ $takeExam->exam->max_ponit }}"
                                    type="number" name="ponit" placeholder="Nhập điểm" class="form-control">
                                @error('ponit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="" class="form-label">Nhận xét</label>
                                <textarea name="comment" class="textarea form-control"></textarea>
                                @error('comment')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="" class="form-label">Tình trạng</label>
                                <select class=" select2-hidden-accessible" data-control="select2" data-hide-search="false"
                                    tabindex="-1" aria-hidden="true" name="status" value="{{ old('status') }}">
                                    <option value="1"> Mở</option>
                                    <option value="0"> Khóa </option>
                                </select>
                                @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <br>
                            <button class="btn btn-success">Xác nhận</button>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection
@section('page-script')
    <script>
        var URL = '{{ url()->current() }}' + '?';
        var userArray = [];
        var _token = "{{ csrf_token() }}";
    </script>
    <script>

    </script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
