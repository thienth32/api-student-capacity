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
                            <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}" class="pe-3">
                                {{ $round->contest->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.detail.round', ['id' => $round->contest_id]) }}"
                                class="pe-3">Vòng thi </a>
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
                            <a
                                href="{{ route('admin.round.detail.team.detail', ['id' => $round->id, 'teamId' => $team->id]) }}">
                                {{ $team->name }}</a>

                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            Chấm bài
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- Main --}}
        @if ($takeExam != null)

            <div>
                <div class="row mb-4">
                    <div class="col-6">

                        <h2>Đề bài {{ $takeExam->exam->name }}
                            @if (Storage::disk('s3')->has($takeExam->exam->external_url ?? 'ABC'))
                                <a href="{{ route('dowload.file') }}?url={{ $takeExam->exam->external_url }}"
                                    target="_blank" class="  btn btn-outline-primary">Tải về </a>
                            @endif
                        </h2>
                        <div>
                            @if (!\Storage::disk('s3')->has($takeExam->exam->external_url ?? 'ABC'))
                                <b>Đề bài: </b>
                                {{ $takeExam->exam->external_url }}
                            @endif
                        </div>

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
                        <h2>Bài làm đội thi : {{ $team->name }}
                            @if ($takeExam->result_url == null)
                                @if (\Storage::disk('s3')->has($takeExam->file_url ?? 'ABC'))
                                    <a target="_blank" href="{{ route('dowload.file') }}?url={{ $takeExam->file_url }}"
                                        class="  btn btn-outline-primary">Tải về </a>
                                @endif
                            @endif
                        </h2>
                        @if ($takeExam->status == 2)
                            @if ($takeExam->result_url)
                                <div>
                                    {{ $takeExam->result_url }}
                                </div>
                            @else
                                @if (!\Storage::disk('s3')->has($takeExam->file_url ?? 'ABC'))
                                    {{ $takeExam->result_url }}
                                @else
                                    <a target="_blank"
                                        href="{{ route('dowload.file') }}?url={{ $takeExam->file_url }}">{{ $takeExam->file_url }}
                                    </a>
                                @endif
                            @endif
                        @else
                            Đội thi chưa nộp bài
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
                                        max="{{ $takeExam->exam->max_ponit }}" step="0.1" type="number" name="ponit"
                                        placeholder="Nhập điểm" class="form-control">
                                    @error('ponit')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-input">
                                    <label for="" class="form-label">Lý do thay đổi điểm</label>
                                    <textarea name="reason" placeholder="Lý do thay đổi điểm ( không bắt buộc)" class="textarea form-control"></textarea>
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
                                    <select class=" select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="status"
                                        value="{{ old('status') }}">
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
                                    <input value="{{ old('ponit') }}" min="0"
                                        max="{{ $takeExam->exam->max_ponit }}" type="number" name="ponit"
                                        placeholder="Nhập điểm" class="form-control">
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
                                    <select class=" select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="status"
                                        value="{{ old('status') }}">
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
        @else
            <h3>Đội thi chưa có bài làm.</h3>
        @endif
    </div>
@endsection
@section('page-script')
    <script>
        var URL = '{{ url()->current() }}' + '?';
        var userArray = [];
        var _token = "{{ csrf_token() }}";
    </script>
    <script>
        // $('.dowloadfile').on('click', function(e) {
        //     e.preventDefault();
        //     window.location = '{{ route('dowload.file') }}' + '?url=' + $(this).data('url');
        //     return false;
        // })
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
