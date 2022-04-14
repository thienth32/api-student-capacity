const elForm = "#formAddRound";
const onkeyup = false;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    start_time: {
        required: true,
    },
    end_time: {
        required: true,
    },
    description: {
        required: true,
    },
};
const messages = {
    name: {
        required: "Trường name không bỏ trống !",
        maxlength: "Tối đa là 255 kí tự !",
    },

    description: {
        required: "Trường mô tả không bỏ trống !",
    },
    start_time: {
        required: "Chưa nhập trường này !",
        min: "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !",
        max: "Trường thời gian bắt đầu không lớn hơn trường kết thúc  !",
    },
    end_time: {
        required: "Chưa nhập trường này !",
        min: "Trường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
    },
};
