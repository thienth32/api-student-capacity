const elForm = "#formAddEnterprise";
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
    //không bắt buộc nhập link website
    // link_web: {
    //     required: true,
    // },
    tax_number: {
        required: true,
    },
    address: {
        required: true,
    },
    contact_name: {
        required: true,
        maxlength: 255,
    },
    contact_email: {
        required: true,
        maxlength: 255,
    },
    contact_phone: {
        required: true,
        maxlength: 20,
    }
};
const messages = {
    name: {
        required: "Tên doanh nghiệp không bỏ trống !",
        maxlength: "Tối đa là 255 kí tự !",
    },

    description: {
        required: "Trường mô tả không bỏ trống !",
    },
    //cho phép bỏ trống link website
    // link_web: {
    //     required: "Trường không bỏ trống !",
    // },
    address: {
        required: "Địa chỉ không bỏ trống !",
    },
    tax_number: {
        required: "Mã số thuế không bỏ trống",
    },
    contact_name: {
        required: "Người liên hệ không bỏ trống",
        maxlength: "Tối đa là 255 kí tự !",
    },
    contact_email: {
        required: "Email liên hệ không bỏ trống",
        maxlength: "Tối đa là 255 kí tự !",
    },
    contact_phone: {
        required: "SĐT liên hệ không bỏ trống",
        maxlength: "Tối đa là 20 kí tự !",
    }
};
$.validator.addMethod(
    "hasSpecial",
    function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        if (/[!@#$%^&*_+\=\[\]{};':"\\|,.<>\/?]+/.test(value)) { //cho phép sử dụng - và ( ) trong tên doanh nghiệp
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
});
