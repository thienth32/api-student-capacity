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
        function removeDisabled(val, element, time) {
            $(element).val(val);
            return setTimeout(() => {
                $(element).prop("disabled", false);
            }, time);
        }
        $(".form-select-status").on("change", function() {
            loadTast();
            var that = this;
            $(this).prop("disabled", true);
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
                        removeDisabled(0, that, 3000);
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
                        removeDisabled(1, that, 3000);
                    },
                });
            }
        });
    },
    topScore: function(top1, top2, top3, leave) {
        disabledInput([top2, top3, leave]);

        function disabledInput(data = [], status = true) {
            return data.forEach(e => {
                $(e).attr('readonly', status);
            });
        }

        function removeAttr(data = []) {
            return data.forEach(e => {
                $(e).removeAttr('readonly');
            });
        }

        function setValue(data = [], val) {
            return data.forEach(e => {
                Number($(e).val(val));
            });
        }

        $(document).on("keyup change", top1, function(e) {
            e.preventDefault();
            removeAttr([top2])
            if ($(this).val() == '') {
                disabledInput([top2, top3, leave]);
                setValue([top2, top3, leave], null);
            }
            return
        });

        $(document).on("keyup change", top2, function(e) {
            e.preventDefault();
            removeAttr([top3])
            if ($(this).val() == '') {
                disabledInput([top3, leave]);
                setValue([top3, leave], null);
            }
            if (Number($(this).val()) >= Number($(top1).val())) {
                Number($(this).val($(top1).val() - 1));
            }
            return
        });

        $(document).on("keyup change", top3, function(e) {
            e.preventDefault();
            removeAttr([leave])
            if ($(this).val() == '') {
                disabledInput([leave]);
                setValue([leave], null);
            }
            if (Number($(this).val()) >= Number($(top2).val())) {
                Number($(this).val($(top2).val() - 1));
            }
            return
        });

        $(document).on("keyup change", leave, function(e) {
            if (Number($(this).val()) >= Number($(top3).val())) {
                Number($(this).val($(top3).val() - 1));
            }
            return
        });
    }
};
contestPage.selectMajor();
// contestPage.selectStatus();
contestPage.selectDateTimeContest();
contestPage.selectChangeStatus();