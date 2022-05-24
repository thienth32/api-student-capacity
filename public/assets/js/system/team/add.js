$('select[name="contest_id"]').on('change', function() {
    let id = $(this).val();

    if (id == '') {
        $("#member").css("display", "none");
        return;
    } else {
        $.ajax({
            type: "post",
            url: urlShowContest,
            data: {
                id: id
            },
            success: function(response) {
                $("#member").css("display", "block");
                max_user = response.payload;
                $('#mesArrayUser').text('Giới hạn chỉ được ' + max_user + ' thành viên !!')
                userArray = []
                teamPage.userArray(userArray);
            }
        });
    }
});