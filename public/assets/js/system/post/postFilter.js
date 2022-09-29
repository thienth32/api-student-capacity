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
const Page = {
    changeSlug() {
        $(".name-sl").on("input", function () {
            var slug = to_slug($(this).val());
            $(".slug-sl").val(slug);
        });
        $(".slug-sl").on("change", function () {
            var slug = to_slug($(this).val());
            $(this).val(slug);
        });
    },
};
Page.changeSlug();
$(document).ready(function () {
    $(".click-contest").click(function () {
        $(".click-capacity").removeClass("btn-primary");
        $(".click-round").removeClass("btn-primary");
        $(".click-recruitment").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        $("#capacity").hide(100);
        $("#round").hide(100);
        $("#recruitment").hide(100);
        $("#contest").show(300);
    });
    $(".click-capacity").click(function () {
        $(".click-contest").removeClass("btn-primary");
        $(".click-round").removeClass("btn-primary");
        $(".click-recruitment").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        $("#contest").hide(100);
        $("#round").hide(100);
        $("#recruitment").hide(100);
        $("#capacity").show(300);
    });
    $(".click-round").click(function () {
        $(".click-contest").removeClass("btn-primary");
        $(".click-recruitment").removeClass("btn-primary");
        $(".click-capacity").removeClass("btn-primary");
        $("#capacity").hide(100);
        $("#contest").hide(100);
        $("#recruitment").hide(100);
        $(this).addClass("btn-primary");
        $("#round").toggle(300);
    });
    $(".click-recruitment").click(function () {
        $(".click-contest").removeClass("btn-primary");
        $(".click-round").removeClass("btn-primary");
        $(".click-capacity").removeClass("btn-primary");
        $("#capacity").hide(100);
        $("#contest").hide(100);
        $("#round").hide(100);
        $(this).addClass("btn-primary");
        $("#recruitment").toggle(300);
    });
});
const pageSliderForm = {
    selectRoundChildContest: function () {
        $("#select-contest-p").on("change", function () {
            let id = $(this).val();
            let html = `<option value="0">Chọn vòng thi</option>`;
            html =
                html +
                rounds.map(function (data) {
                    if (id == data.contest_id) {
                        return ` <option value="${data.id}">${data.name} </option>`;
                    }
                    return "";
                });
            $("#select-round").html(html);
        });
    },
    selectChangeStatus: function () {
        $(".form-select-status").on("change", function () {
            let id = $(this).data("id");
            // alert($(this).val());
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/posts/un-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        console.log(data.payload);
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
                    url: `admin/posts/re-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        console.log(data.payload);
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
    selectChangePostHot: function () {
        $(".form-select-post-hot").on("change", function () {
            let id = $(this).data("id");
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/posts/un-hot/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        console.log(data.payload);
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
                    url: `admin/posts/re-hot/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        console.log(data.payload);
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
pageSliderForm.selectRoundChildContest();
pageSliderForm.selectChangeStatus();
pageSliderForm.selectChangePostHot();

$(document).ready(function () {
    const url = "admin/posts";
    $("#select-status").change(function () {
        let status = $(this).val();
        window.location = url + "?status=" + status;
    });
    $("#select-contest").change(function () {
        let contest_id = $(this).val();
        window.location = url + "?contest_id=" + contest_id;
    });
    $("#select-capacity").change(function () {
        let capacity_id = $(this).val();
        window.location = url + "?capacity_id=" + capacity_id;
    });
    $("#select-round").change(function () {
        let round_id = $(this).val();
        window.location = url + "?round_id=" + round_id;
    });
    $("#select-recruitment").change(function () {
        let recruitment_id = $(this).val();
        window.location = url + "?recruitment_id=" + recruitment_id;
    });

    $("#searchTeam").keypress(function (event) {
        var keycode = event.keyCode ? event.keyCode : event.which;
        if (keycode == "13") {
            let key = $(this).val();
            window.location = url + "?keyword=" + key;
        }
    });
    $(".select-date-time").change(function () {
        let dateTime = $(this).val();
        window.location = url + "?progress=" + dateTime;
    });
    $(".select-filter-post-hot").change(function () {
        let parameter = $(this).val();
        window.location = url + "?postHot=" + parameter;
    });

    $(function () {
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
            var results = regex.exec(location.search);
            return results === null
                ? ""
                : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
        const start = getUrlParameter("startTime")
            ? moment(getUrlParameter("startTime"))
            : moment().subtract(29, "days");
        const end = getUrlParameter("endTime")
            ? moment(getUrlParameter("endTime"))
            : moment();
        function cb(start, end, ranges) {
            $("#reportrange span").html(
                start.format("DD/MM/YYYY HH:mm:ss") +
                    " - " +
                    end.format("DD/MM/YYYY HH:mm:ss")
            );
            if (ranges == "Hôm nay") {
                window.location =
                    url +
                    "?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Hôm qua") {
                window.location =
                    url +
                    "?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "7 ngày trước") {
                window.location =
                    url +
                    "?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "30 ngày trước") {
                window.location =
                    url +
                    "?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Tháng này") {
                window.location =
                    url +
                    "?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Tháng trước") {
                window.location =
                    url +
                    "?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Custom Range") {
                window.location =
                    url +
                    "?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            }
        }

        $("#reportrange").daterangepicker(
            {
                startDate: start,
                endDate: end,
                ranges: {
                    "Hôm nay": [moment(), moment()],
                    "Hôm qua": [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "7 ngày trước": [moment().subtract(6, "days"), moment()],
                    "30 ngày trước": [moment().subtract(29, "days"), moment()],
                    "Tháng này": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Tháng trước": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                },
            },
            cb
        );

        cb(start, end, (ranges = ""));
    });
});
