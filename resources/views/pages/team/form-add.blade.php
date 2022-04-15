@extends('layouts.main')
@section('title', 'Thêm đội thi')
@section('page-title', 'Thêm đội thi')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formTeam" action="{{ route('admin.teams.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group mb-10">
                                <label for="">Tên đội thi</label>
                                <input type="text" name="name" value="{{ old('name') }}" class=" form-control"
                                    placeholder="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Thuộc cuộc thi</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="contest_id"
                                    value="{{ old('contest_id') }}">
                                    @foreach ($contests as $contest)
                                        <option value="{{ $contest->id }}">
                                            {{ $contest->name }}</option>
                                    @endforeach
                                </select>
                                @error('contest_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group list-group mb-5">
                                <label for="">Thành viên nhóm</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="searchUserValue">
                                    <button id="searchUser" class="btn btn-secondary rounded-end" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Tìm</button>
                                    <ul id="resultUserSearch" class="dropdown-menu dropdown-menu-end w-500px">
                                    </ul>
                                </div>


                                @if (session()->has('error'))
                                    <p class="text-danger">{{ session()->get('error') }}</p>
                                    @php
                                        Session::forget('error');
                                    @endphp
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="" class="form-label">Ảnh cuộc thi</label>
                                <input value="{{ old('image') }}" name="image" type='file' id="file-input"
                                    accept=".png, .jpg, .jpeg" class="form-control" />
                                <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="resultArrayUser" class=" mt-4">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-10 ">
                        <button type="submit" id="addTeam" class="btn btn-success btn-lg btn-block">Lưu </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
        var userArray = [];
        var _token = "{{ csrf_token() }}"
        var urlSearch = "{{ route('admin.user.TeamUserSearch') }}"
    </script>
    <script src="{{ asset('assets/js/system/team/validateForm.js') }}"></script>
    <script src="{{ asset('assets/js/system/validate/validate.js') }}"></script>
    <script src="{{ asset('assets/js/system/team/team.js') }}"></script>
@endsection
