@extends('layouts.main')
@section('title', 'Quản lý trò chơi trực tiếp')
@section('page-title', 'Quản lý trò chơi trực tiếp')
@section('content')

    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">

                <div class="d-flex justify-content-start">
                    <h1>Danh sách trò chơi trực tiếp
                        <span role="button" data-bs-toggle="tooltip" title="Tải lại trang "
                            class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </h1>
                </div>

            </div>
            <div class=" col-lg-6">
                <div class=" d-flex gap-2 flex-row-reverse bd-highlight">
                    <a href="{{ route('admin.capacit.play.create') }}" class=" btn btn-primary">Bắt đầu trò chơi mới
                    </a>
                    <input value="{{ request()->q ?? '' }}" style="width : 40%" type="text" class="form-control search"
                        placeholder="Tìm kiếm">
                </div>
            </div>
        </div>

        <div class="">
            <table class=" table table-row-bordered table-row-gray-300 gy-7  table-hover  ">
                <thead>
                    <tr>
                        <th>Tên trò chơi </th>
                        <th>Mã trò chơi </th>
                        <th>Chi tiết trò chơi </th>
                        <th>Số điểm </th>
                        <th>Khóa </th>
                        <th>Tình trạng </th>
                        <th>Hình thức </th>
                        <th>Tiến độ </th>
                        <th>Thao tác </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($exams as $key => $exam)
                        <tr>
                            <td> {{ $exam->name }} </td>
                            <td> {{ $exam->room_code }} </td>
                            <td> {{ $exam->description }} </td>
                            <td> {{ $exam->max_ponit }} </td>
                            <td>
                                @if ($exam->status == 2)
                                    <div class="alert alert-primary ">
                                        Đã kết thúc
                                    </div>
                                @else
                                    <div data-bs-toggle="tooltip" title="Cập nhật trạng thái "
                                        class="form-check form-switch">
                                        <input value="{{ $exam->status }}" data-id="{{ $exam->id }}"
                                            class="form-select-status form-check-input" @checked($exam->status == 1)
                                            type="checkbox" role="switch">
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="alert {{ $exam->status == 2 ? 'alert-primary' : 'alert-info' }} ">
                                    {{ $exam->status == 2 ? 'Đã kết thúc' : ($exam->room_token ? 'Đã bắt đầu ' : 'Chưa bắt đầu') }}
                                </div>
                            </td>
                            <td> {{ $exam->type == 1 ? 'Tự động' : 'Điều khiển' }} </td>
                            <td> {{ count($exam->questions) }} /
                                {{ $exam->type == 1 ? 'NO' : count(json_decode($exam->room_progress) ?? []) }}
                            </td>
                            <td>
                                @if ($exam->status == 0)
                                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Stop.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M19.0710678,4.92893219 L19.0710678,4.92893219 C19.4615921,5.31945648 19.4615921,5.95262146 19.0710678,6.34314575 L6.34314575,19.0710678 C5.95262146,19.4615921 5.31945648,19.4615921 4.92893219,19.0710678 L4.92893219,19.0710678 C4.5384079,18.6805435 4.5384079,18.0473785 4.92893219,17.6568542 L17.6568542,4.92893219 C18.0473785,4.5384079 18.6805435,4.5384079 19.0710678,4.92893219 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                @else
                                    <a href="{{ route('admin.capacit.play.show', ['id' => $exam->id]) }}">Xem chi tiết </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{ $exams->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>


    </div>


@endsection
@section('page-script')
    <script>
        const url = " {{ request()->url() }}";
        const _token = "{{ csrf_token() }}";
        const flagReLoad = true;
    </script>
    <script>
        $('.search').on('change', function() {
            window.location = '{{ request()->url() }}?q=' + $(this).val();
        })
        $('.refresh-btn').on('click', function() {
            window.location = '{{ request()->url() }}';
        })
    </script>
    <script src="assets/js/system/exam/exam.js"></script>
@endsection
