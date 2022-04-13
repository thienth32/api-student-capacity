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
];

const aListHasOne = [
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
                // console.log(data);
                // let checkLength = aListHasOne.filter(function (d) {
                //     return d === searchParams.has(data);
                // });
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
// console.log("Start time ", url);

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
            window.location =
                url + "&start_time=" + start_time + "&end_time=" + end_time;
        });
    },
    showPage() {
        $(".btn-show").hide();
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
                // startDate: moment(),
                // endDate: moment(),
                locale: {
                    format: "DD/MM/YYYY hh:mm:ss A",
                },
            },
            function (start, end) {
                loadTast();
                window.location =
                    url +
                    "&start_time=" +
                    moment(start).format("YYYY-MM-DDThh:mm") +
                    "&end_time=" +
                    moment(end).format("YYYY-MM-DDThh:mm");
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
            switch (value) {
                case "add-day-7":
                    window.location = url + "&day=" + 7 + "&op_time=add";
                    return false;
                case "add-day-15":
                    window.location = url + "&day=" + 15 + "&op_time=add";
                    return false;
                case "add-month-1":
                    window.location = url + "&month=" + 1 + "&op_time=add";
                    return false;
                case "add-month-6":
                    window.location = url + "&month=" + 6 + "&op_time=add";
                    return false;
                case "add-year-1":
                    window.location = url + "&year=" + 1 + "&op_time=add";
                    return false;
                case "sub-day-7":
                    window.location = url + "&day=" + 7 + "&op_time=sub";
                    return false;
                case "sub-day-15":
                    window.location = url + "&day=" + 15 + "&op_time=sub";
                    return false;
                case "sub-month-1":
                    window.location = url + "&month=" + 1 + "&op_time=sub";
                    return false;
                case "sub-month-6":
                    window.location = url + "&month=" + 6 + "&op_time=sub";
                    return false;
                case "sub-year-1":
                    window.location = url + "&year=" + 1 + "&op_time=sub";
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
};

formatPage.refresh();
formatPage.formatDatabase();
formatPage.searchData();
formatPage.startTime();
formatPage.showPage();
formatPage.hidePage();
formatPage.setUpRangpake();
formatPage.addTimeLocal();
formatPage.selectDateSearch();
formatPage.selectStatus();
