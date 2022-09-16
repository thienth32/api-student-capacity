const elForm = "#formAddRound";
const onkeyup = false;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    start_time: {
        required: true,
    },
    end_time: {
        required: true,
    },
    description: {
        required: true,
    },
    app1: {
        required: true,
    },
};
const messages = {
    name: {
        required: "Trường name không bỏ trống !",
        maxlength: "Tối đa là 255 kí tự !",
    },

    description: {
        required: "Trường mô tả không bỏ trống !",
    },
    start_time: {
        required: "Chưa nhập trường này !",
        min: "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !",
        max: "Trường thời gian bắt đầu không lớn hơn trường kết thúc  !",
    },
    end_time: {
        required: "Chưa nhập trường này !",
        min: "Trường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
    },
    app1: {
        required: "Chưa nhập trường này !",
    },
};

$("#app1").daterangepicker(
    {
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        startDate: moment($('input[name="start_time"]').val()).startOf("hour"),
        endDate: moment($('input[name="end_time"]').val()).startOf("hour"),
        minDate: moment().startOf("hour"),
        opens: "center",
        drops: "auto",
        locale: {
            format: "YYYY/MM/DD HH:mm:ss",
        },
    },
    function (start, end, label) {
        $('input[name="start_time"]').val(start.format("YYYY/MM/DD HH:mm:ss"));
        $('input[name="end_time"]').val(end.format("YYYY/MM/DD HH:mm:ss"));
    }
);
$('input[name="app0"]').daterangepicker(
    {
        timePicker: true,
        timePicker24Hour: true,
        singleDatePicker: true,
        showDropdowns: true,
        minDate: moment($('input[name="start_time"]').val()).startOf("hour"),
        locale: {
            format: "YYYY/MM/DD HH:mm:ss",
        },
    },
    function (data) {
        end_Time = data.format("YYYY/MM/DD HH:mm:ss");
        $('input[name="end_time"]').val(end_Time);
    }
);
