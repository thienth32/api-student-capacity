const aListQuery = [
    "page",
    "major_id",
    "q",
    "sort_by",
    "status",
    "sort",
    "contest_id",
    "type_exam_id",
    "start_time",
    "end_time",
    "pass_date",
    "upcoming_date",
    "miss_date",
];
let searchParams = new URLSearchParams(window.location.search);

function checkUrlOut(key, value, valueAdd = "") {
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
}
$(".refresh-btn").on("click", function () {
    window.location = url;
});
$(".format-database").on("click", function () {
    window.location = url + "sort_by=" + $(this).data("key") + "&sort=" + sort;
});
$(".ip-search").on("keyup", function (e) {
    if (e.keyCode == 13) {
        checkUrlOut("q", $(this).val());
    }
});
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
