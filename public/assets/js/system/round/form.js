const elForm = "#formAddRound";
const onkeyup = true;
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
        required: "Chưa nhập trường này !",
        maxlength: "Tối đa là 255 kí tự !",
    },

    description: {
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
    }
};