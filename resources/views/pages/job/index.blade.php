@extends('layouts.main')
@section('title', 'Danh sách công việc ')
@section('page-title', 'Danh sách công việc')
@section('content')

    {{-- {{ dd(\Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A')) }} --}}
    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h1>Quản lý công việc
                    </h1>
                </div>
            </div>
        </div>
        <div class="form">
            <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                <li class="nav-item">
                    <a class="nav-link active " data-bs-toggle="tab" href="#kt_mail">Gửi mail
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-bs-toggle="tab" href="#kt_tab_pane_2_A">Trò chơi đánh giá trực tuyến tự
                        động</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " data-bs-toggle="tab" href="#kt_tab_pane_2_B">Trò chơi đánh giá trực tuyến điều
                        khiển</a>
                </li>

            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane   " id="kt_tab_pane_2_A" role="tabpanel">
                    <form action="{{ route('admin.job.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="game_type_1">
                        <input type="hidden" name="on_date" id="game_type_1">
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Chọn trò chơi</label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="exam_code"
                                value="{{ old('skill') }}">
                                @foreach ($exams as $exam)
                                    @if ($exam->type == 1 && !in_array($exam->room_code, $dataJobs))
                                        <option value="{{ $exam->room_code }}"> {{ $exam->name }} - {{ $exam->room_code }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('exam_code')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Trạng thái </label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="status"
                                value="{{ old('skill') }}">
                                <option value="1" selected> Trạng thái chạy </option>
                                <option value="0"> Trạng thái chờ </option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Chọn thời gian trò chơi hoạt động (Phút)</label>
                            <input value="{{ old('time') }}" type="number" class="form-control" name="time">
                            @error('time')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Thời gian bắt đầu </label>
                            <input class="form-control form-control-solid" placeholder="Pick date rage"
                                id="kt_daterangepicker_3" />
                            @error('on_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <button class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="kt_tab_pane_2_B" role="tabpanel">
                    <form action="{{ route('admin.job.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="game_type_2">
                        <input type="hidden" name="on_date" id="game_type_2">
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Chọn trò chơi</label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="exam_code"
                                value="{{ old('skill') }}">
                                @foreach ($exams as $exam)
                                    @if ($exam->type == 0 && !in_array($exam->room_code, $dataJobs))
                                        <option value="{{ $exam->room_code }}"> {{ $exam->name }} -
                                            {{ $exam->room_code }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('exam_code')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Trạng thái </label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="status"
                                value="{{ old('skill') }}">
                                <option value="1" selected> Trạng thái chạy </option>
                                <option value="0"> Trạng thái chờ </option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Chọn thời gian mỗi câu hỏi (Giây)</label>
                            <input value="{{ old('time') }}" type="number" class="form-control" name="time">
                            @error('time')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Thời gian bắt đầu </label>
                            <input class="form-control form-control-solid" placeholder="Pick date rage"
                                id="kt_daterangepicker_4" />
                            @error('on_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-10">
                            <button class="btn btn-primary">Lưu</button>
                        </div>
                    </form>

                </div>

                <div class="tab-pane active" id="kt_mail" role="tabpanel">
                    <div class="p-2">
                        <form action="{{ route('admin.job.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="send_mail">
                            <input type="hidden" id="send_mail" name="on_date">
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Danh sách email nhận </label>
                                <input value="{{ old('mails') }}" type="text" class="form-control" name="mails"
                                    placeholder="Mail gửi cách nhau bằng dấu , ">
                                @error('mails')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Tiêu đề gửi mail </label>
                                <input value="{{ old('subject') }}" type="text" class="form-control" name="subject"
                                    placeholder="Tiêu đề gửi mail ">
                                @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-10">
                                <label for="" class="form-label">Nội dung gửi mail </label>
                                <textarea name="content" id="kt_docs_ckeditor_classic"> {{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-10">
                                <label class="form-label">CC</label>
                                <input class="form-control form-control-solid" name="cc" value=""
                                    placeholder="Có thể để trống !" />
                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Thời gian bắt đầu </label>
                                <input class="form-control form-control-solid" placeholder="Pick date rage"
                                    id="kt_daterangepicker_5" />
                                @error('on_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Trạng thái </label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="status"
                                    value="{{ old('skill') }}">
                                    <option value="1" selected> Trạng thái chạy </option>
                                    <option value="0"> Trạng thái chờ </option>
                                </select>
                                @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <button class="btn btn-primary">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

        <div>

        </div>
        <div id="kt_docs_jkanban_basic"></div>
    </div>

@endsection
@section('page-script')
    <!--CKEditor Build Bundles:: Only include the relevant bundles accordingly-->
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-inline.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-balloon.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-balloon-block.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-document.bundle.js"></script>
    <script>
        const _token = "{{ csrf_token() }}";
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#kt_docs_ckeditor_classic'), {
                ckfinder: {
                    uploadUrl: "{{ route('admin.ckeditor.upfile') . '?_token=' . csrf_token() }}"
                }
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <link href="assets/plugins/custom/jkanban/jkanban.bundle.css" rel="stylesheet" type="text/css" />
    <script src="assets/plugins/custom/jkanban/jkanban.bundle.js"></script>
    <script>
        var kanban = new jKanban({
            element: '#kt_docs_jkanban_basic',
            gutter: '0',
            widthBoard: '30%',
            dragBoards: false,
            boards: [@json($jobs_in_process), @json($jobs_in_working), @json($jobs_in_error)],
            dropEl: function(el, target, source, sibling) {
                var id = $(el).data('eid');
                var type = $(target).parent('.kanban-board').data('id');
                var typeMe = $(source).parent('.kanban-board').data('id');
                var flag = false;
                if (typeMe == "_inprocess" && type == "_working") {
                    flag = true;
                    var status = 1;
                }
                if (typeMe == "_working" && type == "_error") {
                    flag = true;
                    var status = 3;
                }
                if (flag) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.job.status') }}",
                        data: {
                            _token: _token,
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            if (response == false) {
                                toastr.error('Không cập nhật được trạng thái !');
                                return;
                            } else {
                                toastr.success('Thành công  !');
                            }
                        },
                        error: function(error) {
                            alert('Đã xảy ra lỗi !!!');
                        }
                    });
                }
            },
        });
    </script>
    <script>
        $("#kt_daterangepicker_3").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            timePicker24Hour: true,
            minDate: moment().startOf("hour"),
            maxYear: parseInt(moment().format("YYYY"), 10),
            locale: {
                format: "YYYY/MM/DD HH:mm:ss",
            },
        }, function(start, end, label) {
            $('#game_type_1').val(moment(start).format('YYYY/MM/DD HH:mm:ss'));
        });
        $("#kt_daterangepicker_4").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            timePicker24Hour: true,
            minDate: moment().startOf("hour"),
            maxYear: parseInt(moment().format("YYYY"), 10),
            locale: {
                format: "YYYY/MM/DD HH:mm:ss",
            },
        }, function(start, end, label) {
            $('#game_type_2').val(moment(start).format('YYYY/MM/DD HH:mm:ss'));
        });
        $("#kt_daterangepicker_5").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            timePicker24Hour: true,
            minDate: moment().startOf("hour"),
            maxYear: parseInt(moment().format("YYYY"), 10),
            locale: {
                format: "YYYY/MM/DD HH:mm:ss",
            },
        }, function(start, end, label) {
            $('#send_mail').val(moment(start).format('YYYY/MM/DD HH:mm:ss'));
        });
        $('input').on('change', function() {
            $('.text-danger').hide();
        });
    </script>
@endsection
