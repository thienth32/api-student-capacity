function to_slug(str) {
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, "a");
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, "e");
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, "i");
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, "o");
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, "u");
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, "y");
    str = str.replace(/(đ)/g, "d");

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, "");

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, "-");

    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, "");

    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, "");

    // return
    return str;
}
const Page = {
    changeSlug() {
        $(".name-sl").on("input", function () {
            var slug = to_slug($(this).val());
            $(".slug-sl").val(slug);
        });
        $(".slug-sl").on("change", function () {
            var slug = to_slug($(this).val());
            $(this).val(slug);
        });
    },
};
Page.changeSlug();
$(document).ready(function () {
    $(".click-contest").click(function () {
        $(".click-capacity").removeClass("btn-primary");
        $(".click-round").removeClass("btn-primary");
        $(".click-recruitment").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        $("#capacity").hide(100);
        $("#round").hide(100);
        $("#recruitment").hide(100);
        $("#contest").show(300);
    });
    $(".click-capacity").click(function () {
        $(".click-contest").removeClass("btn-primary");
        $(".click-round").removeClass("btn-primary");
        $(".click-recruitment").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        $("#contest").hide(100);
        $("#round").hide(100);
        $("#recruitment").hide(100);
        $("#capacity").show(300);
    });
    $(".click-round").click(function () {
        $(".click-contest").removeClass("btn-primary");
        $(".click-recruitment").removeClass("btn-primary");
        $(".click-capacity").removeClass("btn-primary");
        $("#capacity").hide(100);
        $("#contest").hide(100);
        $("#recruitment").hide(100);
        $(this).addClass("btn-primary");
        $("#round").toggle(300);
    });
    $(".click-recruitment").click(function () {
        $(".click-contest").removeClass("btn-primary");
        $(".click-round").removeClass("btn-primary");
        $(".click-capacity").removeClass("btn-primary");
        $("#capacity").hide(100);
        $("#contest").hide(100);
        $("#round").hide(100);
        $(this).addClass("btn-primary");
        $("#recruitment").toggle(300);
    });
});

const pageSliderForm = {
    selectRoundChildContest: function () {
        $("#select-contest-p").on("change", function () {
            let id = $(this).val();
            let html = `<option value="0">Chọn vòng thi</option>`;
            html =
                html +
                rounds.map(function (data) {
                    if (id == data.contest_id) {
                        return ` <option ${
                            oldRound == data.id ? "selected" : ""
                        } value="${data.id}">${data.name} </option>`;
                    }
                    return "";
                });
            $("#select-round").html(html);
        });
    },
};
pageSliderForm.selectRoundChildContest();
