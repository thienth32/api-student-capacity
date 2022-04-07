const contestPage = {
    selectMajor: function () {
        $("#select-major").on("change", function () {
            if ($(this).val() == 0) return (window.location = url);
            checkUrlOut("major_id", $(this).val());
        });
    },
    selectStatus: function () {
        $("#select-status").on("change", function () {
            if ($(this).val() == 0) return (window.location = url);
            checkUrlOut("status", $(this).val());
        });
    },
    selectDateTimeContest: function () {
        $(".select-date-time-contest").on("change", function () {
            loadTast();
            window.location = url + $(this).val() + "=" + $(this).val();
            return false;
        });
    },

    selectChangeStatus: function () {
        $(".form-select-status").on("change", function () {
            let id = $(this).data("id");
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/contests/un-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                    },
                });
            } else {
                $.ajax({
                    url: `admin/contests/re-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                    },
                });
            }
        });
    },
};
contestPage.selectMajor();
contestPage.selectStatus();
contestPage.selectDateTimeContest();
contestPage.selectChangeStatus();
