@extends('layouts.main')
@section('title', 'Chi tiết test năng lực')
@section('page-title', 'Chi tiết test năng lực')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.list') . '?type=1' }}" class="pe-3">Test năng lực </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">{{ $test_capacity->name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="card card-plush p-2">
        <style>
            .tab-content {
                width: 80%;
            }
        </style>
        <div class="d-flex flex-column flex-md-row rounded border p-10">
            <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6">
                <li class="nav-item me-0 mb-md-2">
                    <a class="nav-link nav-list btn btn-flex btn-active-light-success active" data-bs-toggle="tab"
                        href="#kt_vtab_pane_4">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-primary me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <span class="d-flex flex-column align-items-start">
                            <span class="fs-4 fw-bolder">Danh sách các bài làm </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item me-0 mb-md-2">
                    <a class="nav-link nav-ql btn btn-flex btn-active-light-info">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen003.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <span class="d-flex flex-column align-items-start">
                            <span class="fs-4 fw-bolder">Quản lý câu hỏi câu trả lời </span>
                        </span>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show tab-list" id="kt_vtab_pane_4" role="tabpanel">
                    <h2>
                        Danh sách bài làm thuộc <strong style="color: blue">{{ $test_capacity->name }}</strong>
                    </h2>
                    <a target="_blank"
                        href="{{ route('admin.round.create') . '?contest_id=' . $test_capacity->id . '&type=1' }}"
                        style="float:right">Thêm bài làm </a>
                    <div class="table-responsive table-responsive-md">
                        <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                            <thead>
                                <tr>
                                    <th>Tên bài làm </th>
                                    <th>Tổng số đề bài</th>
                                    <th style="text-align: center">Thao tác </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($test_capacity->rounds)
                                    @foreach ($test_capacity->rounds as $round)
                                        <tr>
                                            <td>
                                                {{ $round->name }}
                                            </td>
                                            <td>
                                                {{ $round->exams_count }}
                                            </td>
                                            <td style="text-align: center">
                                                <i role="button" data-round_id="{{ $round->id }}"
                                                    data-round_name="{{ $round->name }}"
                                                    class="add-exam m-auto bi bi-plus-circle-fill fs-2x"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <h5>Không có bài làm lào !</h5>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade tab-ql" id="kt_vtab_pane_5" role="tabpanel">
                    {{--  --}}
                    <h2 id="show-exam-round"></h2>
                    <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                            <tr>
                                <th>Tên đề bài </th>
                                <th>Điểm số tối đa </th>
                                <th>Thời gian </th>
                                <th>Tình trạng </th>
                                <th>Quản lý câu hỏi </th>
                            </tr>
                        </thead>
                        <tbody id="show-exams">

                        </tbody>
                    </table>
                    {{--  --}}
                </div>
            </div>
        </div>

        <div class="modal bg-white fade" tabindex="-1" id="kt_modal_2">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content shadow-none">
                    <div class="modal-header">
                        <h5 class="modal-title">Quản lý câu hỏi câu trả lời </h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="" id="show-add-questions">

                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Câu hỏi </th>
                                    <th>Độ khó </th>
                                    <th>Đáp án </th>
                                    <th>Tình trạng</th>
                                    <th> <i role="button" class="btn-add-question-answ bi bi-plus-square-fill fs-2x"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="show-ques-anw">

                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Thoát </button>
                        <button type="button" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('page-script')
    <script>
        let questions = null;

        function backClass(navs, tabs) {
            $(navs[0]).removeClass('active');
            $(tabs[0]).removeClass('active');
            $(tabs[0]).removeClass('show');
            $(navs[1]).addClass('active');
            $(tabs[1]).addClass('active');
            $(tabs[1]).addClass('show');
        }

        function fetchRoundGet(id) {
            $('#show-exams').html(`<h2>Đang load ...</h2>`);
            $.ajax({
                type: "GET",
                url: `http://127.0.0.1:8000/api/public/exam/get-by-round/${id}`,
                success: function(res) {
                    console.log(res);
                    if (res.payload.length == 0) return $('#show-exams').html(`<h2>Không có đề bài nào !</h2>`);
                    var html = res.payload.map(function(data) {
                        return `
                            <tr>
                                <td>${data.name}</td>
                                <td>${data.max_ponit}</td>
                                <td>${data.time ?? 'Chưa có thời gian '}</td>
                                <td>${data.status}</td>
                                <td>
                                     <button type="button" data-exam_name="${data.name}" data-exam_id="${data.id}" class="btn-click-show-exams btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2">
                                        <i class="bi bi-ui-checks-grid"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    }).join(" ");
                    $('#show-exams').html(html);
                },
                error: function(res) {
                    alert('Đã xảy ra lỗi !');
                    backClass([
                        '.nav-ql',
                        '.nav-list',
                    ], [
                        '.tab-ql',
                        '.tab-list',
                    ]);
                }
            });
        }
        $('.add-exam').on('click', function() {
            backClass([
                '.nav-list',
                '.nav-ql'
            ], [
                '.tab-list',
                '.tab-ql'
            ]);

            $('#show-exam-round').html(`Danh sách các đề bài của bài làm ${$(this).data('round_name')}`);
            fetchRoundGet($(this).data('round_id'));
        });
        $(document).on('click', '.btn-click-show-exams', function() {
            const id = $(this).data('exam_id');
            const name = $(this).data('exam_name');
            $('#show-ques-anw').html(`<h2>Đang load ... </h2>`);
            $('.modal-title').html('Quản lý câu hỏi ' + name);
            $.ajax({
                type: "GET",
                url: "http://127.0.0.1:8000/api/public/exam/get-question-by-exam/" + id,
                success: function(res) {
                    if (res.payload.length == 0) $('#show-ques-anw').html(
                        `<h2>Không có câu hỏi câu trả lời nào </h2>`);
                    questions = res.question;
                    let html = res.payload.map(function(data, index) {
                        var htmlChild = data.answers.map(function(val) {
                            return `
                                <p> ${val.content} ${val.is_correct == 1 ? ' - Đáp án đúng ' : ''} </p>
                            `;
                        }).join(" ");
                        return `
                            <tr>
                                <td>
                                    <a  data-bs-toggle="collapse" href="#multiCollapseExample${index}"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="multiCollapseExample${index}">
                                    ${data.content}
                                    </a>

                                    <div class="collapse multi-collapse" id="multiCollapseExample${index}">
                                        <div class="card card-body">
                                            ${htmlChild}
                                        </div>
                                    </div>

                                    </td>
                                <td>${data.rank == 0 ? 'Dễ' : data.rank == 1 ? 'Trung bình ' : data.rank == 2 ? 'Khó' : 'No ' }</td>
                                <td>${data.type == 0 ? 'Một đáp án' : data.type == 1 ? 'Nhiều đáp án ' : 'No'}</td>
                                <td>${data.status == 0 ? 'Đóng ' : data.status == 1 ? 'Mở' : 'No'}</td>
                                <td>
                                    <i role="button" class="bi bi-backspace-reverse-fill fs-2x"></i>
                                </td>
                            </tr>
                        `;
                    }).join(" ");
                    $('#show-ques-anw').html(html);
                }
            });
        });
        $('.btn-add-question-answ').on('click', function() {

        });

        function fetchShowQues(dataQ) {
            var html = dataQ.map(function(data, index) {
                var htmlChild = data.answers.map(function(val) {
                    return `
                                <p> ${val.content} ${val.is_correct == 1 ? ' - Đáp án đúng ' : ''} </p>
                            `;
                }).join(" ");

                return `
                 <li data-bs-toggle="collapse" href="#multiCollapseExample${index}"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="multiCollapseExample${index}" class="list-group-item">
                    <input class="form-check-input me-1" type="checkbox"  name="q-${index}" value="${data.id}">
                    ${data.content}- Mức độ : ${data.rank == 0 ? 'Dễ' : data.rank == 1 ? 'Trung bình ' : data.rank == 2 ? 'Khó' : 'No ' }
                        - Dạng : ${data.type == 0 ? 'Một đáp án' : data.type == 1 ? 'Nhiều đáp án ' : 'No'} -
                        Tình trạng : ${data.status == 0 ? 'Đóng ' : data.status == 1 ? 'Mở' : 'No'}
                </li>
                <div class="collapse multi-collapse" id="multiCollapseExample${index}">
                    <div class="card card-body">
                        ${htmlChild}
                    </div>
                </div>
                `;
            });
            $('#show-add-questions').html(html);
        }
    </script>
@endsection
