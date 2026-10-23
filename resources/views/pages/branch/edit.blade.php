@extends('layouts.main')
@section('title', 'Quản lý cơ sở')
@section('page-title', 'Quản lý cơ sở')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.branch.list') }}" class="pe-3">
                        Danh sách cơ sở
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Cập nhập cơ sở : {{ $branch->name }} </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="svg-icon svg-icon-danger svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Warning-2.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path
                                d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z"
                                fill="#000000" opacity="0.3"/>
                            <rect fill="#000000" x="11" y="9" width="2" height="7" rx="1"/>
                            <rect fill="#000000" x="11" y="17" width="2" height="2" rx="1"/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                        <strong></strong> {{ session()->get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @php
                        Session::forget('error');
                    @endphp
                @endif

                <form id="formAddContest" action="{{ route('admin.branch.update', ['branch_id' => $branch->id]) }}"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    @role(config('util.ROLE_DELETE'))
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Tên cơ sở</label>
                        <input type="text" name="name" value="{{ $branch->name }}" class="name-sl form-control"
                               placeholder="">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Mã code cơ sở</label>
                        <input type="text" name="code" value="{{ $branch->code }}" class="slug-sl form-control"
                               placeholder="">
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-5 row">
                        <div class="col-6">
                            <label class="form-label" for="">Số điện thoại</label>
                            <input type="text" name="phone" value="{{ $branch->phone }}" class="slug-sl form-control"
                                   placeholder="">
                            @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ $branch->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $branch->status == 0 ? 'selected' : '' }}>Không hoạt động
                                </option>
                            </select>
                            @error('status')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-5 row">
                        <div class="col-6">
                            <label class="form-label" for="">Email</label>
                            <input type="text" name="email" value="{{ $branch->email }}" class="slug-sl form-control"
                                   placeholder="">
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="">Website</label>
                            <input type="text" name="website" value="{{ $branch->website }}"
                                   class="slug-sl form-control" placeholder="">
                            @error('website')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Địa chỉ</label>
                        <input type="text" name="address" value="{{ $branch->address }}" class="slug-sl form-control"
                               placeholder="">
                        @error('address')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <label for="" class="form-label">Tài khoản quản lý cơ sở</label>
                        <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="branch_admin_id"
                                value="{{ old('branch_admin_id') }}">
                            @foreach ($admins as $admin)
                                <option @selected($admin->branch_id == $branch->id) value="{{ $admin->id }}">
                                    {{ $admin->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_admin_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    @endrole
                    <div class="form-group mb-5">
                        <label for="" class="form-label">Danh sách nhân viên cơ sở</label>
                        <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" multiple tabindex="-1" aria-hidden="true"
                                name="branch_staff_ids[]" value="{{ old('branch_staff_ids') }}">
                            @foreach ($staffs as $staff)
                                <option
                                    @selected(in_array($staff->id, $currentBranchStaffs->pluck('id')->toArray())) value="{{ $staff->id }}">
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('staff_ids')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id="" class="btn btn-success btn-lg btn-block">Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="assets/js/system/branch/branch.js"></script>
    <script src="assets/js/system/branch/form.js"></script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
