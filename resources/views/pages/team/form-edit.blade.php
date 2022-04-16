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
                        <div class="col-lg-8">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên đội thi</label>
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
                            <div class="form-group list-group mb-5">
                                <label class="form-label" for="">Thành viên nhóm</label>
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
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                    src="{{ Storage::disk('google')->has($team->image)? Storage::disk('google')->url($team->image): 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }} " />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group list-group mb-5">
                                <div id="resultArrayUser" class=" mt-4">
                                </div>
                            </div>
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
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
        var userArray = @json($userArray);
        var _token = "{{ csrf_token() }}"
        var urlSearch = "{{ route('admin.user.TeamUserSearch') }}"
    </script>
    <script src="{{ asset('assets/js/system/team/team.js') }}"></script>
@endsection
