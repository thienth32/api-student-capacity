@extends('layouts.main')
@section('title', 'Quản lý test năng lực')
@section('page-title', 'Quản lý test năng lực')
@section('content')

    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.contest.list') . '?type=1' }}" class="pe-3">Test năng lực </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Chi tiết : {{ $test_capacity->name }}</li>
            </ol>
        </div>
    </div>
    <div class="card card-plush p-2">
        <style>
            .tab-content {
                width: 100%;
            }
        </style>
        <div class="d-flex justify-content-between flex-column flex-md-row">
            <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6">
                <li class="nav-item me-0 mb-md-2">
                    <a style="width: 100%" class="nav-link btn btn-flex btn-active-light-primary  " data-bs-toggle="tab"
                        href="#kt_vtab_pane_6">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen017.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z" fill="black"></path>
                                <path
                                    d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <span class="d-flex flex-column align-items-start">
                            <span class="fs-4 fw-bolder">Chi tiết </span>
                        </span>
                    </a>

                </li>
                <li class="nav-item me-0 mb-md-2">
                    <a style="width: 100%" class="nav-link nav-list btn btn-flex btn-active-light-success active"
                        data-bs-toggle="tab" href="#kt_vtab_pane_4">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-primary me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <span class="d-flex flex-column align-items-start">
                            <span class="fs-4 fw-bolder">D.Sách</span>
                        </span>
                    </a>
                </li>
                {{-- <li class="nav-item me-0 mb-md-2" style="">
                    <a style="width: 100%;cursor: no-drop;" class="nav-link nav-ql btn btn-flex btn-active-light-info ">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen003.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <span class="d-flex flex-column align-items-start">
                            <span class="fs-4 fw-bolder">Đề thi </span>
                        </span>
                    </a>
                </li> --}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show tab-list" id="kt_vtab_pane_4" role="tabpanel">
                    <h2>
                        Danh sách vòng thi thuộc <strong style="color: blue">{{ $test_capacity->name }}</strong>
                        <a class="mx-2" target="_blank"
                            href="{{ route('admin.round.soft.delete', 'round_soft_delete=1') }}">

                            <span data-bs-toggle="tooltip" title="Kho lưu trữ bản xóa "
                                class=" svg-icon svg-icon-primary svg-icon-2x">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Files/Deleted-folder.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="M10.5857864,14 L9.17157288,12.5857864 C8.78104858,12.1952621 8.78104858,11.5620972 9.17157288,11.1715729 C9.56209717,10.7810486 10.1952621,10.7810486 10.5857864,11.1715729 L12,12.5857864 L13.4142136,11.1715729 C13.8047379,10.7810486 14.4379028,10.7810486 14.8284271,11.1715729 C15.2189514,11.5620972 15.2189514,12.1952621 14.8284271,12.5857864 L13.4142136,14 L14.8284271,15.4142136 C15.2189514,15.8047379 15.2189514,16.4379028 14.8284271,16.8284271 C14.4379028,17.2189514 13.8047379,17.2189514 13.4142136,16.8284271 L12,15.4142136 L10.5857864,16.8284271 C10.1952621,17.2189514 9.56209717,17.2189514 9.17157288,16.8284271 C8.78104858,16.4379028 8.78104858,15.8047379 9.17157288,15.4142136 L10.5857864,14 Z"
                                            fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </a>
                    </h2>
                    <a class="btn btn-primary" target="_blank"
                        href="{{ route('admin.round.create') . '?contest_id=' . $test_capacity->id . '&type=1' }}"
                        style="float:right">Thêm vòng thi </a>
                    <div style="width: 100%" class="table-responsive table-responsive-md ">
                        <table class="table table-striped table-row-bordered table-row-gray-300 gy-7  table-hover ">
                            <thead>
                                <tr>
                                    <th>Tên vòng thi </th>
                                    <th>Đề thi</th>
                                    {{-- <th>Tổng số đề thi</th> --}}
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th class="text-center">Thao tác nhanh</th>
                                    <th style="text-align: center">Quản lý đề thi </th>
                                    <th style="text-align: center"> </th>
                                </tr>
                            </thead>
                            <tbody class="panel">
                                @if ($test_capacity->rounds)
                                    @foreach ($test_capacity->rounds as $key => $round)
                                        <tr class="panel-heading" data-key="{{ $round->id }}">
                                            <td data-key="{{ $round->id }}" data-bs-toggle="tooltip"
                                                title="Xem nhanh các cuộc thi">
                                                <p style="width:100%" class=" " data-bs-toggle="collapse"
                                                    role="button" data-bs-target="#collapseExample_{{ $round->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseExample_{{ $round->id }}">
                                                    {{ $round->name }}
                                                </p>

                                            </td>
                                            <td>
                                                <a target="_blank"
                                                    href="{{ route('admin.exam.create', ['id' => $round->id]) . '?type=1' }}">Thêm
                                                    đề thi</a>
                                            </td>
                                            {{-- <td>
                                                {{ $round->exams_count }}
                                            </td> --}}
                                            <td>{{ $round->start_time }}</td>
                                            <td>{{ $round->end_time }}</td>
                                            <td class="text-center" data-bs-toggle="tooltip" title="Thao tác nhanh">

                                                <span role="button" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_round_{{ $round->id }}"
                                                    class="btn btn-primary">
                                                    <i class="bi bi-arrows-fullscreen"></i>
                                                </span>

                                                <div class="modal fade" tabindex="-1"
                                                    id="kt_modal_round_{{ $round->id }}">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Các đề bài thuộc vòng thi
                                                                    {{ $round->name }}</h5>

                                                                <!--begin::Close-->
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span class="svg-icon svg-icon-2x"></span>
                                                                    Thoát
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>

                                                            <div class="modal-body">
                                                                <table
                                                                    class="table table-row-dashed table-row-gray-500 gy-5 gs-5 mb-0">
                                                                    <thead>
                                                                        <tr class="fw-bold fs-6 text-gray-800">
                                                                            <th style="padding: 10px" scope="col"> Đề
                                                                                thi </th>
                                                                            <th style="padding: 10px;text-align: center;"
                                                                                scope="col">
                                                                                Tiến trình </th>
                                                                            <th style="padding: 10px;text-align: center;"
                                                                                scope="col">
                                                                                Tải bộ excel</th>
                                                                            <th style="float: right;padding: 10px"
                                                                                scope="col">
                                                                                Nhanh
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if (count($round->exams) > 0)
                                                                            @foreach ($round->exams as $exam)
                                                                                <tr>
                                                                                    <td style="width: 70% ; padding: 10px">
                                                                                        {{ $exam->name }}</td>
                                                                                    <td style="width: 10% ; padding: 10px; text-align:center"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title="Theo dõi tiến trình  "
                                                                                        style="text-align: center;">
                                                                                        <button
                                                                                            style="background: #ccc;padding: 1vh 1vh 1vh 2vh;border-radius: 20px;"
                                                                                            type="button"
                                                                                            data-round_id="{{ $round->id }}"
                                                                                            data-exam_id="{{ $exam->id }}"
                                                                                            class="btn-click-show-result-exam btn btn-primary"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#kt_modal_1">
                                                                                            <i
                                                                                                class="bi bi-graph-down  "></i>
                                                                                        </button>
                                                                                    </td>
                                                                                    <td data-bs-toggle="tooltip"
                                                                                        title="Tải lên bộ câu hỏi bằng excel"
                                                                                        style="width: 10% ;padding: 10px; text-align:center">
                                                                                        <button
                                                                                            style="background: #ccc;
                                                                                                                    padding: 1vh 1vh 1vh 2vh;
                                                                                                                    border-radius: 20px;"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#kt_modal_exc_{{ $exam->id }}"
                                                                                            type="button"
                                                                                            class="btn   me-3"
                                                                                            id="kt_file_manager_new_folder">
                                                                                            <!--begin::Svg Icon | path: icons/duotune/files/fil013.svg-->
                                                                                            <span
                                                                                                class="svg-icon svg-icon-2">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                    width="24"
                                                                                                    height="24"
                                                                                                    viewBox="0 0 24 24"
                                                                                                    fill="none">
                                                                                                    <path opacity="0.3"
                                                                                                        d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z"
                                                                                                        fill="black">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                                                                                        fill="black">
                                                                                                    </path>
                                                                                                    <path opacity="0.3"
                                                                                                        d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                                                                                        fill="black">
                                                                                                    </path>
                                                                                                </svg>
                                                                                            </span>
                                                                                            <!--end::Svg Icon-->
                                                                                        </button>

                                                                                    </td>
                                                                                    <td
                                                                                        style="width: 10% ;padding: 10px; text-align:center">
                                                                                        <span style="float: right"
                                                                                            data-bs-toggle="tooltip"
                                                                                            title="Xem nhanh câu hỏi câu trả lời ">
                                                                                            <button
                                                                                                style="background: #ccc;padding: 1vh 1vh 1vh 2vh;border-radius: 20px;"
                                                                                                type="button"
                                                                                                data-exam_name="{{ $exam->name }}"
                                                                                                data-exam_id="{{ $exam->id }}"
                                                                                                class="btn-click-show-exams btn btn-primary"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#kt_modal_2">
                                                                                                {{-- <i class="bi bi-ui-checks-grid"></i> --}}
                                                                                                <i
                                                                                                    class="bi bi-arrows-move"></i>
                                                                                            </button>
                                                                                        </span>


                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <h2>Không có đề thi !!</h2>
                                                                        @endif


                                                                    </tbody>
                                                                </table>

                                                            </div>

                                                            <div class="modal-footer">
                                                                {{-- <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Thoát </button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if (count($round->exams) > 0)
                                                    @foreach ($round->exams as $exam)
                                                        <div class="modal fade" tabindex="-1"
                                                            id="kt_modal_exc_{{ $exam->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            Tải lên
                                                                            excel
                                                                            <strong>{{ $exam->name }}</strong>
                                                                        </h5>

                                                                        <!--begin::Close-->
                                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span class="svg-icon svg-icon-2x"></span>
                                                                            Thoát
                                                                        </div>
                                                                        <!--end::Close-->
                                                                    </div>
                                                                    <form class="form-submit"
                                                                        action="{{ route('admin.question.excel.import.exam', ['exam' => $exam->id]) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-body text-center">
                                                                            <div class="HDSD">
                                                                            </div>
                                                                            <label for="up-file{{ $exam->id }}"
                                                                                class="">
                                                                                <i data-bs-toggle="tooltip"
                                                                                    title="Click để upload file"
                                                                                    style="font-size: 100px;"
                                                                                    role="button"
                                                                                    class="bi bi-cloud-plus-fill"></i>
                                                                            </label>
                                                                            <input style="display: none" type="file"
                                                                                name="ex_file" class="up-file"
                                                                                id="up-file{{ $exam->id }}">
                                                                            <div style="display: none"
                                                                                class="progress show-p mt-3 h-25px w-100">
                                                                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                                                    role="progressbar" style="width: 0%"
                                                                                    aria-valuenow="0" aria-valuemin="0"
                                                                                    aria-valuemax="100">
                                                                                </div>
                                                                            </div>
                                                                            <p class="show-name">
                                                                            </p>
                                                                            <p class="text-danger error_ex_file">
                                                                            </p>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="upload-file btn btn-primary">Tải
                                                                                lên
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td style="text-align: center">

                                                <span role="button" class="btn btn-primary">
                                                    <i role="button" data-bs-toggle="tooltip" title="Quản lý đề thi "
                                                        data-round_id="{{ $round->id }}"
                                                        data-round_name="{{ $round->name }}"
                                                        class="add-exam m-auto bi bi-tools  "></i>
                                                </span>

                                            </td>
                                            <td>
                                                <div data-bs-toggle="tooltip" title="Thao tác "
                                                    class="btn-group dropstart">
                                                    <button style="padding: 0" type="button"
                                                        class="btn   btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <span class="svg-icon svg-icon-success svg-icon-2x">
                                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
                                                                    <path
                                                                        d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                                        fill="#000000" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </button>
                                                    <ul class="dropdown-menu ps-3">
                                                        <li class="my-3">
                                                            <a
                                                                href="{{ route('admin.round.edit', ['id' => $round->id]) . '?type=' . $round->contest->type }}">
                                                                <span role="button"
                                                                    class="svg-icon svg-icon-success svg-icon-2x">
                                                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Edit.svg--><svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="24px" height="24px" viewBox="0 0 24 24"
                                                                        version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                            fill-rule="evenodd">
                                                                            <rect x="0" y="0"
                                                                                width="24" height="24" />
                                                                            <path
                                                                                d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                                            <rect fill="#000000" opacity="0.3"
                                                                                x="5" y="20"
                                                                                width="15" height="2"
                                                                                rx="1" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                Chỉnh sửa
                                                            </a>
                                                        </li>
                                                        <li class="my-3">
                                                            @hasrole(config('util.ROLE_DELETE'))
                                                                @if ($round->results_count == 0 &&
                                                                    $round->exams_count == 0 &&
                                                                    $round->posts_count == 0 &&
                                                                    $round->sliders_count == 0)
                                                                    <form
                                                                        action="{{ route('admin.round.destroy', ['id' => $round->id]) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button
                                                                            onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                                            style=" background: none ; border: none ; list-style : none"
                                                                            type="submit">
                                                                            <span role="button"
                                                                                class="svg-icon svg-icon-danger svg-icon-2x">
                                                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    width="24px" height="24px"
                                                                                    viewBox="0 0 24 24" version="1.1">
                                                                                    <g stroke="none" stroke-width="1"
                                                                                        fill="none" fill-rule="evenodd">
                                                                                        <rect x="0" y="0"
                                                                                            width="24" height="24" />
                                                                                        <path
                                                                                            d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                                                            fill="#000000"
                                                                                            fill-rule="nonzero" />
                                                                                        <path
                                                                                            d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                                                            fill="#000000" opacity="0.3" />
                                                                                    </g>
                                                                                </svg>
                                                                                <!--end::Svg Icon-->
                                                                            </span>
                                                                            Xóa bỏ
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @else
                                                                <span style="cursor: not-allowed; user-select: none"
                                                                    class="svg-icon svg-icon-danger svg-icon-2x">
                                                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Lock-circle.svg--><svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="24px" height="24px" viewBox="0 0 24 24"
                                                                        version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                            fill-rule="evenodd">
                                                                            <rect x="0" y="0"
                                                                                width="24" height="24" />
                                                                            <circle fill="#000000" opacity="0.3"
                                                                                cx="12" cy="12"
                                                                                r="10" />
                                                                            <path
                                                                                d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z"
                                                                                fill="#000000" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                Xóa bỏ
                                                            @endhasrole

                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- @if (count($round->exams) > 0)
                                            <tr class="{{ $key == 0 ?: 'collapse  panel-collapse' }} "
                                                id="collapseExample_{{ $round->id }}" role="tabpanel"
                                                aria-labelledby="heading{{ $round->id }}">
                                                <td style="padding: 0" colspan="12">
                                                    <table
                                                        class="table table-row-dashed table-row-gray-500 gy-5 gs-5 mb-0">
                                                        <thead>
                                                            <tr class="fw-bold fs-6 text-gray-800">
                                                                <th style="padding: 10px" scope="col"> Đề thi </th>
                                                                <th style="padding: 10px;text-align: center;"
                                                                    scope="col">
                                                                    Tiến trình </th>
                                                                <th style="padding: 10px;text-align: center;"
                                                                    scope="col">
                                                                    Tải bộ excel</th>
                                                                <th style="float: right;padding: 10px" scope="col">
                                                                    Nhanh
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($round->exams as $exam)
                                                                <tr>
                                                                    <td style="width: 70% ; padding: 10px">
                                                                        {{ $exam->name }}</td>
                                                                    <td style="width: 10% ; padding: 10px; text-align:center"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Theo dõi tiến trình  "
                                                                        style="text-align: center;">
                                                                        <button
                                                                            style="background: #ccc;padding: 1vh 1vh 1vh 2vh;border-radius: 20px;"
                                                                            type="button"
                                                                            data-round_id="{{ $round->id }}"
                                                                            data-exam_id="{{ $exam->id }}"
                                                                            class="btn-click-show-result-exam btn btn-primary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_1">
                                                                            <i class="bi bi-graph-down  "></i>
                                                                        </button>
                                                                    </td>
                                                                    <td data-bs-toggle="tooltip"
                                                                        title="Tải lên bộ câu hỏi bằng excel"
                                                                        style="width: 10% ;padding: 10px; text-align:center">
                                                                        <button
                                                                            style="background: #ccc;
                                                                                padding: 1vh 1vh 1vh 2vh;
                                                                                border-radius: 20px;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_exc_{{ $exam->id }}"
                                                                            type="button" class="btn   me-3"
                                                                            id="kt_file_manager_new_folder">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none">
                                                                                    <path opacity="0.3"
                                                                                        d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z"
                                                                                        fill="black">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                                                                        fill="black"></path>
                                                                                    <path opacity="0.3"
                                                                                        d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                                                                        fill="black"></path>
                                                                                </svg>
                                                                            </span>
                                                                        </button>

                                                                        <div class="modal fade" tabindex="-1"
                                                                            id="kt_modal_exc_{{ $exam->id }}">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Tải lên
                                                                                            excel
                                                                                            <strong>{{ $exam->name }}</strong>
                                                                                        </h5>

                                                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                class="svg-icon svg-icon-2x"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <form class="form-submit"
                                                                                        action="{{ route('admin.question.excel.import.exam', ['exam' => $exam->id]) }}"
                                                                                        method="POST"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div
                                                                                            class="modal-body text-center">
                                                                                            <div class="HDSD">
                                                                                            </div>
                                                                                            <label
                                                                                                for="up-file{{ $exam->id }}"
                                                                                                class="">
                                                                                                <i data-bs-toggle="tooltip"
                                                                                                    title="Click để upload file"
                                                                                                    style="font-size: 100px;"
                                                                                                    role="button"
                                                                                                    class="bi bi-cloud-plus-fill"></i>
                                                                                            </label>
                                                                                            <input style="display: none"
                                                                                                type="file"
                                                                                                name="ex_file"
                                                                                                class="up-file"
                                                                                                id="up-file{{ $exam->id }}">
                                                                                            <div style="display: none"
                                                                                                class="progress show-p mt-3 h-25px w-100">
                                                                                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                                                                    role="progressbar"
                                                                                                    style="width: 0%"
                                                                                                    aria-valuenow="0"
                                                                                                    aria-valuemin="0"
                                                                                                    aria-valuemax="100">
                                                                                                </div>
                                                                                            </div>
                                                                                            <p class="show-name"></p>
                                                                                            <p
                                                                                                class="text-danger error_ex_file">
                                                                                            </p>
                                                                                        </div>

                                                                                        <div class="modal-footer">
                                                                                            <button type="submit"
                                                                                                class="upload-file btn btn-primary">Tải
                                                                                                lên </button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        style="width: 10% ;padding: 10px; text-align:center">
                                                                        <span style="float: right"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Xem nhanh câu hỏi câu trả lời ">
                                                                            <button
                                                                                style="background: #ccc;padding: 1vh 1vh 1vh 2vh;border-radius: 20px;"
                                                                                type="button"
                                                                                data-exam_name="{{ $exam->name }}"
                                                                                data-exam_id="{{ $exam->id }}"
                                                                                class="btn-click-show-exams btn btn-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_2">
                                                                                <i class="bi bi-arrows-move"></i>
                                                                            </button>
                                                                        </span>


                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif --}}
                                    @endforeach
                                @else
                                    <tr>
                                        <h5>Không có đề thi lào !</h5>
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
                                <th>Tên đề thi </th>
                                <th>Điểm số tối đa </th>
                                <th>Điểm số qua vòng </th>
                                <th>Thời gian </th>
                                <th>Kiểu thời gian </th>
                                <th>Tình trạng </th>
                                <th>Theo dõi tiến trình </th>
                                <th>Quản lý câu hỏi </th>
                                <th>Chỉnh sửa </th>
                            </tr>
                        </thead>
                        <tbody id="show-exams">

                        </tbody>
                    </table>
                    {{--  --}}
                </div>
                <div class="tab-pane fade  " id="kt_vtab_pane_6" role="tabpanel">

                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            <!--begin::About card-->
                            <div class="card">
                                <!--begin::Body-->
                                <div class="card-body p-lg-17">
                                    <!--begin::Meet-->
                                    <div class="mb-18">
                                        <!--begin::Wrapper-->
                                        <div class="mb-11">
                                            <!--begin::Top-->
                                            <div class="text-center mb-18">
                                                <!--begin::Title-->
                                                <h3 class="fs-2hx text-dark mb-6">Test năng lực :
                                                    <strong>{{ $test_capacity->name }}</strong>
                                                </h3>
                                                <!--end::Title-->
                                                <div class="fs-5 text-muted fw-bold">
                                                    <strong>Bắt đầu</strong> : {{ $test_capacity->date_start }}
                                                    <br><strong>Kết thúc</strong> : {{ $test_capacity->register_deadline }}
                                                    <br>
                                                    <p><strong>Kỹ năng</strong></p>
                                                    @if (count($test_capacity->skills) > 0)
                                                        @foreach ($test_capacity->skills as $key => $skill)
                                                            <span
                                                                class="badge badge-{{ $key % 2 == 0 ? 'secondary' : 'success' }}">{{ $skill->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-success">Chưa có kỹ năng !</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--end::Top-->
                                            <!--begin::Overlay-->
                                            <div class="overlay">
                                                <!--begin::Image-->
                                                <img class="w-100 card-rounded" src="{{ $test_capacity->img }}"
                                                    alt="" />
                                                <!--end::Image-->
                                                <!--begin::Links-->
                                                <!--end::Links-->
                                            </div>
                                            <!--end::Overlay-->
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Description-->
                                        <div class="fs-5 fw-bold text-gray-600">
                                            <!--begin::Text-->
                                            <p class="m-0">
                                                {!! $test_capacity->description !!}
                                            </p>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Meet-->
                                    <!--begin::Team-->

                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::About card-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->

            </div>
        </div>
        {{-- </div> --}}

        <div class="modal fade" tabindex="-1" id="kt_modal_2">
            <div class="modal-dialog modal-xl">
                <div class="modal-content shadow-none">
                    <div class="modal-header">
                        <h5 class="modal-title">Quản lý câu hỏi câu trả lời </h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                            Thoát
                        </div>
                        <!--end::Close-->
                    </div>

                    <div style="background-color: #f5f8fa;" class="modal-body">
                        <div id="show-tast-qs" class="card p-6">
                            <div class="row card-format" id="card_2">

                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="   form-group ">
                                        <label class="form-label">Skill</label>
                                        <select id="selectSkill" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1">Chọn skill</option>
                                            <option value="0">Không có skill</option>
                                            @foreach ($skills as $skill)
                                                <option @selected(request('skill') == $skill->id) value="{{ $skill->id }}">
                                                    {{ $skill->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Level</label>
                                        <select id="select-level" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1" @selected(!request()->has('level'))>Chọn level</option>
                                            <option @selected(request()->has('level') && request('level') == 0) value="0">Dễ</option>
                                            <option @selected(request()->has('level') && request('level') == 1) value="1">Trung bình</option>
                                            <option @selected(request()->has('level') && request('level') == 2) value="2">Khó</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Loại</label>
                                        <select id="select-type" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1" @selected(!request()->has('type'))>Chọn loại</option>
                                            <option @selected(request()->has('type') && request('type') == 0) value="0">Một đáp án</option>
                                            <option @selected(request()->has('type') && request('type') == 1) value="1">Nhiều đáp án</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-sx-12 col-md-12 col-sm-12 col-xxl-6 col-xl-6">
                                    <div class="  form-group">
                                        <label class="form-label">Tìm kiếm </label>
                                        <input type="text" value="{{ request('q') ?? '' }}"
                                            placeholder="*Enter tìm kiếm ..." id="ip-search"
                                            class=" ip-search form-control">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="  form-group">
                                        <label class="form-label">Lấy theo số lượng câu hỏi</label>
                                        <select id="select-question-has-take"
                                            class=" form-select mb-2 select2-hidden-accessible" data-control="select2"
                                            data-hide-search="true" tabindex="-1" aria-hidden="true">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="60">60</option>
                                            <option value="120">120</option>
                                            <option value="500">500</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="back">

                                <span data-bs-toggle="tooltip" title="Đóng lọc" data-key="card_2"
                                    class="btn-hide btn-hide-card_2 svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </span>

                                <span data-bs-toggle="tooltip" title="Mở lọc" data-key="card_2"
                                    class="btn-show btn-show-card_2 svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>

                            </div>
                            <div id="show-add-questions" style="    max-height: 80vh !important; " class="mt-2 mb-2">
                            </div>
                            <div id="data-save"
                                style="
                                    position: absolute;
                                    left: 0;
                                    bottom: -5vh;
                                    right: 0;
                                    max-height: 500px;
                                    overflow: auto;
                                    background: white;
                                    padding: 10px;"
                                class="mt-1">
                                <div id="show-data-save" class="mb-5"></div>
                                <div
                                    style="position: absolute; bottom: 20px; transform: translateX(-50%);  left: 50%; z-index: 999999999;">
                                    <button data-bs-toggle="tooltip" title="Lưu" class="btn btn-primary"
                                        id="save-qs">Lưu </button>
                                    <button data-bs-toggle="tooltip" title="Tải lại câu hỏi "
                                        class="btn-reload btn btn-success">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <button data-bs-toggle="tooltip" title="Trở về " class="btn-back btn btn-warning">
                                        <i class="bi bi-backspace"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="show-list-qs" class="card p-6">

                            <div class=" mb-2 row " id="card_1">
                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class=" form-group ">
                                        <label class="form-label">Skill</label>
                                        <select id="selectSkillQs" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1">Chọn skill</option>
                                            <option value="0">Không có skill</option>
                                            @foreach ($skills as $skill)
                                                <option @selected(request('skill') == $skill->id) value="{{ $skill->id }}">
                                                    {{ $skill->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Level</label>
                                        <select id="select-levelQs" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1" @selected(!request()->has('level'))>Chọn level</option>
                                            <option @selected(request()->has('level') && request('level') == 0) value="0">Dễ</option>
                                            <option @selected(request()->has('level') && request('level') == 1) value="1">Trung bình</option>
                                            <option @selected(request()->has('level') && request('level') == 2) value="2">Khó</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Loại</label>
                                        <select id="select-typeQs" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1" @selected(!request()->has('type'))>Chọn loại</option>
                                            <option @selected(request()->has('type') && request('type') == 0) value="0">Một đáp án</option>
                                            <option @selected(request()->has('type') && request('type') == 1) value="1">Nhiều đáp án</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-sx-12 col-md-12 col-sm-12 col-xxl-6 col-xl-6">
                                    <div class="  form-group">
                                        <label class="form-label">Tìm kiếm </label>
                                        <input type="text" value="{{ request('q') ?? '' }}"
                                            placeholder="*Enter tìm kiếm ..." id="ip-searchQs"
                                            class=" ip-search form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="back">

                                <span data-bs-toggle="tooltip" title="Đóng lọc" data-key="card_1"
                                    class="btn-hide btn-hide-card_1 svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </span>

                                <span data-bs-toggle="tooltip" title="Mở lọc" data-key="card_1"
                                    class="btn-show btn-show-card_1 svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>

                            </div>
                            {{-- <div class="card ">
                                <i class="bi bi-gear-fill"></i>
                            </div> --}}
                            <div class=" ">
                                <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT </th>
                                            <th>Câu hỏi </th>
                                            <th>Độ khó </th>
                                            <th>Đáp án </th>
                                            <th>Tình trạng</th>
                                            <th> <i role="button" data-bs-toggle="tooltip"
                                                    title="Thêm câu hỏi câu trả lời "
                                                    class="btn-add-question-answ bi bi-plus-square-fill fs-2x"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-ques-anw" class="position-relative">

                                    </tbody>
                                </table>
                                <ul style="position: absolute; bottom: -10vh; transform: translateX(-50%);  left: 50%; z-index: 999999999;"
                                    id="show-paginate" class="pagination">
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Thoát </button> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="kt_modal_1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Theo dõi tiến trình </h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                            Thoát
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div id="print-show"></div>
                        <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                            <thead>
                                <tr>
                                    <th>Sinh viên</th>
                                    <th>Mail</th>
                                    <th>Số điểm</th>
                                    <th>Trạng thái </th>
                                    <th>Chọn sai</th>
                                    <th>Chọn đúng </th>
                                    <th>Đáp án</th>
                                </tr>
                            </thead>
                            <tbody id="show-result-exam">

                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Thoát </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        const urlApiPublic = "{{ request()->root() }}/api/public/";
        const _token = "{{ csrf_token() }}";
        let questions = null;
        let listSave = [];
        let exam_id = null;
        $('#show-tast-qs').hide();
        let skill = '';
        let level = '';
        let type = '';
        let q = '';
        $(".panel-heading").hover(
            function() {
                $('.collapse.show').collapse('hide');
                $("#collapseExample_" + $(this).data('key')).collapse('show');
            }
        );
    </script>
    <script src="assets/js/system/capacity/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.up-file').on("change", function() {
                $('.show-name').html($(this)[0].files[0].name);
            })
            $('.form-submit').ajaxForm({
                beforeSend: function() {
                    $(".error_ex_file").html("");
                    $(".upload-file").html("Đang tải dữ liệu ..")
                    $(".progress").show();
                    var percentage = '0';
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                success: function() {
                    $(".progress").hide();
                    $(".upload-file").html("Tải lên")
                    toastr.success("Tải lên thành công !");
                    $('.up-file').val('');
                    // window.location.reload();
                },
                error: function(xhr, status, error) {
                    $(".upload-file").html("Tải lên")
                    $('.progress .progress-bar').css("width", 0 + '%', function() {
                        return $(this).attr("aria-valuenow", 0) + "%";
                    })
                    $(".progress").hide();
                    var err = JSON.parse(xhr.responseText);
                    if (err.errors) $(".error_ex_file").html(err.errors.ex_file);
                }
            });
        })
    </script>
@endsection
