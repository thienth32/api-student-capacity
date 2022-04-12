const elForm = "#formAddSlider";
const onkeyup = true;
const rules = {
    link_to: {
        required: true,
    },
    start_time: {
        required: true,
    },
    end_time: {
        required: true,
    },
};
const messages = {
    link_to: {
        required: "Chưa nhập trường này !",
    },

    start_time: {
        required: "Chưa nhập trường này !",
        min: "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !",
        max: "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc !",
    },
    end_time: {
        required: "Chưa nhập trường này !",
        min: "Thời gian kết thúc không được lớn hơn thời gian bắt đầu !",
    },
};

$(".file-change").on("change", function () {
    var file = $(this)[0].files[0];
    if (!file) return;
    let render = new FileReader();
    render.onload = function () {
        $("#previewImg").attr("src", this.result);
    };
    render.readAsDataURL(file);
});
