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
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
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
            loadTast();
            url = url + "&major=1";
            if ($(this).val() == 0) return (window.location = url);
            window.location = url + "&major_id=" + $(this).val();
            return false;
        });
    },
    selectRound: function () {
        $("#select-round").on("change", function () {
            loadTast();
            url = url + "&round=1";
            if ($(this).val() == 0) return (window.location = url);
            window.location = url + "&round_id=" + $(this).val();
            return false;
        });
    },
    reHome: function () {
        $(".btn-home-re").on("click", function () {
            loadTast();
            window.location = url + "&home=1";
            return false;
        });
    },
    selectRoundChildContest: function () {
        $("#select-contest-p").on("change", function () {
            let id = $(this).val();
            let html = `<option value="0">Chọn vòng thi</option>`;
            html =
                html +
                rounds.map(function (data) {
                    if (id == data.contest_id) {
                        console.log("asasasas");

                        return ` <option value="${data.id}">${data.name} - ${data.sliders_count} banner</option>`;
                    }
                    return "";
                });
            $("#select-round").html(html);
        });
    },
};
sliderPage.selectChangeStatus();
sliderPage.getText();
sliderPage.selectMajor();
sliderPage.selectRound();
sliderPage.reHome();
sliderPage.selectRoundChildContest();
