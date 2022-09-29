@extends('layouts.main')
@section('title', 'Quản lý cuộc thi')
@section('page-title', 'Quản lý cuộc thi')
@section('content')

    {{-- <div class="row">
            <div class="col-lg-12">
                <form id="formTeam" action="{{ route('admin.contest.detail.team.addSelect', ['id' => $contest->id]) }}"
                    method="POST">
                    @csrf
                    <label for="" class="form-label">Thêm đội thi từ cuộc thi khác</label>
                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="team_id"
                        value="{{ old('team_id') }}">
                        @foreach ($teams as $teamSelect)
                            <option class="d-flex justify-content-between" value="{{ $teamSelect->id }}">
                                {{ $teamSelect->name }}
                                <span> ------------------------ </span>
                                {{ $teamSelect->contest == null ? 'Chưa thuộc cuộc thi nào' : 'Thuộc cuộc thi : ' . $teamSelect->contest->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary"> Lưu </button>

                </form>
            </div>
        </div> --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.contest.list') }}" class="pe-3">
                        Danh sách cuộc thi</a>
                </li>
                <li class="breadcrumb-item px-3 ">
                    <a href="{{ route('admin.contest.show', ['id' => $contest->id]) }}" class="pe-3">
                        {{ $contest->name }}
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">
                    Danh sách đội thi
                </li>
            </ol>
        </div>

    </div>
    <div class=" card card-flush  p-5">
        <div class="row">
            <div class="col-lg-12 ">
                <div class=" d-flex justify-end">

                    <a class="ms-auto btn btn-primary"
                        href="{{ route('admin.contest.detail.team.add.form', ['id' => $contest->id]) }}">Tạo mới đội
                        thi</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th>#</th>
                                <th>Ảnh</th>
                                <th>Tên đội</th>
                                <th>Thành viên</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($contest->teams as $team)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>

                                        <img class='w-100px'
                                            src="{{ $team->image ? $team->image : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                            alt="">
                                    </td>
                                    <td>{{ $team->name }}</td>
                                    <td>
                                        <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal_{{ $team->id }}">
                                            Xem Thêm
                                        </button>

                                        <!-- Modal -->
                                        <div style="margin:auto" class="modal fade " id="exampleModal_{{ $team->id }}"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Các Thành Viên
                                                            Trong
                                                            Team
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body  ">
                                                        @if (count($team->members) > 0)
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Họ Tên</th>
                                                                        <th>Email</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $indexUser = 1; ?>
                                                                    @foreach ($team->members as $user)
                                                                        <tr>

                                                                            <td>{{ $indexUser++ }}</td>
                                                                            <td>{{ $user->name }}</td>
                                                                            <td>{{ $user->email }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <h3> Chưa có thành viên</h3>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Thoát
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="btn-group dropstart">
                                            <button type="button" class="btn   btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
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
                                            <ul class="dropdown-menu  px-4 ">
                                                <li class="my-3">
                                                    <a
                                                        href="{{ route('admin.contest.detail.team.edit.form', ['id' => $contest->id, 'id_team' => $team->id]) }}">
                                                        <span role="button" class="svg-icon svg-icon-success svg-icon-2x">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
                                                                    <path
                                                                        d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                                    <rect fill="#000000" opacity="0.3" x="5"
                                                                        y="20" width="15" height="2"
                                                                        rx="1" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        Chỉnh sửa
                                                    </a>
                                                </li>

                                                <li class="my-3">
                                                    @hasrole(config('util.ROLE_DELETE'))
                                                        <form
                                                            action="{{ route('admin.contest.destroy', ['id' => $contest->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                                style=" background: none ; border: none ; list-style : none"
                                                                type="submit">
                                                                <span role="button"
                                                                    class="svg-icon svg-icon-danger svg-icon-2x">
                                                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="24px" height="24px" viewBox="0 0 24 24"
                                                                        version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                            fill-rule="evenodd">
                                                                            <rect x="0" y="0"
                                                                                width="24" height="24" />
                                                                            <path
                                                                                d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                                                fill="#000000" fill-rule="nonzero" />
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
                                                    @else
                                                        <div style="cursor: not-allowed; user-select: none">

                                                            <span class="svg-icon svg-icon-danger svg-icon-2x">
                                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Lock-circle.svg--><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24"
                                                                            height="24" />
                                                                        <circle fill="#000000" opacity="0.3" cx="12"
                                                                            cy="12" r="10" />
                                                                        <path
                                                                            d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z"
                                                                            fill="#000000" />
                                                                    </g>
                                                                </svg>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            Xóa bỏ
                                                        </div>
                                                    @endhasrole

                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        var URL = window.location.href;
        var userArray = [];
        var _token = "{{ csrf_token() }}"
        var urlSearch = "{{ route('admin.user.TeamUserSearch') }}"
        var URL_ATTACH = "{{ route('admin.judges.attach', ['contest_id' => $contest->id]) }}"
        var URL_SYNC = "{{ route('admin.judges.sync', ['contest_id' => $contest->id]) }}"
        var URL_DETACH = "{{ route('admin.judges.detach', ['contest_id' => $contest->id]) }}"
    </script>
    <script>
        const elForm = "#formTeam";
        const onkeyup = true;
        const rules = {
            team_id: {
                required: true,
            }
        };
        const messages = {
            team_id: {
                required: 'Chưa chọn đội !!',
            }
        };
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
