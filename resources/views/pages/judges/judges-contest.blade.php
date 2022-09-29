@extends('layouts.main')
@section('title', 'Quản lý cuộc thi')
@section('page-title', 'Quản lý cuộc thi')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc
                        thi</a>
                </li>
                <li class="breadcrumb-item px-3 ">
                    <a href="{{ route('admin.contest.show', ['id' => $contest->id]) }}" class="pe-3">
                        {{ $contest->name }}
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">
                    Danh sách ban giám khảo của {{ $contest->name }}
                </li>
            </ol>
        </div>
    </div>
    <div class=" card card-flush p-5">
        <div class="row">
            <div class="col-lg-12">
                <form id="formJudges">
                    @csrf
                    <div class="form-group list-group">
                        <div class="input-group mb-3">
                            <input type="text" placeholder="Tìm ban giám khảo thêm vô cuộc thi ..." class="form-control"
                                id="searchUserValue">
                            <button id="searchUser" type="button" class="btn btn-primary">Tìm</button>
                        </div>
                        <ul id="resultUserSearch" class="border">
                        </ul>
                        <div id="resultArrayUser" class="">
                        </div>
                    </div>
                    <button type="button" id="attachJudges" class="btn btn-primary btn-sm"> Thêm </button>
                </form>
            </div>
        </div>

    </div>

    <div class="row mt-5">
        {{-- @if (session()->has('error'))
            <p class="text-danger">{{ session()->get('error') }}</p>
            <div class="row d-flex justify-content-end align-items-end">
                <div class="col-lg-4">
                    <div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row p-5 mb-10">
                        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr012.svg-->
                            <span class="svg-icon svg-icon-light svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                        fill="black" />
                                    <path
                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                        fill="black" />
                                </svg></span>
                            <!--end::Svg Icon-->
                        </span>
                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                            <h4 class="mb-2 light">Thành công !</h4>
                            <span>{{ session()->get('error') }}</span>
                        </div>
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs012.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                        fill="black" />
                                    <path
                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                        fill="black" />
                                </svg></span>
                            <!--end::Svg Icon-->
                        </button>
                    </div>

                </div>
            </div>
            @php
                Session::forget('error');
            @endphp
        @endif --}}
        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th>#</th>
                                <th>Email</th>
                                <th>Họ tên</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($contest->judges as $user)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <button data-id_user="{{ $user->id }}"
                                            class="deleteJudges btn btn-danger">Gỡ</button>
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
        var max_user = 100;
        var id_contest = "{{ $contest->id }}"
        var judges = 0;
        var _token = "{{ csrf_token() }}"
        var urlSearch = "{{ route('admin.user.TeamUserSearch') }}"
        var URL_ATTACH = "{{ route('admin.judges.attach', ['contest_id' => $contest->id]) }}"
        var URL_SYNC = "{{ route('admin.judges.sync', ['contest_id' => $contest->id]) }}"
        var URL_DETACH = "{{ route('admin.judges.detach', ['contest_id' => $contest->id]) }}"
    </script>
    <script src="{{ asset('assets/js/system/team/team.js') }}"></script>
    <script src="{{ asset('assets/js/system/judges/judges-contest.js') }}"></script>
@endsection
