@extends('layouts.main')
@section('title', 'Quản lý Q&A')
@section('page-title', 'Quản lý Q&A')
@section('content')
    <div class="card card-flush p-4">
        <div class="row">
            <div class=" col-lg-6">
                <h1>Danh sách Q&A
                    <a href="{{ route('admin.faq.list') }}">
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
                    </a>
                </h1>
            </div>
            <div class=" col-lg-6">
                <div class=" d-flex flex-row-reverse bd-highlight">
                    <a href="{{ route('admin.faq.create') }}" class=" btn btn-primary">
                        Tạo mới câu hỏi
                    </a>
                </div>
            </div>
        </div>

        <div class="row card-format">
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="  form-group p-2">
                    <label class="form-label">Tìm kiếm câu hỏi</label>
                    <input id="searchQuestion" type="text" value="{{ request('q') ?? '' }}"
                        placeholder="'*Enter' tìm kiếm ..." class=" ip-search form-control">
                </div>
            </div>
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group  pt-2">
                    <label for="" class="form-label">Danh mục</label>
                    <select id="select-category" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option class="form-control" value="" disabled selected>Chọn danh mục</option>
                        @foreach ($categories as $root)
                            <option @selected(request('category_id') == $root->id) value="{{ $root->id }}"> {{ $root->name }} </option>
                            @foreach ($root->children as $child)
                                <option @selected(request('category_id') == $child->id) value="{{$child->id}}">&nbsp;&nbsp;&nbsp;&nbsp;└─ {{$child->name}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="back">
            <hr>
            <span data-bs-toggle="tooltip" title="Đóng lọc" class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
            </span>

            <span data-bs-toggle="tooltip" title="Mở lọc" style="display: none"
                class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>

        </div>
        <div class="table-responsive">
            @if (count($faqs) > 0)
                <table class="table table-row-bordered table-row-gray-300 gy-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col-3">Câu hỏi
                                <a
                                    href="{{ route('admin.faq.list', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'question',
                                    ]) }}">
                                    <span role="button" data-key="question" data-bs-toggle="tooltip"
                                        title="Lọc theo câu hỏi"
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                    x="5" y="5" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                    x="17" y="7" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>

                            </th>
                            <th scope="col-3">Trả lời</th>
                            <th scope="col-1">Chủ đề</th>
                            <th scope="col-1">Lượt xem</th>
                            <th scope="col-1">Upvote</th>
                            <th scope="col-1">Downvote</th>
                            <th scope="col-1">Ngày tạo
                                <a
                                    href="{{ route('admin.faq.list', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'created_at',
                                    ]) }}">
                                    <span role="button" data-key="end_time" data-bs-toggle="tooltip"
                                        title="Lọc theo ngày tạo "
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                    x="5" y="5" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                    x="17" y="7" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>

                            </th>
                            <th class="text-center">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faqs as $item)
                            <tr>
                                <td>
                                    <button class="p-3" style="border:none;background:none; text-align: left;" type="button">
                                        <span>{!! Str::limit(strip_tags($item->question), 200, '...') !!}</span>
                                    </button>
                                </td>
                                <td>
                                    <span>{!! Str::limit(strip_tags($item->answer), 200, '...') !!}</span>
                                </td>
                                <td>
                                    @if (!isset($item->category))
                                    <span class="badge bg-warning">Chưa có danh mục</span>
                                    @else 
                                        @if(isset($item->category->parent))
                                        <span class="badge bg-success">{{ $item->category->parent->name }}</span>
                                        @endif
                                        <span class="badge bg-success my-1">{{ $item->category->name }}</span>
                                    @endif
                                </td>
                                <td><p>{{ $item->view }}</p></td>
                                <td><p>{{ $item->upRatings->count() }}</p></td>
                                <td>
                                    @if ($item->downRatings->count() != 0)
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#down_ratings_{{ $item->id }}">
                                            {{ $item->downRatings->count() }}
                                        </a>
                                    @else 
                                        <p>{{ $item->downRatings->count() }}</p>
                                    @endif
                                    <!-- Modal -->
                                    <div class="modal fade" id="down_ratings_{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Danh sách downvote
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="container table">
                                                        @forelse ($item->downRatings as $index => $down)
                                                            <tr>
                                                                <td class="col-1">{{ $index + 1 }}</td>
                                                                <td class="col-10">{{ $down->content }}</td>
                                                                <td class="col-1">
                                                                    <form action="{{ route('admin.faq.deleteRate', $down->id) }}"
                                                                        id="delete_{{$down->id}}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                                            style=" background: none ; border: none ; list-style : none"
                                                                            type="submit">
                                                                            <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">
                                                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                                        fill-rule="evenodd">
                                                                                        <rect x="0" y="0" width="24"
                                                                                            height="24" />
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
                                                                </td>
                                                            </tr>
                                                        @empty
                                                        @endforelse
                                                    </table>
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
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <div data-bs-toggle="tooltip" title="Thao tác" class="btn-group dropstart">
                                        <button type="button" class="btn btn-sm dropdown-toggle"
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
                                                <a href="{{ route('admin.faq.edit', $item->id) }}">
                                                    <span role="button" class="svg-icon svg-icon-success svg-icon-2x">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Edit.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
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
                                                <form action="{{ route('admin.faq.delete', $item->id) }}"
                                                    id="delete_{{$item->id}}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                        style=" background: none ; border: none ; list-style : none"
                                                        type="submit">
                                                        <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">
                                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
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
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                {{ $faqs->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Không tìm thấy câu hỏi nào !!!</h2>
            @endif
        </div>
    </div>


@endsection

@section('page-script')
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchQuestion').keypress(function(event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    let key = $(this).val();
                    // alert(key)
                    window.location = 'admin/question-and-answer?keyword=' + key;
                }
            });

            $("#select-category").change(function () {
                let categoryId = $(this).val();
                window.location = 'admin/question-and-answer?category_id=' + categoryId;
            });
        });
    </script>

@endsection
