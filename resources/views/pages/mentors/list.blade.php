@extends('layouts.main')
@section('title', 'Quản lý mentor')
@section('page-title', 'Quản lý mentor')
@section('content')
    <div class="card card-flush p-4">
        <div class="row">
            <div class=" col-lg-6">
                <h1>Danh sách mentor
                    <a href="{{ route('admin.mentor.list') }}">
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
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_mentor_no_account">
                        Thêm mentors chưa có tài khoản
                    </button>

                    <button class="btn btn-primary mx-2" type="button" data-bs-toggle="modal" data-bs-target="#add_mentors_has_account">
                        Thêm mentors đã có tài khoản (trừ tài khoản có quyền admin/super admin)
                    </button>

                    <!-- Modal add mentors have account-->
                    <div class="modal fade" id="add_mentors_has_account" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Thêm mentors từ tài khoản có trong hệ thống
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.mentor.addMentorsHaveAccount') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Chọn mentor</label>
                                            <select 
                                                id="selectUser" 
                                                class="form-select mb-2 select2-hidden-accessible"
                                                data-control="select2"
                                                data-hide-search="false" 
                                                tabindex="-1" 
                                                aria-hidden="true" 
                                                name="mentor_ids[]"
                                                multiple="multiple"
                                            >
                                                @foreach ($availableMentors as $m)
                                                    <option value="{{ $m->id }}"> {{ $m->name }} ({{$m->email}}) </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                Thêm Mentor
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal add mentors have no account-->
                    <div class="modal fade" id="add_mentor_no_account" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Thêm mentors chưa có tài khoản trong hệ thống
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.mentor.addMentorNoAccount') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3 form-group">
                                                    <label class="form-label">Họ tên</label>
                                                    <input class="form-control" type="text" name="name" value="{{old('name')}}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="">Avatar</label>
                                                    <input name="avatar" type='file' id="file-input" class="form-control" />
                                                    <img class="mt-2 border rounded-3" style="max-height:150px;" id="image-preview"
                                                        src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label">Khu vực</label>
                                                    <select name="location" class="form-control">
                                                        <option value="" disabled>Chọn tỉnh / thành</option>
                                                        @foreach(config('util.PROVINCES') as $key => $province)
                                                            <option value="{{$key}}"> {{$province}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3 form-group">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" type="email" name="email" value="{{old('email')}}">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label">Trình độ học vấn</label>
                                                    <input class="form-control" type="text" name="education" value="{{old('education')}}">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label">Kinh nghiệm làm việc</label>
                                                    <input class="form-control" type="text" name="experience" value="{{old('experience')}}">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label">Vị trí công tác</label>
                                                    <input class="form-control" type="text" name="position" value="{{old('position')}}">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label">Thông tin thêm</label>
                                                    <textarea class="form-control" type="text" name="note">{{old('note')}}</textarea>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                Thêm Mentor
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            @if (count($mentors) > 0)
                <table class="table table-row-bordered table-row-gray-300 gy-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Khu vực</th>
                            <th scope="col">Kinh nghiệm làm việc</th>
                            <th scope="col">Trình độ học vấn</th>
                            <th scope="col">Vị trí công tác</th>
                            <th scope="col">Thông tin thêm</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mentors as $item)
                            <tr>
                                <td>
                                    <span> {{ $item->name }} </span>
                                </td>
                                <td>
                                    <span>{{ $item->email }}</span>
                                </td>
                                <td>
                                    <img style="max-height:150px; object-fit:cover;" src="{{ $item->avatar ?? 'assets/media/avatars/blank.png' }}" alt="">
                                </td>
                                <td>
                                    <span>{{ $item->info?->location ? $item->info->location_name : 'No data' }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->info?->experience ?? 'No data' }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->info?->education ?? 'No data' }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->info?->position ?? 'No data' }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->info?->note ?? 'No data' }}</span>
                                </td>
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
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#add_mentor_info_{{$item->id}}">
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
                                                    Bổ sung thông tin
                                                </a>
                                            </li>

                                            <li class="my-3">
                                                <form action="{{ route('admin.mentor.delete', ['mentor' => $item->id]) }}"
                                                    id="delete_{{$item->id}}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                        style=" background: none ; border: none ; list-style : none"
                                                        type="submit">
                                                        <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">
                                                            <!-- begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
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
                                                            <!-- end::Svg Icon-->
                                                        </span>
                                                        Xóa bỏ
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal cập nhật thông tin mentor-->
                            <div class="modal fade" id="add_mentor_info_{{$item->id}}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                Bổ sung thông tin cho {{$item->name}} ({{$item->email}})
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.mentor.saveInfo') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="mentor_id" value="{{$item->id}}">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label">Khu vực</label>
                                                            <select name="location" class="form-control">
                                                                <option value="" disabled>Chọn tỉnh / thành</option>
                                                                @foreach(config('util.PROVINCES') as $key => $province)
                                                                    <option value="{{$key}}" 
                                                                        @selected(old('location', $item->info?->location) == $key)>
                                                                        {{$province}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label">Kinh nghiệm làm việc</label>
                                                            <input class="form-control" type="text" name="experience" value="{{old('experience', $item->info?->experience)}}">
                                                        </div>
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label">Trình độ học vấn</label>
                                                            <input class="form-control" type="text" name="education" value="{{old('education', $item->info?->education)}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label">Vị trí công tác</label>
                                                            <input class="form-control" type="text" name="position" value="{{old('position', $item->info?->position)}}">
                                                        </div>
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label">Thông tin thêm</label>
                                                            <textarea class="form-control" type="text" name="note">{{old('note', $item->info?->note)}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        Lưu thông tin
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                {{ $mentors->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Không có dữ liệu !!!</h2>
            @endif
        </div>
    </div>


@endsection

@section('page-script')
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script>
    $(document).ready(function() {
        $('#selectUser').select2({
            dropdownParent: $('#add_mentors_has_account'),
            placeholder: "Chọn user",
            width: '100%',
            closeOnSelect: false
        });
    });

    preview.showFile('#file-input', '#image-preview');
    </script>
@endsection
