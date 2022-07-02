function dateAfterEdit(begin) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;

    $(this.begin).on("keyup change", function () {
        let val = $(this).val();
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
