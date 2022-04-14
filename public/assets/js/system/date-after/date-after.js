function dateAfter(begin, end) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;
    // $(this.begin).val(getTimeToday);
    // $(this.end).val(getTimeToday);
    $(this.begin).prop("min", function () {
        return getTimeToday;
    });
    $(this.end).prop("min", function () {
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
    });
}
function dateAfterEdit(begin, end) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;
    $(end).prop("min", function () {
        return $(begin).val();
    });
    $(begin).prop("max", function () {
        return $(end).val();
    });
    // $(this.begin).val(getTimeToday);
    // $(this.end).val(getTimeToday);

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
    });
}
