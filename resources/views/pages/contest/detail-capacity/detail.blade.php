@extends('layouts.main')
@section('title', 'Chi tiết test năng lực')
@section('page-title', 'Chi tiết test năng lực')
@section('content')
    <style>
        .loading {
            width: 6vmax;
            height: 6vmax;
            border-right: 4px solid black;
            border-radius: 100%;
            animation: spinRight 800ms linear infinite;
        }

        .loading:before,
        .loading:after {
            content: '';
            width: 4vmax;
            height: 4vmax;
            display: block;
            position: absolute;
            top: calc(50% - 2vmax);
            left: calc(50% - 2vmax);
            border-left: 3px solid black;
            border-radius: 100%;
            animation: spinLeft 800ms linear infinite;
        }

        .loading:after {
            width: 2vmax;
            height: 2vmax;
            top: calc(50% - 1vmax);
            left: calc(50% - 1vmax);
            border: 0;
            border-right: 2px solid black;
            animation: none;
        }

        @keyframes spinLeft {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(720deg);
            }
        }

        @keyframes spinRight {
            from {
                transform: rotate(360deg);
            }

            to {
                transform: rotate(0deg);
            }
        }
    </style>
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
                            <span class="fs-4 fw-bolder">Danh sách bài làm </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item me-0 mb-md-2">
                    <a style="width: 100%" class="nav-link nav-ql btn btn-flex btn-active-light-info">
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
                            <span class="fs-4 fw-bolder">Câu hỏi câu trả lời </span>
                        </span>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show tab-list" id="kt_vtab_pane_4" role="tabpanel">
                    <h2>
                        Danh sách đề bài thuộc <strong style="color: blue">{{ $test_capacity->name }}</strong>
                    </h2>
                    <a target="_blank"
                        href="{{ route('admin.round.create') . '?contest_id=' . $test_capacity->id . '&type=1' }}"
                        style="float:right">Thêm đề bài </a>
                    <div style="width: 100%" class="table-responsive table-responsive-md ">
                        <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                            <thead>
                                <tr>
                                    <th>Tên đề bài </th>
                                    <th>Bài làm</th>
                                    <th>Tổng số bài làm</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th style="text-align: center">Thao tác </th>
                                    <th style="text-align: center"> </th>
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
                                                <a target="_blank"
                                                    href="{{ route('admin.exam.create', ['id' => $round->id]) . '?type=1' }}">Thêm
                                                    bài làm</a>
                                            </td>
                                            <td>
                                                {{ $round->exams_count }}
                                            </td>
                                            <td>{{ $round->start_time }}</td>
                                            <td>{{ $round->end_time }}</td>
                                            <td style="text-align: center">
                                                <i role="button" data-bs-toggle="tooltip" title="Quản lý bài làm "
                                                    data-round_id="{{ $round->id }}"
                                                    data-round_name="{{ $round->name }}"
                                                    class="add-exam m-auto bi bi-plus-circle-fill fs-2x"></i>
                                            </td>
                                            <td>
                                                <div data-bs-toggle="tooltip" title="Thao tác " class="btn-group dropstart">
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
                                <th>Tên bài làm </th>
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
                        <div id="show-tast-qs">
                            <div class="row card-format">

                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="   form-group ">
                                        <label class="form-label">Skill</label>
                                        <select id="selectSkill" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1">Chọn skill</option>
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
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div id="show-add-questions" class="mt-2 mb-2"></div>
                            <div id="data-save" class="mt-1">
                                <div id="show-data-save" class="mb-5"></div>
                                <div
                                    style="position: fixed; bottom: 20px; transform: translateX(-50%);  left: 50%; z-index: 999999999;">
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

                        <div id="show-list-qs">

                            <div class="row m-1">

                                <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                                    <div class="   form-group ">
                                        <label class="form-label">Skill</label>
                                        <select id="selectSkillQs" class="form-select mb-2 select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="-1">Chọn skill</option>
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

                            <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover">
                                <thead>
                                    <tr>
                                        <th>Câu hỏi </th>
                                        <th>Độ khó </th>
                                        <th>Đáp án </th>
                                        <th>Tình trạng</th>
                                        <th> <i role="button" data-bs-toggle="tooltip" title="Thêm câu hỏi câu trả lời "
                                                class="btn-add-question-answ bi bi-plus-square-fill fs-2x"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="show-ques-anw" class="position-relative">

                                </tbody>
                            </table>
                            <ul style="position: fixed; bottom: 20px; transform: translateX(-50%);  left: 50%; z-index: 999999999;"
                                id="show-paginate" class="pagination">
                            </ul>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Thoát </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="kt_modal_1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Theo dõi tiến trình </h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
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
                                </tr>
                            </thead>
                            <tbody id="show-result-exam">

                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Thoát </button>
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
    </script>
    <script src="assets/js/system/capacity/main.js"></script>

@endsection
