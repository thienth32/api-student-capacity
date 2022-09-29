function to_slug(str) {
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, "a");
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, "e");
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, "i");
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, "o");
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, "u");
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, "y");
    str = str.replace(/(đ)/g, "d");

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, "");

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, "-");

    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, "");

    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, "");

    // return
    return str;
}

function to_en(str) {
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, "a");
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, "e");
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, "i");
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, "o");
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, "u");
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, "y");
    str = str.replace(/(đ)/g, "d");

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, "");

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, " ");

    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, "");

    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, "");

    // return
    return str;
}
// Page major
const keyword = {
    changeSlug() {
        $("input[name='keyword']").on("input", function() {
            var slug = to_slug($(this).val());
            var string_en = to_en($(this).val());
            $("input[name='keyword_slug']").val(slug);
            $("input[name='keyword_en']").val(string_en);
        });
        // $("input[name='keyword']").on("change", function() {
        //     var slug = to_slug($(this).val());
        //     $(this).val(slug);
        // });
    },
    selectTypeList: function(element = '#select-type') {
        $(element).change(function() {
            let val = $(this).val();
            if (val == 3) {
                window.location = url;
                return;
            }
            checkUrlOut('type', val)
        })
    },
    selectChangeStatus: function(element) {
        function removeDisabled(val, element, time) {
            $(element).val(val);
            return setTimeout(() => {
                $(element).prop("disabled", false);
            }, time);
        }
        $(element).on("change", function() {
            loadTast();
            var that = this;
            $(this).prop("disabled", true);
            let id = $(this).data("id");
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/keywords/un-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        if (!data.status) return alert(data.payload);
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                        removeDisabled(0, that, 3000);
                    },
                });
            } else {
                $.ajax({
                    url: `admin/keywords/re-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        if (!data.status) return alert(data.payload);
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                        removeDisabled(1, that, 3000);
                    },
                });
            }
        });
    },
};