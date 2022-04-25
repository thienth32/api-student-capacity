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
            if ($(this).val() == 0) return (window.location = url);
            checkUrlHasMatchSelectLocal(checkOutHasMatchTime);
            checkUrlOuts(["major", "major_id"], [1, $(this).val()]);
            return false;
        });
    },
    selectRound: function () {
        $("#select-round").on("change", function () {
            loadTast();
            if ($(this).val() == 0) return (window.location = url);
            checkUrlHasMatchSelectLocal(checkOutHasMatchTime);
            checkUrlOuts(["round", "round_id"], [1, $(this).val()]);
            return false;
        });
    },
    reHome: function () {
        $(".btn-home-re").on("click", function () {
            loadTast();
            checkUrlOuts(["home"], [1]);
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

// Run
sliderPage.selectChangeStatus();
sliderPage.getText();
sliderPage.selectMajor();
sliderPage.selectRound();
sliderPage.reHome();
sliderPage.selectRoundChildContest();
