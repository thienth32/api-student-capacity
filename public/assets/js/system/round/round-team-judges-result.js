$(document).ready(function () {
    // alert($("input[name=ponit]").val())
    $("input[name=final_point]").keyup(function () {
        $("input[name=final_point]").mouseleave(function () {
            $("textarea[name=reason]").show(100);
            if (
                parseFloat($("input[name=final_point]").val()) >=
                parseFloat($("input[name=ponit]").val())
            ) {
                $("#select-round").show(100);
            } else {
                $("#select-round").hide(100);
            }
        });
    });
    // $('#select-round').hide();
    if (
        parseFloat($("input[name=final_point]").val()) >=
        parseFloat($("input[name=ponit]").val())
    ) {
        $("#select-round").show(100);
    } else {
        $("#select-round").hide(100);
    }
});
$(document).ready(function () {
    $(".click-admin").click(function () {
        $(".click-judges").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        $("#judges").hide(100)
        $("#admin").show(300);
    });
    $(".click-judges").click(function () {
        $(".click-admin").removeClass("btn-primary");
        $("#admin").hide(100);
        $(this).addClass("btn-primary");
        $("#judges").toggle(300);
    });
});


function notification() {
    let choice = confirm("Điểm đã xác nhận. bạn có muốn thay đổi không!");
    if (choice == true) {
        return $("form").submit();
    } else {
        return false;
    }
}
