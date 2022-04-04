@extends('layouts.main')
@section('title', 'Danh sách ban giám khảo')
@section('page-title', 'Danh sách ban giám khảo')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <form id="formAddJudges" action="{{ route('admin.judge.attachJudge', ['id' => $rounds->id]) }}" method="post">
                @csrf
                <div class="form-group list-group mb-5">
                    <label for="">Ban giám khảo</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="searchUserValue">
                        <button id="searchUser" class="btn btn-secondary " type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Tìm</button>
                        <ul id="resultUserSearch" class="dropdown-menu dropdown-menu-end w-500px">
                        </ul>
                    </div>
                    <div id="resultArrayUser" class=" mt-4">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class=" btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="py-5">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="resultUser">
                            @foreach ($rounds->judges as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <button data-id_user="{{ $user->id }}" class="deleteJudges btn btn-danger">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary ">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path
                                                            d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                        <path
                                                            d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                            Gỡ
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            var userArray = [];

            function loadUserTeam(data) {
                var _html = ``;
                $.map(data, function(val, key) {
                    _html += /*html*/ `
                        <li class="list-group-item py-4">
                            <div class='d-flex justify-content-between align-items-center'>
                                <span>
                                    ${val.email_user}
                                    <input hidden type="text" value="${val.id_user}"  name="user_id[]" >
                                </span>
                                <button data-idUser='${key}' class="deleteUserArray btn btn-danger"   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on top" data-theme="dark" type="button" >
                                    <span class="svg-icon svg-icon-2x svg-icon-primary "><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z" fill="#000000" fill-rule="nonzero"/>
                                        <path d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                    </svg><!--end::Svg Icon--></span>
                                </button>
                            </div>
                        </li>
                    `;
                });
                $('#resultArrayUser').html(_html);
            }
            $(document).on('click', '.deleteUserArray', function(e) {
                e.preventDefault();
                let key = $(this).attr('data-idUser');
                userArray.splice(key, 1)
                // delete userArray[key];
                loadUserTeam(userArray);

            });
            $(document).on('click', '#searchUser', function(e) {

                e.preventDefault();
                let key = $('input#searchUserValue').val();
                if (key != '') {
                    $.ajax({
                        type: "post",
                        url: "{{ route('admin.user.TeamUserSearch') }}",
                        data: {
                            key: key
                        },
                        success: function(response) {
                            var _html = ``;
                            $.map(response, function(val, key) {
                                _html += /*html*/ `
                                    <li><a data-id_user='${val.id}' data-email_user='${val.email}' class="addUserArray dropdown-item py-5" href="javascript:void()">${val.email}</a></li>
                                `;
                            });
                            $('#resultUserSearch').html(_html);
                        }
                    });
                    return;
                } else {
                    toastr.warning('Bạn chưa nhập thông tin cần tìm kiếm !', 'Cảnh báo')
                    return;
                }
            });
            $(document).on('click', '.addUserArray', function(e) {
                e.preventDefault();
                let email = $(this).attr('data-email_user');
                let id = $(this).attr('data-id_user');

                var check = userArray.filter(function(user) {
                    return user.id_user == id;
                })
                if (check.length > 0) {
                    toastr.warning('Thành viên này đã có trong nhóm !')
                } else {
                    userArray.push({
                        'id_user': id,
                        'email_user': email
                    });
                }
                loadUserTeam(userArray);

            });


            function loadJudges() {
                let _html = ``;
                $.ajax({
                    type: "get",
                    url: `{{ route('admin.round.judges.api', ['id' => $rounds->id]) }}`,
                    success: function(response) {
                        (response.payload.judges).map(function(key) {
                            // console.log(key);
                            _html += /*html*/ `
                            <tr>
                                    <td>${key.name }</td>
                                    <td>${ key.email }</td>
                                    <td>
                                        <button data-id_user="${key.id }" class="deleteJudges btn btn-danger">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary ">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path
                                                            d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                        <path
                                                            d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                            Gỡ
                                        </button>
                                    </td>
                                </tr>
                            `;
                        })
                        $('#resultUser').empty();
                        $('#resultUser').html(_html);
                        this.userArray = [];
                    }
                });
                return true;
            }
            $(document).on('submit', '#formAddJudges', function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                if (userArray.length === 0) {
                    toastr.warning('Chưa có giám khảo nào cần thêm !')
                    return;
                } else {
                    $.ajax({
                        method: $(form).attr('method'),
                        url: $(form).attr('action'),
                        data: data,
                        success: function(response) {
                            if (loadJudges() == true) {
                                toastr.success('Thêm giám khảo cho cuộc thi thành công !')
                                return;
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.deleteJudges', function(e) {
                e.preventDefault();
                let id_user = $(this).attr('data-id_user');
                var id = {{ $rounds->id }};
                $.ajax({
                    type: "post",
                    url: `/admin/judges/${id}/detach`,
                    data: {
                        user_id: id_user
                    },
                    success: function(response) {
                        if (loadJudges() == true) {
                            toastr.success('Gỡ giám khảo cho  cuộc thi thành công !')
                            return;
                        }
                    }
                });
            });
        });
    </script>

@endsection
