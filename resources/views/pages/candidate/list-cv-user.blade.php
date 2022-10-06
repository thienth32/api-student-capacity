@extends('layouts.main')
@section('title', ' Quản lý thông tin ứng tuyển ')
@section('page-title', 'Quản lý thông tin ứng tuyển')
@section('content')

    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.candidate.list') }}" class="pe-3">Thông tin ứng tuyển</a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.post.detail', ['slug' => $candidates[0]->post->slug]) }}" class="pe-3">Mã
                            tuyển
                            dụng
                            :{{ $candidates[0]->post->code_recruitment }} </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">Email: {{ $candidates[0]->email }}</li>
                </ol>
            </div>
        </div>
    </div>


    <div class="table-responsive p-4 card card-flush ">

        @if (count($candidates) > 0)
            <table class=" table table-hover table-responsive-md ">
                <thead>
                    <tr>

                        <th scope="col">Mã tuyển dụng
                        </th>
                        <th scope="col">Thông tin ứng viên
                        </th>
                        <th scope="col">Thời gian ứng tuyển

                        </th>
                        <th scope="col"> Xem CV
                        </th>
                        <th scope="col"> Tải CV
                        </th>

                        <th class="text-center" colspan="2">

                        </th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($candidates as $index => $key)
                        <tr>

                            <td>
                                <a href="{{ route('admin.post.detail', ['slug' => $key->post->slug]) }}">
                                    {{ $key->post->code_recruitment }}</a>
                            </td>
                            <td>
                                <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                    data-bs-target="#introduce_{{ $key->id }}">
                                    {{ $key->name }}
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="introduce_{{ $key->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Thông tin ứng viên
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body  ">
                                                <ul>
                                                    <li>Họ tên : {{ $key->name }} .</li>
                                                    <li>Email : {{ $key->email }} .</li>
                                                    <li>Sdt : {{ $key->phone }} .</li>

                                                </ul>
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
                                {{ date('d-m-Y H:i', strtotime($key->created_at)) }}
                                <br>
                                {{ \Carbon\Carbon::parse($key->created_at)->diffforHumans() }}
                            </td>

                            <td>

                                <a class="show_file btn btn-primary btn-sm" target="_blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl($key->file_link, now()->addMinutes(5)) }}">Xem</a>
                            </td>

                            <td>
                                <a class="download_file btn btn-success btn-sm"
                                    href="{{ route('dowload.file') . '?url=' . $key->file_link }}">Tải
                                    xuống</a>

                            </td>

                            <td>
                                <div data-bs-toggle="tooltip" title="Thao tác " class="btn-group dropstart">
                                    <button type="button" class="btn   btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
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
                                    <ul class="dropdown-menu  px-4 ">
                                        {{-- <li class="my-3">
                                                <a href="{{ route('admin.recruitment.edit', $key->id) }}">
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
                                            </li> --}}
                                        <li class="my-3">
                                            <a href="{{ route('admin.candidate.detail', $key->id) }}">
                                                <span class="svg-icon svg-icon-primary svg-icon-2x ">
                                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Text/Redo.svg--><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24"
                                                                height="24" />
                                                            <path
                                                                d="M21.4451171,17.7910156 C21.4451171,16.9707031 21.6208984,13.7333984 19.0671874,11.1650391 C17.3484374,9.43652344 14.7761718,9.13671875 11.6999999,9 L11.6999999,4.69307548 C11.6999999,4.27886191 11.3642135,3.94307548 10.9499999,3.94307548 C10.7636897,3.94307548 10.584049,4.01242035 10.4460626,4.13760526 L3.30599678,10.6152626 C2.99921905,10.8935795 2.976147,11.3678924 3.2544639,11.6746702 C3.26907199,11.6907721 3.28437331,11.7062312 3.30032452,11.7210037 L10.4403903,18.333467 C10.7442966,18.6149166 11.2188212,18.596712 11.5002708,18.2928057 C11.628669,18.1541628 11.6999999,17.9721616 11.6999999,17.7831961 L11.6999999,13.5 C13.6531249,13.5537109 15.0443703,13.6779456 16.3083984,14.0800781 C18.1284272,14.6590944 19.5349747,16.3018455 20.5280411,19.0083314 L20.5280247,19.0083374 C20.6363903,19.3036749 20.9175496,19.5 21.2321404,19.5 L21.4499999,19.5 C21.4499999,19.0068359 21.4451171,18.2255859 21.4451171,17.7910156 Z"
                                                                fill="#000000" fill-rule="nonzero"
                                                                transform="translate(12.254964, 11.721538) scale(-1, 1) translate(-12.254964, -11.721538) " />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                Chi tiết
                                            </a>
                                        </li>
                                        <li class="my-3">
                                            @hasrole('super admin')
                                                @if ($key->post->count() == 0)
                                                    <form action="{{ route('admin.candidate.destroy', $key->id) }}"
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
                                                @endif
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
            {{ $candidates->appends(request()->all())->links('pagination::bootstrap-4') }}
        @else
            <h2>Ứng viên chưa cập nhật CV !!!</h2>
        @endif

    </div>

@endsection
@section('page-script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="assets/js/system/formatlist/formatlis.js"></script>

@endsection
