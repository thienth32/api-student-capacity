const elForm = "#formRecruitment";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
        hasSpecial: true,
    },
    description: {
        required: true,
    },
    start_time: {
        required: true,
    },
    end_time: {
        required: true,
    },
    amount: {
        required: true,
    },
    cost: {
        required: true,
    },
};
const messages = {
    name: {
        required: "Chưa nhập trường này ! !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    description: {
        required: "Chưa nhập trường này !!",
    },
    start_time: {
        required: "Chưa nhập trường này !!",
        min: "Không được nhỏ hơn thời gian hiện tại !",
        max: "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc !",
    },
    end_time: {
        required: "Chưa nhập trường này !!",
        min: "Không được nhỏ hơn thời gian hiện tại !",
    },
    amount: {
        required: "Chưa nhập trường này !!",
        min: "Không được nhỏ hơn 1 !",
    },
    cost: {
        required: "Chưa nhập trường này !!",
        min: "Không được nhỏ hơn 1 !",
    },
};
// $.validator.addMethod(
//     "greaterThan",
//     function (value, element, params) {
//         if (!/Invalid|NaN/.test(new Date(value))) {
//             return new Date(value) > new Date($(params).val());
//         }
//         return (
//             (isNaN(value) && isNaN($(params).val())) ||
//             Number(value) > Number($(params).val())
//         );
//     },
//     " Yêu cầu lớn hơn thời gian  hiện tại và thời gian  bắt đầu ."
// );
// $.validator.addMethod(
//     "greaterThan",
//     function (value, element, params) {
//         if ($(params).val() != " ") {
//             if (!/Invalid|NaN/.test(new Date(value))) {
//                 return new Date(value) > new Date($(params).val());
//             }
//         }
//     },
//     " Yêu cầu lớn hơn thời gian  hiện tại và thời gian  bắt đầu ."
// );
// $.validator.addMethod(
//     "nowTime",
//     function (value, element) {
//         if (!/Invalid|NaN/.test(new Date(value))) {
//             return new Date(value) > new Date();
//         }
//         // return (
//         //     (isNaN(value) && isNaN($(params).val())) ||
//         //     Number(value) > Number($(params).val())
//         // );
//     },
//     "Yêu cầu phải lớn hơn thời gian hiện tại ."
// );
$.validator.addMethod(
    "hasSpecial",
    function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(value)) {
            return false;
        } else {
            return true;
        }
    },
    "Trường yêu cầu không có kí tự đặc biệt!!!"
);
$(document).ready(function () {
    $("input[name=name]").change(function (e) {
        e.preventDefault();
        $("#checkname").css("display", "none");
    });
    $("input[name=short_name]").change(function (e) {
        e.preventDefault();
        $("#checkshort_name").css("display", "none");
    });
});
