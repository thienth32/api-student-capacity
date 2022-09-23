@extends('layouts.main')
@section('title', 'Quản lý chuyên ngành')
@section('page-title', 'Quản lý chuyên ngành')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.major.list') }}" class="pe-3">
                        Danh sách chuyên ngành
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Cập nhập chuyên ngành : {{ $major->name }} </li>
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
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z"
                                        fill="#000000" opacity="0.3" />
                                    <rect fill="#000000" x="11" y="9" width="2" height="7"
                                        rx="1" />
                                    <rect fill="#000000" x="11" y="17" width="2" height="2"
                                        rx="1" />
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

                <form id="formAddContest" action="{{ route('admin.major.update', ['slug' => $major->slug]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Tên chuyên ngành</label>
                        <input type="text" name="name" value="{{ $major->name }}" class="name-sl form-control"
                            placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Slug chuyên ngành</label>
                        <input type="text" name="slug" value="{{ $major->slug }}" class="slug-sl form-control"
                            placeholder="">
                        @error('slug')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">

                        <label for="" class="form-label">Thuộc chuyên ngành</label>
                        <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="false" tabindex="-1" aria-hidden="true" name="parent_id"
                            value="{{ old('parent_id') }}">
                            @if ($major->parent != null)
                                <option value="0">Không thuộc chuyên ngành nào</option>
                                @foreach ($dataMajor as $Major)
                                    @php
                                        $dash = '';
                                    @endphp
                                    <option @selected($major->parent->id == $Major->id) value="{{ $Major->id }}">Chuyên ngành:
                                        {{ $Major->name }}</option>
                                    @include('pages.major.include.listSelecterChisl', [
                                        'majorPrent' => $Major,
                                        'major' => $major,
                                    ])
                                @endforeach
                            @else
                                <option value="0">Không thuộc chuyên ngành nào</option>
                                @foreach ($dataMajor as $Major)
                                    @php
                                        $dash = '';
                                    @endphp
                                    <option value="{{ $Major->id }}">Chuyên ngành:
                                        {{ $Major->name }}</option>
                                    @include('pages.major.include.listSelecterChisl', [
                                        'majorPrent' => $Major,
                                        'major' => $major,
                                    ])
                                @endforeach
                            @endif


                        </select>

                        @error('major_id')
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
    <script src="assets/js/system/major/major.js"></script>
    <script src="assets/js/system/major/form.js"></script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
