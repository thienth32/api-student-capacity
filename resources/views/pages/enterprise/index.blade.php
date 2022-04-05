@extends('layouts.main')
@section('title', 'Danh sách vòng thi ')
@section('content')
    <div class="card card-flush p-4">
        <h1>Quản lý Doanh Nghiệp
            <span role="button" class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                    viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                            d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                            fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </h1>
        <div class="row card-format mt-5">
            <div class="col-md-4">
                <div style="width:300px" class="form-group mb-5">
                    <label for="">
                        <h3>Tài trợ cuộc thi</h3>
                    </label>
                    <select class="form-control" name="" id="selectContest">
                        <option value="">___CHỌN CUỘC THI___</option>
                        @foreach ($contest as $itemContest)
                            <option value="{{ $itemContest->id }}">Cuộc thi: {{ $itemContest->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div style="width:300px" class="form-group mb-5">
                    <label for="">
                        <h3>Sắp xếp </h3>
                    </label>

                    <select class="form-control" name="" id="selectOderByTeam">
                        <option>___CHỌN___</option>
                        <option value="name">Sắp xếp theo tên</option>
                        <option value="created_at">Sắp xếp theo Thời gian</option>
                        {{-- <option value="id">Doanh nghiệp nổi bật</option> --}}
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div style="width:300px" class="form-group mb-5">
                    <label for="">
                        <h3>Tìm Kiếm Doanh Nghiệp</h3>
                    </label>


                    <div class="form-group">
                        <input id="searchTeam" placeholder="Nhập Tên nhóm...." type="text" class="form-control" name=""
                            aria-describedby="helpId" placeholder="">

                    </div>


                </div>
            </div>
        </div>
        <div class="back">
            <hr>
            <span class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                    viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
            </span>

            <span style="display: none" class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                    viewBox="0 0 24 24" version="1.1">
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
        <div class="table-responsive p-4 card card-flush ">
            @if (isset($listEnterprise))
                @if (count($listEnterprise) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên Doanh Nghiệp</th>
                                <th scope="col">Giới Thiệu</th>
                                <th scope="col">Logo Doanh Nghiệp </th>
                                <th scope="col"> Tài trợ các cuộc thi </th>
                            </tr>
                        </thead>
                        <tbody id="dataTeams">
                            <?php $index = 0; ?>
                            @foreach ($listEnterprise as $value)
                                <tr>
                                    <th scope="row">{{ $index += 1 }}</th>
                                    <td>{{ $value->name }}</td>

                                    <td>

                                        <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal_{{ $value->id }}">
                                            click...
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_{{ $value->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Giới Thiệu Về
                                                            Doanh
                                                            Nghiệp
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body  ">
                                                        {{ $value->description }}
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
                                    <td><img style="width:200px;height:200px"
                                            src="{{ Storage::disk('google')->has($value->logo)? Storage::disk('google')->url($value->logo): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                            alt=""></td>

                                    <td>
                                        <div class="btn-group dropup">
                                            <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#Donors{{ $value->id }}">
                                                Xem thông tin... </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="Donors{{ $value->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> Các Cuộc thi
                                                                được
                                                                tài
                                                                trợ
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body  ">
                                                            <ul style="font-style:20px">
                                                                @foreach ($value->donors as $item)
                                                                    @if (empty($item->name))
                                                                        <li> Không Tài trợ cuộc thi nào !!!!</li>
                                                                    @else
                                                                        <li style="padding: 10px;font-style:25px"> Cuộc
                                                                            Thi:{{ $item->name }}
                                                                    @endif
                                                                @endforeach
                                                                <ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Thoát
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    <td> <a onclick="remove({{ $value->id }})" class="btn btn-danger"><i
                                                class="fas fa-trash-alt"></i></a>

                                        <a href="{{ route('admin.enterprise.edit', $value->id) }}"
                                            class="btn  btn-success "><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                    <hr>
                    <div>
                        {{ $listEnterprise->appends(request()->all())->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <h2> Không Tìm Thấy Doanh Nghiệp !!!</h2>
                @endif
            @else
                @if (count($Enterprise[0]->enterprise) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên Doanh Nghiệp</th>
                                <th scope="col">Giới Thiệu</th>
                                <th scope="col">Logo Doanh Nghiệp </th>
                                <th scope="col"> Tài trợ các cuộc thi </th>
                            </tr>
                        </thead>
                        <tbody id="dataTeams">
                            <?php $index = 0; ?>
                            @foreach ($Enterprise[0]->enterprise as $value)
                                <tr>
                                    <th scope="row">{{ $index += 1 }}</th>
                                    <td>{{ $value->name }}</td>

                                    <td>

                                        <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal_{{ $value->id }}">
                                            click...
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_{{ $value->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Giới Thiệu Về
                                                            Doanh
                                                            Nghiệp
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body  ">
                                                        {{ $value->description }}
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
                                    <td><img style="width:200px;height:200px"
                                            src="{{ Storage::disk('google')->has($value->logo)? Storage::disk('google')->url($value->logo): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                            alt=""></td>

                                    <td>
                                        <div class="btn-group dropup">
                                            <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#Donors{{ $value->id }}">
                                                Xem thông tin... </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="Donors{{ $value->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> Các Cuộc thi
                                                                được
                                                                tài
                                                                trợ
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body  ">
                                                            <ul style="font-style:20px">
                                                                @foreach ($value->donors as $item)
                                                                    @if (empty($item->name))
                                                                        <li> Không Tài trợ cuộc thi nào !!!!</li>
                                                                    @else
                                                                        <li style="padding: 10px;font-style:25px"> Cuộc
                                                                            Thi:{{ $item->name }}
                                                                    @endif
                                                                @endforeach
                                                                <ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Thoát
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    <td> <a onclick="remove({{ $value->id }})" class="btn btn-danger"><i
                                                class="fas fa-trash-alt"></i></a>

                                        <a href="{{ route('admin.enterprise.edit', $value->id) }}"
                                            class="btn  btn-success "><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                    <hr>
                    <div>
                        {{ $Enterprise->appends(request()->all())->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <h2> Không Tìm Thấy Doanh Nghiệp !!!</h2>
                @endif
            @endif
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {

            $('#selectContest').change(function() {
                let idContest = $(this).val();
                window.location = 'admin/enterprise?contest=' + idContest;
            })
            $('#selectOderByTeam').change(function() {
                let key = $(this).val();
                if (key == 'name') {
                    window.location = 'admin/enterprise?orderBy=' + key;
                } else if (key == 'created_at') {
                    window.location = 'admin/enterprise?orderBy=' + key;
                }
            })
            $('#searchTeam').blur(function() {
                let key = $(this).val();

                window.location = 'admin/enterprise?keyword=' + key;
            })
        })

        function remove(id) {
            Swal.fire({
                title: 'Bạn có muốn xóa không?',
                text: "Sẽ không thể phục hồi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'admin/enterprise/' + id,
                        type: 'delete',
                        data: {
                            _token: "{{ csrf_token() }}",

                        },
                        success: function(response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Xóa Thành Công',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(() => {
                                location.reload()
                            }, 1000);

                        }
                    })






                }
            })


        }
    </script>
@endsection
