const elForm = "#formContest";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    date_start: {
        required: true,
        beginLessEnd: true
    },
    register_deadline: {
        required: true,
        checkBeginNull: true

    },
    description: {
        required: true,
    },
    max_user: {
        required: true,
        number: true
    },
    start_register_time: {
        required: true,
        startTimeCheckBegin: true,
        startTimeCheckEnd: true,
        startTimeCheckLessEnd: true
    },
    end_register_time: {
        required: true,
    },

    top1: {
        required: true,
        number: true
    },
    top2: {
        required: true,
        number: true
    },
    top3: {
        required: true,
        number: true
    },
    leave: {
        required: true,
        number: true
    },
};
const messages = {
    top1: {
        required: "Chưa nhập trường này !",
        number: 'Sai định dạng !!'
    },
    top2: {
        required: "Chưa nhập trường này !",
        number: 'Sai định dạng !!'
    },
    top3: {
        required: "Chưa nhập trường này !",
        number: 'Sai định dạng !!'
    },
    leave: {
        required: "Chưa nhập trường này !",
        number: 'Sai định dạng !!'
    },
    max_user: {
        required: "Chưa nhập trường này !",
        number: 'Sai định dạng !!'
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