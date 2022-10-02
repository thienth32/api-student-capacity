const exam = {
    download_file: function () {
        $(document).on("click", "button.download_file", function (e) {
            e.preventDefault();
            let external_url = $(this).attr("data-external_url");
            Swal.fire({
                title: "Bạn có chắc muốn tải tệp xuống ?",
                // text: "You won't be able to revert this!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Vâng , tôi đồng ý !",
                cancelButtonText: "Tôi không muốn nữa !",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = external_url;
                    toastr.success(response.payload);
                }
            });
        });
    },
    edit_exam: function () {
        function getTimeStamp() {
            var now = new Date();
            return (
                now.getFullYear() +
                1 +
                "-" +
                (now.getMonth() < 10 ? "0" + now.getMonth() : now.getMonth()) +
                "-" +
                (now.getDate() < 10 ? "0" + now.getDate() : now.getDate()) +
                " " +
                now.getHours() +
                ":" +
                (now.getMinutes() < 10
                    ? "0" + now.getMinutes()
                    : now.getMinutes()) +
                ":" +
                (now.getSeconds() < 10
                    ? "0" + now.getSeconds()
                    : now.getSeconds())
            );
        }
        $(document).on("click", "button.edit_exam", function (e) {
            e.preventDefault();
            let href = $(this).attr("data-href");
            // let date_time = $(this).attr('data-date_time');
            const date_time = new Date(
                $(this).attr("data-date_time")
            ).getTime();
            // const datetimeToday = getTimeStamp();
            const today = new Date().getTime();
            console.log(today);
            console.log(date_time);

            // console.log('Ngày bắt hiện tại ' + datetimeToday);
            // console.log('Ngày bắt đầu thi  ' + date_time);
            if (today > date_time) {
                Swal.fire({
                    title: "Thời gian thi đã bắt đầu không thể chỉnh sửa đề thi !!",
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok !!",
                    customClass: {
                        confirmButton: "btn btn-warning ",
                    },
                });
            } else {
                window.location.href = href;
            }
        });
    },

    selectChangeStatus: function () {
        $(".form-select-status").on("change", function () {
            toastr.info('Đang chạy')
            let id = $(this).data("id");
            var that = this;
            if ($(this).val() == 1) {
                $.ajax({
                    url: `${url}/${id}/un-status`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                        if(flagReLoad) window.location.reload();
                        $(that).val(0);
                        toastr.success('Thành công !');
                    },
                    error: function (request, status, error) {
                        toastr.info('Không thành công !');
                    },
                });
            } else {
                $.ajax({
                    url: `${url}/${id}/re-status`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                        if(flagReLoad) window.location.reload();
                        $(that).val(1);
                        toastr.success('Thành công !');
                    },
                    error: function (request, status, error) {
                        toastr.info('Không thành công !');
                    },
                });
            }
        });
    },
};

exam.download_file();
exam.edit_exam();
exam.selectChangeStatus();
