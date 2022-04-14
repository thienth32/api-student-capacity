const sliderPage = {
    selectChangeStatus: function () {
        $(".form-select-status").on("change", function () {
            let id = $(this).data("id");
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/sliders/un-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                    },
                });
            } else {
                $.ajax({
                    url: `admin/sliders/re-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                    },
                });
            }
        });
    },
    getText: function () {
        $(".coppyText").on("click", function () {
            let id = $(this).data("key");
            var textCoppy = $("#text_" + id);
            navigator.clipboard.writeText(textCoppy.text());
            loadTast("Đã coppy", "toastr-bottom-left", "success");
        });
    },
    selectMajor: function () {
        $("#select-major").on("change", function () {
            if ($(this).val() == 0) return (window.location = url);
            checkUrlOut("major_id", $(this).val());
        });
    },
};
sliderPage.selectChangeStatus();
sliderPage.getText();
sliderPage.selectMajor();
