// Set list query url
const aListQuery = [
    "page",
    "major_id",
    "q",
    "sort_by",
    "status",
    "sort",
    "contest_id",
    "type_exam_id",
    "round_id",
    "major",
    "round",
    "start_time",
    "end_time",
    "pass_date",
    "upcoming_date",
    "miss_date",
    "day",
    "month",
    "year",
    "op_time",
    "home",
    "role",
    "skill",
    "level",
    "type",
];

// Set list query has one
const aListHasOne = [
    "day",
    "month",
    "year",
    "op_time",
    "start_time",
    "end_time",
    "home",
    "major",
    "major_id",
    "round",
    "round_id",
];

const checkOutHasMatchLocal = [
    "home",
    "major",
    "major_id",
    "round",
    "round_id",
];

const checkOutHasMatchTime = [
    "day",
    "month",
    "year",
    "op_time",
    "start_time",
    "end_time",
];

// Search params
let searchParams = new URLSearchParams(window.location.search);

//Set up toast

// Funtion check url
function checkUrlOut(key, value, valueAdd = "") {
    loadTast();
    if (window.location.href.indexOf("?")) {
        aListQuery.map(function (data) {
            if (data == key) {
                url = url + "&" + key + "=" + value;
            } else {
                if (searchParams.has(data)) {
                    url = url + "&" + data + "=" + searchParams.get(data);
                }
            }
        });
        return (window.location = url + valueAdd);
    }
    window.location = window.location.href + "?" + key + "=" + value;
    return false;
}

// Function check match local url
function checkUrlHasMatchSelectLocal(dataCreate = []) {
    dataCreate.map(function (data) {
        if (searchParams.has(data))
            url = url + "&" + data + "=" + searchParams.get(data);
    });
}

// Function check urls
function checkUrlOuts(key, val) {
    key.map(function (data, key) {
        url = url + "&" + data + "=" + val[key];
    });
    // Check
    checkOutUrl();
}

// Funtion check has url
function checkOutUrl() {
    aListQuery.map(function (data) {
        if (searchParams.has(data)) {
            if (!aListHasOne.includes(data)) {
                url = url + "&" + data + "=" + searchParams.get(data);
            }
        }
    });
    window.location = url;
    return false;
}

// Loas tast
function loadTast(
    text = "Đang chạy ...",
    page = "toastr-bottom-left",
    type = "info"
) {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: page,
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    if (type === "info") toastr.info(text);
    if (type === "success") toastr.success(text);
}

// Page
const formatPage = {
    refresh: function () {
        $(".refresh-btn").on("click", function () {
            loadTast();
            window.location = url;
            return false;
        });
    },
    formatDatabase: function () {
        $(".format-database").on("click", function () {
            loadTast();
            window.location =
                url + "sort_by=" + $(this).data("key") + "&sort=" + sort;
            return false;
        });
    },
    searchData() {
        $(".ip-search").on("keyup", function (e) {
            if (e.keyCode == 13) {
                checkUrlOut("q", $(this).val());
            }
        });
    },
    startTime() {
        $(".btn-time").on("click", function (e) {
            e.preventDefault();
            let start_time = $(".start_time").val();
            let end_time = $(".end_time").val();
            if (new Date(start_time).getTime() >= new Date(end_time).getTime())
                return alert(
                    "Thời gian kết thúc phải lớn hơn thời gian bắt đầu thời gian bắt đâu !"
                );
            checkUrlOuts(["start_time", "end_time"], [start_time, end_time]);
            // window.location =
            //     url + "&start_time=" + start_time + "&end_time=" + end_time;
        });
    },
    showPage() {
        $(".card-format").hide();
        $(".btn-hide").hide();
        $(".btn-show").show();
        $(".btn-hide").on("click", function () {
            $(".card-format").hide(1000);
            $(this).hide();
            $(".btn-show").show(500);
        });
    },
    hidePage() {
        $(".btn-show").on("click", function () {
            $(".card-format").show(1000);
            $(".btn-hide").show(500);
            $(this).hide();
        });
    },
    setUpRangpake() {
        $("#kt_daterangepicker_2").daterangepicker(
            {
                timePicker: true,
                startDate: moment(start_time).format("DD/MM/YYYY hh:mm:ss A"),
                endDate: moment(end_time).format("DD/MM/YYYY hh:mm:ss A"),
                locale: {
                    format: "DD/MM/YYYY hh:mm:ss A",
                },
            },
            function (start, end) {
                loadTast();
                checkUrlHasMatchSelectLocal(checkOutHasMatchLocal);
                checkUrlOuts(
                    ["start_time", "end_time"],
                    [
                        moment(start).format("YYYY-MM-DDThh:mm"),
                        moment(end).format("YYYY-MM-DDThh:mm"),
                    ]
                );
                return false;
            }
        );
    },
    addTimeLocal: function () {
        $(".click-time-local").on("click", function () {
            $("#time").hide();
            $(".click-time").removeClass("btn-primary");
            $(this).addClass("btn-primary");
            $("#time-local").show();
        });
        $(".click-time").on("click", function () {
            $("#time-local").hide();
            $(".click-time-local").removeClass("btn-primary");
            $(this).addClass("btn-primary");
            $("#time").show();
        });
    },
    selectDateSearch: function () {
        $(".select-date-serach").on("change", function () {
            loadTast();
            const value = $(this).val();
            checkUrlHasMatchSelectLocal(checkOutHasMatchLocal);
            switch (value) {
                case "add-day-7":
                    checkUrlOuts(["day", "op_time"], [7, "add"]);
                    return false;
                case "add-day-15":
                    checkUrlOuts(["day", "op_time"], [15, "add"]);
                    return false;
                case "add-month-1":
                    checkUrlOuts(["month", "op_time"], [1, "add"]);
                    return false;
                case "add-month-6":
                    checkUrlOuts(["month", "op_time"], [6, "add"]);
                    return false;
                case "add-year-1":
                    checkUrlOuts(["year", "op_time"], [1, "add"]);
                    return false;
                case "sub-day-7":
                    checkUrlOuts(["day", "op_time"], [7, "sub"]);
                    return false;
                case "sub-day-15":
                    checkUrlOuts(["day", "op_time"], [15, "sub"]);
                    return false;
                case "sub-month-1":
                    checkUrlOuts(["month", "op_time"], [1, "sub"]);
                    return false;
                case "sub-month-6":
                    checkUrlOuts(["month", "op_time"], [6, "sub"]);
                    return false;
                case "sub-year-1":
                    checkUrlOuts(["year", "op_time"], [1, "sub"]);
                    return false;
                default:
                    break;
            }
        });
    },
    selectStatus: function () {
        $("#select-status").on("change", function () {
            if ($(this).val() == 3) return (window.location = url);
            checkUrlOut("status", $(this).val());
        });
    },
    selectChangeStatus: function (
        url_un_status,
        url_re_status,
        select = ".form-select-status"
    ) {
        function removeDisabled(val, element, time) {
            $(element).val(val);
            return setTimeout(() => {
                $(element).prop("disabled", false);
            }, time);
        }
        $(select).on("change", function () {
            var that = this;
            let id = $(this).data("id");
            $(this).prop("disabled", true);
            if ($(this).val() == 1) {
                $.ajax({
                    url: url_un_status,
                    method: "POST",
                    data: {
                        _token: _token,
                        id: id,
                    },
                    success: function (data) {
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
                    url: url_re_status,
                    method: "POST",
                    data: {
                        _token: _token,
                        id: id,
                    },
                    success: function (data) {
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

// Run
formatPage.refresh();
formatPage.formatDatabase();
formatPage.searchData();
formatPage.showPage();
formatPage.hidePage();
formatPage.setUpRangpake();
formatPage.addTimeLocal();
formatPage.selectDateSearch();
formatPage.selectStatus();
