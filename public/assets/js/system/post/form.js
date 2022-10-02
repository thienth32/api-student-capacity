const elForm = "#formPost";
const onkeyup = true;
const rules = {
    title: {
        required: true,
        maxlength: 255,
        hasSpecial: true,
    },
    link_to: { required: true },
    slug: {
        required: true,
        maxlength: 255,
    },
    published_at: {
        required: true,
    },
    recruitment_id: "multipeFieldValidator",

    contest_id: "multipeFieldValidator",
    round_id: "multipeFieldValidator",
    capacity_id: "multipeFieldValidator",
};

const messages = {
    title: {
        required: "Chưa nhập trường này ! !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    slug: {
        required: "Chưa nhập trường này ! !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    link_to: {
        required: "Chưa nhập trường này ! !",
    },
    description: {
        required: "Chưa nhập trường này !!",
    },
    published_at: {
        required: "Chưa nhập trường này !!",
        min: "Không được nhỏ hơn thời gian hiện tại !",
    },
};

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
//     "Không được nhỏ hơn thời gian hiện tại !."
// );

$.validator.addMethod(
    "multipeFieldValidator",
    function (value) {
        var returnVal = false;
        if (
            $("select[name=contest_id").val() == 0 &&
            $("select[name=capacity_id").val() == 0 &&
            $("select[name=round_id").val() == 0 &&
            $("select[name=recruitment_id").val() == 0
        ) {
            returnVal = false;
        } else if (
            $("select[name=round_id").val() != 0 ||
            $("select[name=capacity_id").val() != 0 ||
            $("select[name=contest_id").val() != 0 ||
            $("select[name=recruitment_id").val() != 0
        ) {
            returnVal = true;
        }
        // else if (
        //     $("select[name=recruitment_id").val() != 0 &&
        //     $("select[name=capacity_id").val() == 0 &&
        //     $("select[name=contest_id").val() == 0 &&
        //     $("select[name=round_id").val() == 0
        // ) {
        //     returnVal = true;
        // } else if (
        //     $("select[name=capacity_id").val() != 0 &&
        //     $("select[name=contest_id").val() == 0 &&
        //     $("select[name=recruitment_id").val() == 0 &&
        //     $("select[name=round_id").val() == 0
        // ) {
        //     returnVal = true;
        // }

        return returnVal;
    },
    "Yêu cầu chọn một thành phần !"
);
$(document).ready(function () {
    $("select[name=contest_id]").change(function () {
        $(this).valid();
        if ($(this).val() != 0) {
            $("select[name=round_id] ")
                .val($("select[name=round_id] option:first").val())
                .change();
            $("select[name=recruitment_id]")
                .val($("select[name=recruitment_id] option:first").val())
                .change();
            $("select[name=capacity_id]")
                .val($("select[name=capacity_id] option:first").val())
                .change();
        }
    });

    $("select[name=round_id]").change(function () {
        $(this).valid();
        if ($(this).val() != 0) {
            $("select[name=contest_id]")
                .val($("select[name=contest_id] option:first").val())
                .change();
            $("select[name=recruitment_id]")
                .val($("select[name=recruitment_id] option:first").val())
                .change();
            $("select[name=capacity_id]")
                .val($("select[name=capacity_id] option:first").val())
                .change();
        }
    });

    $("select[name=recruitment_id]").change(function () {
        $(this).valid();
        if ($(this).val() != 0) {
            $("select[name=contest_id]")
                .val($("select[name=contest_id] option:first").val())
                .change();
            $("select[name=round_id]")
                .val($("select[name=round_id] option:first").val())
                .change();
            $("select[name=capacity_id]")
                .val($("select[name=capacity_id] option:first").val())
                .change();
        }
    });
    $("select[name=capacity_id]").change(function () {
        $(this).valid();
        if ($(this).val() != 0) {
            $("select[name=contest_id]")
                .val($("select[name=contest_id] option:first").val())
                .change();
            $("select[name=round]")
                .val($("select[name=contest_id] option:first").val())
                .change();
            $("select[name=recruitment_id]")
                .val($("select[name=recruitment_id] option:first").val())
                .change();
        }
    });
});

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
    $("input[name=title]").change(function (e) {
        e.preventDefault();
        $("#checkname").css("display", "none");
    });
    $("input[name=slug]").change(function (e) {
        e.preventDefault();
        $("#checkslug").css("display", "none");
    });
});
