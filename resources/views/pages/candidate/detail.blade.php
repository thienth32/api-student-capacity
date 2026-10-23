@extends('layouts.main')
@section('title', 'Chi tiết thông tin ứng tuyển')
@section('page-title', 'Chi tiết thông tin ứng tuyển')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.candidate.list') }}" class="pe-3">Thông tin ứng tuyển</a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.post.detail', ['slug' => $data->post->slug]) }}" class="pe-3">Mã tuyển
                            dụng
                            : {{ $data->post->code_recruitment }}</a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">SV:{{ $data->name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 mb-5 mb-xl-10">
            <div class="card card-flush ">
                <!--begin::Heading-->
                <div
                    class=" rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
                    style="background-image:url('assets/media/svg/shapes/top-green.png')">
                    <!--begin::Title-->
                    <div class="p-5">
                        <div class="fs-4 text-white mt-5">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Họ tên </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Email </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Sđt </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->phone }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Mã sinh viên </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->student_code }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Trạng thái </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ config('util.CANDIDATE_OPTIONS.STUDENT_STATUSES')[$data->student_status] ?? 'Chưa có' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Ngày ứng tuyển</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($data->created_at)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($data->created_at)->diffforHumans() }}
                                        <br>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Ngày cập nhật</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($data->updated_at)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($data->updated_at)->diffforHumans() }}
                                        <br>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-8 mb-5 mb-xl-10">

            <div class="container-fluid  card card-flush">
                <div class="row">
                    <div class="col-lg-12 py-5">
                        <h3 class="py-2">Các mã tuyển dụng đã ứng tuyển</h3>
                        @if($candidates->count() > 0)
                            <table class=" table table-hover table-responsive-md ">
                                <thead>
                                <tr>

                                    <th scope="col">Mã tuyển dụng
                                    </th>
                                    <th scope="col">Vị trí
                                    </th>
                                    <th scope="col"> Xem CV
                                    </th>
                                    <th>Trạng thái</th>
                                    <th>Kết quả</th>
                                    <th class="text-center" colspan="2">

                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($candidates as $index => $key)
                                    <tr class="
                                    @if($key->has_checked == 0) fw-boldest bg-secondary @endif
                                    @if($key->id == $data->id) fw-boldest bg-gray-200 @endif
                                ">

                                        <td>
                                            <a href="{{ route('admin.post.detail', ['slug' => $key->post->slug]) }}">
                                                {{ $key->post->code_recruitment }}</a>
                                        </td>
                                        <td>
                                            {{ $key->post->position }}
                                        </td>

                                        <td>
                                            <a class="show_file btn btn-primary btn-sm" target="_blank" rel="noopener"
                                               href="{{ route('admin.candidate.showcv', $key->id) }}">Xem</a>
                                        </td>
                                        <td>
                                            <select name="" id=""
                                                    class="select-status form-select mb-2 select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="true"
                                            >
                                                @foreach(config('util.CANDIDATE_OPTIONS.STATUSES') as $status => $statusValue)
                                                    <option value="{{ $status }}|{{ $key->id }}"
                                                        @selected($status == $key->status)
                                                    >
                                                        {{ $statusValue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="" id=""
                                                    class="select-result form-select mb-2 select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="true"
                                            >
                                                <option value="|{{ $key->id }}">Chưa có</option>
                                                @foreach(config('util.CANDIDATE_OPTIONS.RESULTS') as $result => $resultValue)
                                                    <option value="{{ $result }}|{{ $key->id }}"
                                                        @selected($result == $key->result)
                                                    >
                                                        {{ $resultValue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div data-bs-toggle="tooltip" title="Thao tác " class="btn-group dropstart">
                                                <button type="button" class="btn   btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                            <span class="svg-icon svg-icon-success svg-icon-2x">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path
                                            d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                            fill="#000000"/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                                                </button>
                                                <ul class="dropdown-menu  px-4 ">
                                                    <li class="my-3">
                                <span type="button" data-bs-toggle="modal" data-bs-target="#list_note_{{ $key->id }}">
                                    Danh sách ghi chú ({{$key->candidateNotes->count()}})
                                </span>

                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                        <!-- Modal add note -->

                                        <!-- Modal add note -->
                                        <div class="modal fade" id="list_note_{{ $key->id }}" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form
                                                action="{{ route('admin.candidate.createNote', ['candidate_id' => $key->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Danh sách ghi chú
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body form-group">
                                                            @foreach($key->candidateNotes as $idx => $note)
                                                                <ul style="list-style: none;">
                                                                    <li>
                                                                        <b>{{$idx + 1}}
                                                                            . {{ date('d-m-Y H:i', strtotime($note->created_at)) }}
                                                                            - {{$note->user->email}}</b>
                                                                        <p>{!! $note->content !!}</p>
                                                                    </li>
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                Thoát
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        @else
                            <h2>Chưa có thông tin tuyển dụng !!!</h2>
                        @endif
                    </div>
                    {{--                    <div class="col-lg-12">--}}

                    {{--                        <div style="width:100%" class=" fs-3">--}}
                    {{--                            <div class="row mt-3">--}}


                    {{--                                <div class="col-md-5 mx-auto">--}}
                    {{--                                    <a target="_blank" rel="noopener"--}}
                    {{--                                       href="{{ route('admin.candidate.showcv', $data->id) }}">--}}
                    {{--                                        <div--}}
                    {{--                                            class="badge badge-primary badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">--}}
                    {{--                                            <div class="m-0  ">--}}
                    {{--                                                <span class="text-white-700 fw-bold fs-6">Xem CV</span>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                    </a>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="col-md-5 mx-auto">--}}
                    {{--                                    <a href="{{ route('dowload.file') . '?url=' . $data->file_link }}">--}}
                    {{--                                        <div--}}
                    {{--                                            class="badge badge-success badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">--}}
                    {{--                                            <div class="m-0  ">--}}
                    {{--                                                <span class="text-white-700 fw-bold fs-6">Tải CV </span>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                    </a>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}

                    {{--                            <div class="p-5">--}}
                    {{--                                <div class="fs-4 text-white mt-2">--}}
                    {{--                                    <div class="">--}}
                    {{--                                        <div class="row">--}}
                    {{--                                            <div class="col-4">--}}
                    {{--                                                <h3>Mã tuyển dụng</h3>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="col-8">--}}
                    {{--                                                <a class=""--}}
                    {{--                                                   href="{{ route('admin.post.detail', ['slug' => $data->post->slug]) }}">--}}
                    {{--                                                    {{ $data->post->code_recruitment }}</a>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="fs-4 text-white mt-2">--}}
                    {{--                                    <div class="">--}}
                    {{--                                        <div class="row">--}}
                    {{--                                            <div class="col-4">--}}
                    {{--                                                <h3>Vị trí</h3>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="col-8 text-dark">--}}
                    {{--                                                {{ $data->post->position ?? "Chưa có" }}--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="fs-4 text-white mt-2">--}}
                    {{--                                    <div class="">--}}
                    {{--                                        <div class="row">--}}
                    {{--                                            <div class="col-4">--}}
                    {{--                                                <h3>Trạng thái</h3>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="col-8 text-dark">--}}
                    {{--                                                {{ config('util.CANDIDATE_OPTIONS.STATUSES')[$data->status] ?? "Chưa có" }}--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="fs-4 text-white mt-2">--}}
                    {{--                                    <div class="">--}}
                    {{--                                        <div class="row">--}}
                    {{--                                            <div class="col-4">--}}
                    {{--                                                <h3>Kết quả</h3>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="col-8 text-dark">--}}
                    {{--                                                {{ config('util.CANDIDATE_OPTIONS.RESULTS')[$data->result] ?? "Chưa có" }}--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="card">--}}
                    {{--                        <div class="card-header">--}}
                    {{--                            <h3 class="card-title fs-3">Danh sách ghi chú ({{ $data->candidateNotes->count() }})</h3>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="card-body" style="height: 200px; overflow-y: auto">--}}
                    {{--                            @foreach($data->candidateNotes as $idx => $note)--}}
                    {{--                                <ul style="list-style: none;">--}}
                    {{--                                    <li>--}}
                    {{--                                        <b>{{$idx + 1}}--}}
                    {{--                                            . {{ date('d-m-Y H:i', strtotime($note->created_at)) }}--}}
                    {{--                                            - {{$note->user->email}}</b>--}}
                    {{--                                        <p>{{$note->content}}</p>--}}
                    {{--                                    </li>--}}
                    {{--                                </ul>--}}
                    {{--                            @endforeach--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}


                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script>
        const _token = "{{ csrf_token() }}";
        $('.select-status').on('change', function () {
            let status = $(this).val();
            $.ajax({
                url: `admin/candidates/change-status`,
                method: "POST",
                data: {
                    _token: _token,
                    status: status,
                },
                success: function (data) {
                    if (data.status == true) {
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    } else {
                        loadTast(
                            data.payload,
                            "toastr-bottom-left",
                            "info"
                        );
                    }
                },
            });
        });

        $('.select-result').on('change', function () {
            let result = $(this).val();
            $.ajax({
                url: `admin/candidates/change-result`,
                method: "POST",
                data: {
                    _token: _token,
                    result: result,
                },
                success: function (data) {
                    if (data.status == true) {
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    } else {
                        loadTast(
                            data.payload,
                            "toastr-bottom-left",
                            "info"
                        );
                    }
                },
            });
        });
    </script>
@endsection
