@extends('layouts.main')
@section('title', 'Chỉnh sửa đội thi')
@section('page-title', 'Chỉnh sửa đội thi')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formTeam" action="{{ route('admin.teams.update', ['id' => $team->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group mb-10">
                                    <label for="">Tên đội thi</label>
                                    <input type="text" name="name" value="{{ old('name', $team->name) }}"
                                        class=" form-control" placeholder="">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thuộc cuộc thi</label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" data-placeholder="Select an option" tabindex="-1"
                                        aria-hidden="true" name="contest_id" value="{{ old('contest_id') }}">
                                        <option data-select2-id="select2-data-130-vofb"></option>
                                        @foreach ($contests as $contest)
                                            <option value="{{ $contest->id }}"
                                                {{ $team->contest_id === $contest->id ? 'selected' : '' }}>
                                                {{ $contest->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('contest_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-10 ms-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-3">
                                        <span>Ảnh đội thi</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Allowed file types: png, jpg, jpeg."
                                            aria-label="Allowed file types: png, jpg, jpeg."></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Image input wrapper-->
                                    <div class="mt-1">
                                        <!--begin::Image input-->
                                        <div style="position: relative" class="image-input image-input-outline"
                                            data-kt-image-input="true"
                                            style="background-image: url('{{ Storage::disk('google')->has($team->image)? Storage::disk('google')->url($team->image): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-100px h-100px"
                                                style="background-image: url('{{ Storage::disk('google')->has($team->image)? Storage::disk('google')->url($team->image): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}')">
                                            </div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Edit-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input value="{{ old('image') }}" type="file" name="image"
                                                    accept=".png, .jpg, .jpeg">
                                                {{-- <input type="hidden" name="avatar_remove"> --}}
                                                <!--end::Inputs-->
                                                <style>
                                                    label#image-error {
                                                        position: absolute;
                                                        min-width: 150px;
                                                        top: 500%;
                                                        right: -100%;
                                                    }

                                                </style>
                                            </label>
                                            <!--end::Edit-->
                                            <!--begin::Cancel-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group list-group mb-5">
                            <label for="">Thành viên nhóm</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="searchUserValue">
                                <button id="searchUser" class="btn btn-secondary " type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Tìm</button>
                                <ul id="resultUserSearch" class="dropdown-menu dropdown-menu-end w-500px">
                                </ul>
                            </div>
                            <div id="resultArrayUser" class=" mt-4">
                            </div>
                            @if (session()->has('error'))
                                <p class="text-danger">{{ session()->get('error') }}</p>
                                @php
                                    Session::forget('error');
                                @endphp
                            @endif
                        </div>

                    </div>
                    <div class="form-group mb-10 ">
                        <button type="submit" id="editTeam" class="btn btn-success btn-lg btn-block">Lưu </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        var userArray = @json($userArray);
        var _token = "{{ csrf_token() }}"
        var urlSearch = "{{ route('admin.user.TeamUserSearch') }}"
    </script>
    <script src="{{ asset('assets/js/system/team/team.js') }}"></script>

@endsection
