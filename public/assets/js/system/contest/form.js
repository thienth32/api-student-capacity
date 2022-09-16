const elForm = "#formContest";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    date_start: {
        required: true,
        beginLessEnd: true,
    },
    register_deadline: {
        required: true,
        checkBeginNull: true,
    },
    description: {
        required: true,
    },
    max_user: {
        required: true,
        number: true,
    },
    start_register_time: {
        required: true,
        startTimeCheckBegin: true,
        startTimeCheckEnd: true,
        startTimeCheckLessEnd: true,
    },
    end_register_time: {
        required: true,
    },

    top1: {
        required: true,
        number: true,
    },
    top2: {
        required: true,
        number: true,
    },
    top3: {
        required: true,
        number: true,
    },
    leave: {
        required: true,
        number: true,
    },
    app1: {
        required: true,
    },
    app2: {
        required: true,
    },
};
const messages = {
    top1: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !!",
    },
    top2: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !!",
    },
    top3: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !!",
    },
    leave: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !!",
    },
    max_user: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !!",
    },
    name: {
        required: "Chưa nhập trường này !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    description: {
        required: "Chưa nhập trường này !",
    },
    date_start: {
        required: "Chưa nhập trường này !",
        min: "Không được nhỏ hơn thời gian hiện tại !",
        max: "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc !",
    },
    register_deadline: {
        required: "Chưa nhập trường này !",
        min: "Không được nhỏ hơn thời gian hiện tại !",
    },
    start_register_time: {
        required: "Chưa  nhập trường này !",
        min: "Không được nhỏ hơn thời gian hiện tại !",
        max: "Vui  lòng nhập thời gian đăng kí nhỏ hơn thời gian kết thúc cuộc thi ! ",
    },
    end_register_time: {
        required: "Chưa nhập trường này !",
        min: "Thời gian kết thúc đăng kí phải từ thời gian bắt đầu đăng kí đến thời gian kết thúc cuộc thi !",
        max: "Thời gian kết thúc đăng kí phải nhỏ hơn thời gian bắt đầu cuộc thi!",
    },
    app2: {
        required: "Chưa nhập trường này !",
    },
    app1: {
        required: "Chưa nhập trường này !",
    },
};
let getTimeToday = new Date().toJSON().slice(0, 19);
// $.validator.addMethod(
//     "checkToday",
//     function (value) {
//         if (value > getTimeToday) {
//             return true;
//         }
//     },
//     "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !"
// );
// $('input[name=end_register_time]').on("keyup change", function () {
//     let val = $(this).val();
//     $.validator.addMethod(
//         "checkTime",
//         function (value) {
//             if (value > val) {
//                 return true;
//             }
//         },
//         "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc !!"
//     );
// });

var end_Time = moment().startOf("hour");
var flag = 0;

$("#app1").daterangepicker(
    {
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        startDate: moment($('input[name="date_start"]').val()).startOf("hour"),
        endDate: moment($('input[name="register_deadline"]').val()).startOf(
            "hour"
        ),
        minDate: moment().startOf("hour"),
        opens: "center",
        drops: "auto",
        locale: {
            format: "YYYY/MM/DD HH:mm:ss",
        },
    },
    function (start, end, label) {
        end_Time = end.format("YYYY-MM-DD");
        $('input[name="date_start"]').val(start.format("YYYY/MM/DD HH:mm:ss"));
        $('input[name="register_deadline"]').val(
            end.format("YYYY/MM/DD HH:mm:ss")
        );
        if (flag > 0) {
            $("#app2").val("");
            $('input[name="start_register_time"]').val("");
            $('input[name="end_register_time"]').val("");
        }
    }
);

$("#app2").daterangepicker(
    {
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        startDate: moment($('input[name="start_register_time"]').val()).startOf(
            "hour"
        ),
        endDate: moment($('input[name="end_register_time"]').val()).startOf(
            "hour"
        ),
        // minDate: moment().startOf("hour"),
        opens: "center",
        drops: "auto",
        locale: {
            format: "YYYY/MM/DD HH:mm:ss",
        },
    },
    function (start, end, label) {
        flag = flag + 1;
        $('input[name="start_register_time"]').val(
            start.format("YYYY/MM/DD HH:mm:ss")
        );
        $('input[name="end_register_time"]').val(
            end.format("YYYY/MM/DD HH:mm:ss")
        );
    }
);

$('input[name="app0"]').on("show.daterangepicker", function (ev, picker) {
    if ($('input[name="end_register_time"]').length) {
        picker.minDate = moment(
            $('input[name="end_register_time"]').val()
        ).startOf("hour");
    }
});

$("#app2").on("show.daterangepicker", function (ev, picker) {
    picker.maxDate = moment(end_Time).startOf("hour");
});

$('input[name="app0"]').daterangepicker(
    {
        timePicker: true,
        timePicker24Hour: true,
        singleDatePicker: true,
        showDropdowns: true,
        minDate: moment($('input[name="date_start"]').val()).startOf("hour"),
        locale: {
            format: "YYYY/MM/DD HH:mm:ss",
        },
    },
    function (data) {
        end_Time = data.format("YYYY/MM/DD HH:mm:ss");
        $('input[name="register_deadline"]').val(end_Time);
        if (flag > 0) {
            $("#app2").val("");
            $('input[name="start_register_time"]').val("");
            $('input[name="end_register_time"]').val("");
        }
    }
);
