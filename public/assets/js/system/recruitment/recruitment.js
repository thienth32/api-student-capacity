$(document).ready(function () {
    $("#selectEnterprise").change(function () {
        let enterpriseId = $(this).val();
        window.location = "admin/recruitment?enterprise_id=" + enterpriseId;
    });
    $("#selectContest").change(function () {
        let idContest = $(this).val();
        window.location = "admin/recruitment?contest_id=" + idContest;
    });

    $("#searchTeam").keypress(function (event) {
        var keycode = event.keyCode ? event.keyCode : event.which;
        if (keycode == "13") {
            let key = $(this).val();
            window.location = "admin/recruitment?keyword=" + key;
        }
    });
    $(".select-date-time").change(function () {
        let dateTime = $(this).val();
        window.location = "admin/recruitment?progress=" + dateTime;
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
                    "admin/recruitment?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Hôm qua") {
                window.location =
                    "admin/recruitment?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "7 ngày trước") {
                window.location =
                    "admin/recruitment?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "30 ngày trước") {
                window.location =
                    "admin/recruitment?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Tháng này") {
                window.location =
                    "admin/recruitment?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Tháng trước") {
                window.location =
                    "admin/recruitment?startTime=" +
                    start.format("MMMM D, YYYY HH:mm:ss") +
                    "&endTime=" +
                    end.format("MMMM D, YYYY HH:mm:ss");
            } else if (ranges == "Custom Range") {
                window.location =
                    "admin/recruitment?startTime=" +
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
