const judges_contest = {
    submitForm: function() {


        $(document).on('click', '#attachJudges', function(e) {
            e.preventDefault();
            var values = $("input[name='user_id[]'].user_id")
                .map(function() { return $(this).val(); }).get();
            if (values.length == 0) {
                toastr.warning('Chưa có giám khảo trong danh sách chờ !!')
                return;
            } else {
                toastr.info('Đang chạy !!')
                $.ajax({
                    type: "post",
                    url: URL_ATTACH,
                    data: {
                        user_id: values
                    },
                    success: function(response) {
                        if (response.status == true) {
                            toastr.success(response.payload);
                            window.location.href = URL
                            return;
                        } else {
                            toastr.error(response.payload);
                            window.location.href = URL
                            return;
                        }
                    }

                });

            }


        });
        $(document).on('click', '.deleteJudges', function(e) {
            e.preventDefault();
            var user_id = $(this).attr('data-id_user');
            toastr.info('Đang chạy !!')
            $.ajax({
                type: "delete",
                url: URL_DETACH,
                data: {
                    user_id: user_id
                },
                success: function(response) {
                    if (response.status == true) {
                        toastr.success(response.payload);
                        window.location.href = URL
                        return;
                    } else {
                        toastr.error(response.payload);
                        window.location.href = URL
                        return;
                    }
                }
            });
        });
    }
}

judges_contest.submitForm()