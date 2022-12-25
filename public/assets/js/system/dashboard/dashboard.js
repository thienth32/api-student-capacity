"use strict";
var dashboardPage = {
    initPage: function(){
        var start = moment().subtract(15, "days");
        var end = moment();

        // apply daterangepicker cho biểu đồ
        this.daterangepicker_chart_init(start, end);
        var that = this;
        // load biểu đồ khi tải xong tài nguyên
        KTUtil.onDOMContentLoaded(async function() {
            let chartData = await that.getDataChart(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            KTChartsWidget18.init(chartData);
        });

        $("#daterange_picker_chart").on('apply.daterangepicker', async function(ev, picker) {

            KTChartsWidget18.clearChart();
            KTChartsWidget18.init(await that.getDataChart(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD')));
        })
    },
    getDataChart: async function(start, end){
        let urlChartData = $('#url_chart_data').val();
        const responseListContests = await fetch(`${urlChartData}?startDate=${start}&endDate=${end}`)
        const listContests = await responseListContests.json();
        return listContests;
    },
    daterangepicker_chart_init: function(start, end){

        $("#daterange_picker_chart").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            "Today": [moment(), moment()],
            "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, function(start, end){
            $("#daterange_picker_chart").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
        });
    }
}

/**
 *  get rank contest
 * @param {*} contestID
 */
async function fetchRankContest(contestID) {

    $('#rank-contest').html(`Đang chạy ...`);
    await $.ajax({
        type: "GET",
        url: "admin/dashboard/rank-contest?contest_id=" + contestID,
        success: function(response) {
            var html = response.data.map(function(data) {
                return `
                        <div>
                            <h5 style="text-align: center;">${data.name}</h5>
                            <table class="table table-row-dashed table-row-gray-300 gy-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800">
                                        <th>Hạng</th>
                                        <th>Đội thi</th>
                                        <th>Tổng điểm</th>
                                    </tr>
                                </thead>
                                <tbody id='dataTable'>
                                        ${handleRankContest(data.results)}
                                </tbody>
                            </table>
                            <hr>
                        </div>
                `;
            }).join(" ");
            $('#rank-contest').html(html);
        }
    });
}

function handleRankContest(data){
    if(data.length < 1){
        return `<h5>Không có bảng xếp hạng</h5>` ;
    }else{
        var result = data.map(function(item,index){
        return ` <tr>
                        <td
                            style="color: #0e0759;
                            font-size: 16px;
                            line-height: 22.4px;
                            font-weight: 400;
                            vertical-align: middle;
                            height: 60px;
                            padding: 10px;"
                        >
                        ${++index}
                        </td>
                        <td>
                            <img
                                style="border-radius: 100px;
                                display: inline-block;
                                height: 50px;
                                width: 50px;
                                "
                                src="${item.team.image ? item.team.image : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRI7M4Z0v1HP2Z9tZmfQaZFCuspezuoxter_A&usqp=CAU'}"
                            >
                        <span
                                style="display: inline-block;
                                color: #0e0759;
                                margin: 0 0 0 10px;
                                font-size: 14px;
                                line-height: 22.4px;
                                font-weight: 400;"
                        >
                                ${item.team.name}
                            </span>
                        </td>
                        <td
                            style="color: var(--my-primary);
                            font-size: 15px;
                            line-height: 22.4px;
                            font-weight: 400;
                            vertical-align: middle;
                            text-align: center;
                            height: 60px;
                            padding: 10px;"
                        >
                            ${item.point}
                        </td>
                </tr> `
        }).join(" ");
    return result;
    }

}

$('#selectContest').change(function() {
    let idContest = $(this).val();
    fetchRankContest(idContest);
})
