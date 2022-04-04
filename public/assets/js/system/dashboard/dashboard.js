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
