$('select[name="contest_id"]').on('change', function() {
    let id = $(this).val();
    if (id == '') {
        $("#member").hide();
        return;
    } else {
        $('#member').show();
        $(".parent-loading #loading").css("display", "block");
        $.ajax({
            type: "post",
            url: urlShowContest,
            data: {
                id: id
            },
            success: function(response) {
                max_user = response.payload;
                $('#mesArrayUser').text('Giới hạn chỉ được ' + max_user + ' thành viên !!')
                userArray = []
                teamPage.userArray(userArray);
                id_contest = id
                setTimeout(() => {
                    $(".parent-loading #loading").css("display", "none");
                }, 1000);
            }
        });
    }
});