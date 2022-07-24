$(document).ready(function () {
    const url = "admin/recruitment";
    $("#selectEnterprise").change(function () {
        let enterpriseId = $(this).val();
        window.location = url + "?enterprise_id=" + enterpriseId;
    });
    $("#selectContest").change(function () {
        let idContest = $(this).val();
        window.location = url + "?contest_id=" + idContest;
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

    $(".select-type-recruitment").change(function () {
        let typeRecruitemnt = $(this).val();
        window.location = url + "?recruitmentHot=" + typeRecruitemnt;
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
const pageRecruitmentForm = {
    selectChangeStatus: function () {
        $(".form-select-status-hot").on("change", function () {
            let id = $(this).data("id");
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/recruitment/un-hot/${id}`,
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
                    url: `admin/recruitment/re-hot/${id}`,
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

pageRecruitmentForm.selectChangeStatus();
