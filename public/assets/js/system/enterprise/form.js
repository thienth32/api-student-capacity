const elForm = "#formAddEnterprise";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    description: {
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
};

$(document).ready(function () {
    $("input[name=name]").change(function (e) {
        e.preventDefault();
        $('#checkname').css('display','none')
    });
});
