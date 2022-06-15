$(elForm).validate({

    onkeyup: onkeyup,
    rules: rules,
    messages: messages,
});

$("input[type=datetime-local]").on("change", function() {
    if (moment($(this).val()).format("YYYY") == "Invalid date") {
        alert("Nhập sai định dạng thời gian !");
        $(this).val(moment().format("DD/MM/YYYY hh:mm:ss A"));
    }
});
$('textarea').val($('textarea').val().trim());