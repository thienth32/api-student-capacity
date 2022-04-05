const roundPage = {
    selectContest: function () {
        $("#select-contest").on("change", function () {
            checkUrlOut("contest_id", $(this).val());
        });
    },
    selectTypeExam: function () {
        $("#select-type-exam").on("change", function () {
            checkUrlOut("type_exam_id", $(this).val());
        });
    },
    selectDateSearch: function () {
        $(".select-date-serach").on("change", function () {
            loadTast();
            const value = $(this).val();
            switch (value) {
                case "day-7":
                    window.location = url + "&day=" + 7;
                    return false;
                case "day-15":
                    window.location = url + "&day=" + 15;
                    return false;
                case "month-1":
                    window.location = url + "&month=" + 1;
                    return false;
                case "month-6":
                    window.location = url + "&month=" + 6;
                    return false;
                case "year-1":
                    window.location = url + "&year=" + 1;
                    return false;
                default:
                    break;
            }
        });
    },
};
roundPage.selectContest();
roundPage.selectTypeExam();
roundPage.selectDateSearch();
