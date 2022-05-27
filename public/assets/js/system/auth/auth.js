const pageAuth = {

    selectChangeStatus: function () {
        $(".form-select-status").on("change", function () {
            let id = $(this).data("id");
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/acount/un-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    },
                });
            } else {
                $.ajax({
                    url: `admin/acount/re-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    },
                });
            }
        });
    },
};
pageAuth.selectChangeStatus();
$('.select-role').on('change', function (){
   let role = $(this).val();
    $.ajax({
        url: `admin/acount/change-role`,
        method: "POST",
        data: {
            _token: _token,
            role: role,
        },
        success: function (data) {
            if(data.status == true)
            {
                loadTast(
                    "Thành công !",
                    "toastr-bottom-left",
                    "success"
                );
            }else{
                loadTast(
                    data.payload,
                    "toastr-bottom-left",
                    "info"
                );
            }
        },
    });
});
$('#select-role').on('change', function(){
    if ($(this).val() == 0) return (window.location = url);
    checkUrlOut("role", $(this).val());
});
