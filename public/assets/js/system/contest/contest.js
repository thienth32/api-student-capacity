const contestPage = {
    selectMajor: function() {
        $("#select-major").on("change", function() {
            if ($(this).val() == 0) return (window.location = url);
            checkUrlOut("major_id", $(this).val());
        });
    },

    selectDateTimeContest: function() {
        $(".select-date-time-contest").on("change", function() {
            // checkUrlOut($(this).val(), $(this).val());
            window.location = url + $(this).val() + "=" + $(this).val();
            return false;
        });
    },

    selectChangeStatus: function() {
        $(".form-select-status").on("change", function() {
            loadTast();
            let id = $(this).data("id");
            if ($(this).val() == 1) {
                $.ajax({
                    url: `admin/contests/un-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        if (!data.status) return alert(data.payload);
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    },
                });
            } else {
                $.ajax({
                    url: `admin/contests/re-status/${id}`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        if (!data.status) return alert(data.payload);
                        loadTast(
                            "Thành công !",
                            "toastr-bottom-left",
                            "success"
                        );
                    },
                });
            }
        });
    },
    topScore: function(top1, top2, top3, leave) {
        disabledInput([top2, top3, leave]);

        function disabledInput(data = [], status = true) {
            return data.forEach(e => {
                $(e).prop('disabled', status);
            });
        }

        function setValue(data = [], val) {
            return data.forEach(e => {
                $(e).val(val);
            });
        }
        $(document).on("keyup change", top1, function(e) {
            e.preventDefault();
            $(top2).prop('disabled', false);
            if ($(this).val() == '') {
                disabledInput([top2, top3, leave]);
                setValue([top2, top3, leave], null);
            }
            return
        });
        $(document).on("keyup change", top2, function(e) {
            e.preventDefault();
            $(top3).prop('disabled', false);
            if ($(this).val() == '') {
                disabledInput([top3, leave]);
                setValue([top2, top3, leave], null);
            }
            if ($(this).val() >= $(top1).val()) {
                $(this).val($(top1).val() - 1);
            }
            return

        });
        $(document).on("keyup change", top3, function(e) {
            var that = this;
            e.preventDefault();
            $(leave).prop('disabled', false);
            if ($(this).val() == '') {
                disabledInput([leave]);
                setValue([leave], null);

            }
            // if ($(this).val() >= $(top2).val()) {
            //     $(this).val($(top2).val() - 1);

            // }
            // return

        });

        $(document).on("keyup change", leave, function(e) {
            // var that = this;
            // if ($(this).val() >= $(top3).val()) {
            //     $(this).val($(top3).val() - 1);

            // }
            // return

        });
    }
};
contestPage.selectMajor();
// contestPage.selectStatus();
contestPage.selectDateTimeContest();
contestPage.selectChangeStatus();