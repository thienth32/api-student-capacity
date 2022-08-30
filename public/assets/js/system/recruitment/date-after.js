function dateAfterEdit(begin, end) {
    // let getTimeToday;
    let that = this;

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
    });
}

///////////////////////////////////////

function dateAfter(begin, end) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;
    $(this.begin).attr("min", function () {
        return getTimeToday;
    });
    $(this.end).attr("min", function () {
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
    });
}

// $.validator.addMethod(
//     "checkBeginNull",
//     function (value) {
//         let begin = $("input[type=datetime-local]#begin").val();
//         if (begin != "" && begin.indexOf(" ") != 0) {
//             return true;
//         } else {
//             return false;
//         }
//         // console.log(value);
//     },
//     "Vui lòng nhập thời gian bắt đầu cuộc thi!!"
// );

// $.validator.addMethod(
//     "beginLessEnd",
//     function (begin) {
//         let end = $("input[type=datetime-local]#end").val();
//         // if (end != '' && end.indexOf(' ') != 0) return true;
//         const getBegin = new Date(begin).getTime();
//         const getEnd = new Date(end).getTime();

//         if (getBegin > getEnd) {
//             return false;
//         }
//         return true;
//     },
//     "Ngày bắt đầu phải nhỏ hơn ngày kết thúc !!"
// );

// $.validator.addMethod(
//     "startTimeCheckBegin",
//     function (value) {
//         let begin = $("input[type=datetime-local]#begin").val();
//         if (begin != "" && begin.indexOf(" ") != 0) {
//             return true;
//         } else {
//             return false;
//         }
//         // console.log(value);
//     },
//     "Vui lòng nhập thời gian bắt đầu cuộc thi !!"
// );

// $.validator.addMethod(
//     "startTimeCheckEnd",
//     function (value) {
//         let end = $("input[type=datetime-local]#end").val();
//         if (end != "" && end.indexOf(" ") != 0) {
//             return true;
//         } else {
//             return false;
//         }
//         // console.log(value);
//     },
//     "Vui lòng nhập thời gian kết thúc cuộc thi !!"
// );
