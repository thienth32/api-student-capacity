// function dateAfter(begin, end, start_time, end_time) {
//     let getTimeToday = new Date().toJSON().slice(0, 19);
//     let that = this;
//     $(this.begin).prop("min", function() {
//         return getTimeToday;
//     });
//     $(this.end).prop("min", function() {
//         return getTimeToday;
//     });
//     $(this.start_time).prop("min", function() {
//         return getTimeToday;
//     });
//     $(this.end_time).prop("min", function() {
//         return getTimeToday;
//     });
//     $(this.begin).on("keyup change", function() {
//         let val = $(this).val();
//         $(that.end).prop("min", function() {
//             return val;
//         });
//     });
//     $(this.end).on("keyup change", function() {
//         let val = $(this).val();
//         $(that.begin).prop("max", function() {
//             return val;
//         });
//         $(that.start_time).prop("max", function() {
//             return val;
//         });
//         $(that.end_time).prop("max", function() {
//             return val;
//         });
//     });
//     $(this.start_time).on("keyup change", function() {
//         let val = $(this).val();
//         $(that.end_time).prop("min", function() {
//             return val;
//         });
//     });
//     $(this.end_time).on("keyup change", function() {
//         let val = $(this).val();
//         $(that.start_time).prop("max", function() {
//             return val;
//         });
//     });
// }
$("input").on("keyup", function () {
    $(".text-danger").hide();
});

function dateAfterEdit(begin, end, start_time = null, end_time = null) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;
    $(this.end_time).prop("min", function () {
        return getTimeToday;
    });
    $(this.begin).on("keyup change", function () {
        let val = $(this).val();
        $(that.end).prop("min", function () {
            return val;
        });
    });
    $(this.end).on("keyup change", function () {
        let val = $(this).val();
        $(that.begin).prop("max", function () {
            return val;
        });
        if (start_time && end_time) {
            $(that.start_time).prop("max", function () {
                return val;
            });
            $(that.end_time).prop("max", function () {
                return val;
            });
        }
    });
    $(this.start_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.end_time).prop("min", function () {
            return val;
        });
    });
    $(this.end_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.start_time).prop("max", function () {
            return val;
        });
    });
}

///////////////////////////////////////

function dateAfter(begin, end, start_time, end_time) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;
    $(this.begin).attr("min", function () {
        return getTimeToday;
    });
    $(this.end).attr("min", function () {
        return getTimeToday;
    });
    $(this.start_time).attr("min", function () {
        return getTimeToday;
    });
    $(this.end_time).attr("min", function () {
        return getTimeToday;
    });
    $(this.begin).on("keyup change", function () {
        let val = $(this).val();
        $(that.end).attr("min", function () {
            return val;
        });
    });
    $(this.end).on("keyup change", function () {
        let val = $(this).val();
        $(that.begin).attr("max", function () {
            return val;
        });
        $(that.start_time).attr("max", function () {
            return val;
        });
        $(that.end_time).attr("max", function () {
            return val;
        });
    });
    $(this.start_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.end_time).attr("min", function () {
            return val;
        });
    });
    $(this.end_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.start_time).attr("max", function () {
            return val;
        });
    });
}

$.validator.addMethod(
    "checkBeginNull",
    function (value) {
        let begin = $("input[type=datetime-local]#begin").val();
        if (begin != "" && begin.indexOf(" ") != 0) {
            return true;
        } else {
            return false;
        }
        // console.log(value);
    },
    "Vui lòng nhập thời gian bắt đầu cuộc thi!!"
);

$.validator.addMethod(
    "beginLessEnd",
    function (begin) {
        let end = $("input[type=datetime-local]#end").val();
        // if (end != '' && end.indexOf(' ') != 0) return true;
        const getBegin = new Date(begin).getTime();
        const getEnd = new Date(end).getTime();

        if (getBegin > getEnd) {
            return false;
        }
        return true;
    },
    "Ngày bắt đầu phải nhỏ hơn ngày kết thúc !!"
);

$.validator.addMethod(
    "startTimeCheckBegin",
    function (value) {
        let begin = $("input[type=datetime-local]#begin").val();
        if (begin != "" && begin.indexOf(" ") != 0) {
            return true;
        } else {
            return false;
        }
        // console.log(value);
    },
    "Vui lòng nhập thời gian bắt đầu cuộc thi !!"
);

$.validator.addMethod(
    "startTimeCheckEnd",
    function (value) {
        let end = $("input[type=datetime-local]#end").val();
        if (end != "" && end.indexOf(" ") != 0) {
            return true;
        } else {
            return false;
        }
        // console.log(value);
    },
    "Vui lòng nhập thời gian kết thúc cuộc thi !!"
);

$.validator.addMethod(
    "startTimeCheckLessEnd",
    function (value) {
        let end = $("input[type=datetime-local]#end").val();
        const value1 = new Date(value).getTime();
        const getEnd = new Date(end).getTime();

        if (value1 > getEnd) {
            return false;
        }
        return true;
        // console.log(value1);
        // console.log(getEnd);
    },
    "Thời gian đăng kí thi phải nhỏ hơn thời gian kết thúc cuộc thi !!"
);
