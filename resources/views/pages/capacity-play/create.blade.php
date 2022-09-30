@extends('layouts.main')
@section('title', 'Quản lý trò chơi trực tiếp ')
@section('page-title', 'Quản lý trò chơi trực tiếp ')
@section('content')

    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.capacit.play.index') }}" class="pe-3">
                        Danh sách trò chơi trực tiếp
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới trò chơi trực tiếp</li>
            </ol>
        </div>
    </div>
    <div class="card card-flush p-4">

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-flush h-lg-100 p-10">

                    <form id="formAddSlider" action="{{ route('admin.capacit.play.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <label class="form-label">Tên trò chơi </label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    placeholder="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-4 row ">
                                <div class="col-12 mb-4">
                                    <label class="form-label">Số điểm </label>
                                    <input type="number" min="0" name="max_ponit" value="{{ old('max_ponit') }}"
                                        class=" form-control" placeholder="">
                                    @error('max_ponit')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12">
                                </div>

                            </div>
                            <div class="col-12 pb-2">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="">Mô tả trò chơi</label>
                                    <textarea class="form-control" name="description" id="" rows="3"></textarea>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 pb-2">
                                <div class="form-group mb-4">
                                    <label for="" class="form-label">Hình thức trực tiếp </label>
                                    <select class="form-select" data-control="select2" name="type"
                                        data-placeholder="Select an option">
                                        <option value="0"> Điều khiển </option>
                                        <option value="1"> Tự động </option>
                                    </select>
                                    @error('type')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-12 pb-2">
                                <div class="form-group mb-4">
                                    <label for="" class="form-label">Hình thức chọ bộ câu hỏi </label>
                                    <select multiple class="form-select" data-control="select2" name="questions[]"
                                        data-placeholder="Select an option">
                                        @foreach ($questions as $question)
                                            <option value="{{ $question->id }}">
                                                {{ $question->content }} -
                                                {{ $question->type == 1 ? 'Nhiều câu trả lời' : 'Một câu trả lời' }} -
                                                {{ ($question->rank == 0 ? 'Dễ' : $question->rank == 1) ? 'Trung bình' : 'Khó ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('questions')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-12 pb-2">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group mb-4">
                                            <label for="" class="form-label">Chọn bộ câu hỏi theo skill </label>
                                            <select class="form-select skill-select" data-control="select2"
                                                data-placeholder="Select an option">
                                                <option value="null">Chọn skill</option>
                                                <option value="0">Không thuộc skill nào</option>
                                                @foreach ($skills as $skill)
                                                    <option value="{{ $skill->id }}">
                                                        {{ $skill->name }}
                                                        -------
                                                        {{ $skill->short_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('questions')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-4">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-lg mt-8" data-bs-toggle="modal"
                                            data-bs-target="#modalId">
                                            Danh sách câu hỏi được thêm
                                        </button>
                                        @error('questions')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalId" tabindex="-1" role="dialog"
                                            aria-labelledby="modalTitleId" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitleId">Danh sách câu hỏi được
                                                            thêm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid" style="height: 65vh;  overflow: auto;">
                                                            <div id="result-question-array">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Thoát</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                                <div class="row ">

                                    <div class="col-12">
                                        <div class="parent-loading"style="min-height: 100px">
                                            <div id="loading" class="loading">
                                                <div id="circle-loading" class="circle-loading"></div>
                                            </div>
                                            <div id="result-question">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group mb-10 ">
                            <button type="submit" class="btn btn-success btn-lg btn-block">Lưu
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('page-script')
    <script>
        const _token = "{{ csrf_token() }}";
        const skillQuestionRoute = "{{ route('admin.question.skill') }}";
    </script>
    <script src="{{ asset('assets/js/system/capacity-play/capacity-play.js') }}"></script>
@endsection
