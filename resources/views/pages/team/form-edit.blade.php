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
        //     $(document).ready(function() {
        //         var userArray = @json($userArray);
        //         loadUserTeam(userArray);

        //         function unique(arr) {
        //             var newArr = []
        //             newArr = arr.filter(function(item) {
        //                 return newArr.includes(item) ? '' : newArr.push(item)
        //             })
        //             return newArr;
        //         }

        //         function loadUserTeam(data) {
        //             var _html = ``;
        //             $.map(data, function(val, key) {
        //                 _html += /*html*/ `
    //                     <li class="list-group-item py-4">
    //                         <div class='d-flex justify-content-between align-items-center'>
    //                             <span>
    //                                 ${val.email_user}
    //                                 <input hidden type="text" value="${val.id_user}"  name="user_id[]" >
    //                             </span>
    //                             <button data-idUser='${key}' class="deleteUserArray btn btn-danger"   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on top" data-theme="dark" type="button" >
    //                                 <span class="svg-icon svg-icon-2x svg-icon-primary "><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    //                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    //                                     <rect x="0" y="0" width="24" height="24"/>
    //                                     <path d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z" fill="#000000" fill-rule="nonzero"/>
    //                                     <path d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
    //                                 </g>
    //                                 </svg><!--end::Svg Icon--></span>
    //                             </button>
    //                         </div>
    //                     </li>
    //                 `;
        //             });
        //             $('#resultArrayUser').html(_html);
        //         }
        //         $(document).on('click', '.deleteUserArray', function(e) {
        //             e.preventDefault();
        //             let key = $(this).attr('data-idUser');
        //             userArray.splice(key, 1)
        //             // delete userArray[key];
        //             loadUserTeam(userArray);

        //         });
        //         $(document).on('click', '#searchUser', function(e) {

        //             e.preventDefault();
        //             let key = $('input#searchUserValue').val();
        //             if (key != '') {
        //                 $.ajax({
        //                     type: "post",
        //                     url: "{{ route('admin.user.TeamUserSearch') }}",
        //                     data: {
        //                         key: key,
        //                         _token: "{{ csrf_token() }}",
        //                     },
        //                     success: function(response) {
        //                         var _html = ``;
        //                         $.map(response, function(val, key) {
        //                             _html += /*html*/ `
    //                                 <li><a data-id_user='${val.id}' data-email_user='${val.email}' class="addUserArray dropdown-item py-5" href="javascript:void()">${val.email}</a></li>
    //                             `;
        //                         });
        //                         $('#resultUserSearch').html(_html);
        //                     }
        //                 });
        //                 return;
        //             } else {
        //                 toastr.warning('Bạn chưa nhập thông tin cần tìm kiếm !', 'Cảnh báo')
        //                 return;
        //             }
        //         });
        //         $(document).on('click', '.addUserArray', function(e) {
        //             e.preventDefault();
        //             let email = $(this).attr('data-email_user');
        //             let id = $(this).attr('data-id_user');
        //             if (userArray.length == 7) {
        //                 toastr.warning('Tối đa 7 thành viên !');
        //                 return;
        //             } else {
        //                 var check = userArray.filter(function(user) {
        //                     return user.id_user == id;
        //                 })
        //                 if (check.length > 0) {
        //                     toastr.warning('Thành viên này đã có trong nhóm !')
        //                 } else {
        //                     userArray.push({
        //                         'id_user': id,
        //                         'email_user': email
        //                     });
        //                 }
        //                 loadUserTeam(userArray);
        //             }
        //         });
        //         $('#editTeam').click(function(e) {
        //             e.preventDefault();
        //             if (userArray.length == 0) {
        //                 toastr.error('Đội này chưa có thành viên  !');
        //                 return;
        //             } else {
        //                 $('#formEditTeam').submit()
        //             }
        //         });
        //     });
        // 
    </script>
    //
    <script>
        //     $("#formEditTeam").validate({
        //         onkeyup: false,
        //         rules: {
        //             name: {
        //                 required: true,
        //                 maxlength: 255
        //             },
        //         },
        //         messages: {
        //             name: {
        //                 required: 'Chưa nhập trường này !',
        //                 maxlength: 'Tối đa là 255 kí tự !'
        //             },
        //         },
        //     });
        // 
    </script>
    <script src="{{ asset('assets/js/system/team/team.js') }}"></script>

@endsection
