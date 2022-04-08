const teamPage = {
    searchUserDB: function() {
        // tìm kiếm người dùng trong db và in ra màn  hình để  thêm vô mảng 
        $(document).on('click', '#searchUser', function(e) {
            e.preventDefault();
            let key = $('input#searchUserValue').val();
            if (key != '') {

                $.ajax({
                    type: "post",
                    url: urlSearch,
                    data: {
                        key: key,
                        _token: _token,
                    },
                    success: function(response) {
                        var _html = ``;
                        $.map(response, function(val, key) {
                            _html += /*html*/ `
                                <li><a data-id_user='${val.id}' data-email_user='${val.email}' class="addUserArray dropdown-item py-5" href="javascript:void()">${val.email}</a></li>
                            `;
                        });
                        $('input#searchUserValue').val();
                        $('#resultUserSearch').html(_html);
                    }
                });
                return;
            } else {
                toastr.warning('Bạn chưa nhập thông tin cần tìm kiếm !', 'Cảnh báo')
                return;
            }
        });
    },

    userArray: function(userArray) {
        loadUserTeam(userArray);
        // function load mảng  user  và in ra màn  hình 
        function loadUserTeam(data) {
            var _html = ``;
            $.map(data, function(val, key) {
                _html += /*html*/ `
                    <li class="list-group-item py-4">
                        <div class='d-flex justify-content-between align-items-center'>
                            <span>
                                ${val.email_user} 
                                <input hidden type="text" value="${val.id_user}" class="user_id"  name="user_id[]" >
                            </span>
                            <button data-idUser='${key}' class="deleteUserArray btn btn-danger"   data-bs-toggle="tooltip" data-bs-placement="right" title="Xóa người dùng khỏi danh sách chờ !" data-theme="dark" type="button" >
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

        // thêm người dùng vô mảng  và in  ra màn hình
        $(document).on('click', '.addUserArray', function(e) {
            e.preventDefault();
            let email = $(this).attr('data-email_user');
            let id = $(this).attr('data-id_user');
            if (userArray.length == 7) {
                toastr.warning('Tối đa 7 thành viên !');
                return;
            } else {
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
            }
        });

        // xóa user ra khỏi mảng
        $(document).on('click', '.deleteUserArray', function(e) {
            e.preventDefault();
            let key = $(this).attr('data-idUser');
            userArray.splice(key, 1)
            loadUserTeam(userArray);
        });
    },
}
teamPage.userArray(userArray);
teamPage.searchUserDB();