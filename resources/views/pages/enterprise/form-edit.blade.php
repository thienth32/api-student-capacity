@extends('layouts.main')
@section('title', 'Quản lý doanh nghiệp')
@section('page-title', 'Quản lý doanh nghiệp')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.enterprise.list') }}" class="pe-3">
                        Danh sách doanh nghiệp
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Cập nhập doanh nghiệp : {{ $enterprise->name }}</li>
            </ol>
        </div>
    </div>
    <div class="card card-flush p-4">
        <div class="row">

            <div class="col-lg-12">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Done-circle.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                    <path
                                        d="M16.7689447,7.81768175 C17.1457787,7.41393107 17.7785676,7.39211077 18.1823183,7.76894473 C18.5860689,8.1457787 18.6078892,8.77856757 18.2310553,9.18231825 L11.2310553,16.6823183 C10.8654446,17.0740439 10.2560456,17.107974 9.84920863,16.7592566 L6.34920863,13.7592566 C5.92988278,13.3998345 5.88132125,12.7685345 6.2407434,12.3492086 C6.60016555,11.9298828 7.23146553,11.8813212 7.65079137,12.2407434 L10.4229928,14.616916 L16.7689447,7.81768175 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <strong></strong> {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @php
                        Session::forget('success');
                    @endphp
                @endif
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
                <form id="formAddEnterprise" action="{{ route('admin.enterprise.update', $enterprise->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')



                    <div class="row">
                        <div class="col-8">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên doanh nghiệp</label>
                                <input type="text" name="name" value="{{ $enterprise->name }}" class=" form-control"
                                    placeholder="">
                                @error('name')
                                    <p id="checkname" class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Địa chỉ Website</label>
                                <input type="text" name="link_web" value="{{ $enterprise->link_web }}"
                                    class=" form-control" placeholder="">
                                @error('link_web')
                                    <p id="checkname" class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Giới thiệu</label>
                                <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">{{ $enterprise->description }}</textarea>
                                {{-- <textarea class="form-control" name="description" value="" id="" rows="3">{{ $enterprise->description }}</textarea> --}}
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10 ">
                                <button type="submit" name="" id=""
                                    class="btn btn-success btn-lg btn-block">Lưu
                                </button>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="" class="form-label">Logo doanh nghiệp</label>
                                <input name="logo" type='file' id="file-input" accept=".png, .jpg, .jpeg"
                                    class="form-control" />
                                <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                    src="{{ $enterprise->logo ? $enterprise->logo : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}" />
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/enterprise/form.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
