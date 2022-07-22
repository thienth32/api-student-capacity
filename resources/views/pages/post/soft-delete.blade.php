@extends('layouts.main')
@section('title', 'Danh sách các bài viết đã xóa ')
{{-- @section('page-title', 'Danh sách các vòng thi đã xóa ') --}}
@section('content')

    <div class="card card-flush p-4">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.post.list') }}">Bài viết</a></li>
                <li class="breadcrumb-item disable" aria-current="page">Backup
                    <a href="{{ route('admin.post.list.soft.deletes', 'post_soft_delete=1') }}">

                        <span role="button" class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
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

                </li>
            </ol>
        </nav>



        <div>
            <div class="  form-group p-2">
                <label>Tìm kiếm </label>
                <input id="searchTeam" type="text" value="{{ request('keyword') ?? '' }}"
                    placeholder="'*Enter' tìm kiếm ..." class=" ip-search form-control">
            </div>
        </div>

        <div class="table">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu Đề</th>
                        <th scope="col">Ngày xuất bản</th>
                        <th scope="col">Thuộc thành phần</th>
                        <th scope="col">Nội dung</th>
                        <th></th>
                        <th scope="col">Xóa ngày</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($listSofts) > 0)
                        @foreach ($listSofts as $key => $listSoft)
                            <tr>
                                <td>
                                    {{ (request()->has('page') && request('page') !== 1 ? $listSofts->perPage() * (request('page') - 1) : 0) + $key + 1 }}
                                </td>
                                <td>
                                    {{ $listSoft->title }}
                                </td>
                                <td>
                                    {{ date('d-m-Y H:i', strtotime($listSoft->published_at)) }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($listSoft->published_at)->diffforHumans() }}
                                </td>
                                <td>
                                    @if (get_class($listSoft->postable) == \App\Models\Round::class)
                                        Vòng thi : <b><a
                                                href="{{ route('admin.round.detail', ['id' => $listSoft->postable->id]) }}">{{ $listSoft->postable->name }}</a></b>
                                    @elseif (get_class($listSoft->postable) == \App\Models\Recruitment::class)
                                        Tuyển dụng :
                                        <b><a
                                                href="{{ route('admin.recruitment.detail', ['id' => $listSoft->postable->id]) }}">{{ $listSoft->postable->name }}</a></b>
                                    @else
                                        Cuộc thi : <b><a
                                                href="{{ route('admin.contest.show', ['id' => $listSoft->postable->id]) }}">{{ $listSoft->postable->name }}</a></b>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#introduce_{{ $listSoft->id }}">
                                        Xem
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="introduce_{{ $listSoft->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"> Thông tin tuyển dụng
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body  ">
                                                    @if (is_null($listSoft->content))
                                                        <div class="col-md-3 mx-auto">
                                                            <a href="{{ $listSoft->link_to }}">
                                                                <div
                                                                    class="badge badge-primary badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                                                    <div class="m-0  ">
                                                                        <span class="text-white-700 fw-bold fs-6">Xem tại
                                                                            đây</span>
                                                                    </div>

                                                                </div>
                                                            </a>
                                                        </div>
                                                    @else
                                                        {!! $listSoft->content !!}
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
                                <td>
                                <td>
                                    {{ $listSoft->deleted_at }}
                                    <p>{{ \Carbon\Carbon::parse($listSoft->deleted_at)->diffForHumans() }}</p>
                                </td>
                                <td>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn   btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="svg-icon svg-icon-success svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path
                                                            d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu px-4 ">

                                            <li class="my-3">
                                                <a href="{{ route('admin.post.soft.deletes', ['id' => $listSoft->id]) }}">
                                                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Files/Cloud-upload.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <path
                                                                    d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(11.959697, 18.661508) rotate(-90.000000) translate(-11.959697, -18.661508) " />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    Khôi phục
                                                </a>


                                            </li>
                                            {{-- <li class="my-3">
                                                @hasrole('super admin')
                                                    <a
                                                        href="{{ route('admin.post.soft.restore', ['id' => $listSoft->id]) }}">
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
                                                        Xóa vv
                                                    </a>
                                                @else
                                                    <span style="cursor: not-allowed; user-select: none"
                                                        class="svg-icon svg-icon-danger svg-icon-2x">
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
                                                    Xóa vĩnh viễn
                                                @endhasrole

                                            </li> --}}
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><span class="badge bg-primary">! Không có file khôi phục </span></tr>
                    @endif


                </tbody>
            </table>
            {{ $listSofts->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>

    </div>

@endsection
@section('page-script')
    <script>
        let url = '/admin/posts/list-soft-deletes?post_soft_delete=1&keyword=';
        $('#searchTeam').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                let key = $(this).val();
                // alert(key)
                window.location = url + key;
            }

        });
    </script>

@endsection
