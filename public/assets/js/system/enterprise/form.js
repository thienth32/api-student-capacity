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
    link_web: {
        required: true,
    },
};
const messages = {
    name: {
        required: "Trường không bỏ trống !",
        maxlength: "Tối đa là 255 kí tự !",
    },

    description: {
        required: "Trường mô tả không bỏ trống !",
    },
    link_web: {
        required: "Trường không bỏ trống !",
    },
};
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
});
