const roundPage = {
    selectContest: function () {
        $("#select-contest").on("change", function () {
            if ($(this).val() == 0) return (window.location = url);
            checkUrlOut("contest_id", $(this).val());
        });
    },
    selectTypeExam: function () {
        $("#select-type-exam").on("change", function () {
            if ($(this).val() == 0) return (window.location = url);
            checkUrlOut("type_exam_id", $(this).val());
        });
    },
    // selectDateSearch: function () {
    //     $(".select-date-serach").on("change", function () {
    //         loadTast();
    //         const value = $(this).val();
    //         switch (value) {
    //             case "add-day-7":
    //                 window.location = url + "&day=" + 7 + "&op_time=add";
    //                 return false;
    //             case "add-day-15":
    //                 window.location = url + "&day=" + 15 + "&op_time=add";
    //                 return false;
    //             case "add-month-1":
    //                 window.location = url + "&month=" + 1 + "&op_time=add";
    //                 return false;
    //             case "add-month-6":
    //                 window.location = url + "&month=" + 6 + "&op_time=add";
    //                 return false;
    //             case "add-year-1":
    //                 window.location = url + "&year=" + 1 + "&op_time=add";
    //                 return false;
    //             case "sub-day-7":
    //                 window.location = url + "&day=" + 7 + "&op_time=sub";
    //                 return false;
    //             case "sub-day-15":
    //                 window.location = url + "&day=" + 15 + "&op_time=sub";
    //                 return false;
    //             case "sub-month-1":
    //                 window.location = url + "&month=" + 1 + "&op_time=sub";
    //                 return false;
    //             case "sub-month-6":
    //                 window.location = url + "&month=" + 6 + "&op_time=sub";
    //                 return false;
    //             case "sub-year-1":
    //                 window.location = url + "&year=" + 1 + "&op_time=sub";
    //                 return false;
    //             default:
    //                 break;
    //         }
    //     });
    // },
};
roundPage.selectContest();
roundPage.selectTypeExam();
// roundPage.selectDateSearch();
