const elForm = "#formSkill";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    description: {
        required: true,
        maxlength: 20,
    },
    short_name: {
        required: true,
        hasUppercase:true
    },
};
const messages = {
    name: {
        required: "Chưa nhập trường này ! !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    short_name: {
        required: "Chưa nhập trường này !",
        maxlength: "Tối đa là 20 kí tự !",
    },
    description: {
        required: "Chưa nhập trường này !!",
    },
};
$.validator.addMethod(
    "hasUppercase",
    function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        return  /^[A-Z]*$/.test(value);
    },
    "Trường yêu cầu viết hoa không dấu!!!"
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
