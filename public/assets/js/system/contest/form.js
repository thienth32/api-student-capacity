const elForm = "#formContest";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    date_start: {
        required: true,
    },
    register_deadline: {
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

    register_deadline: {
        required: "Chưa nhập trường này !",
        min: "Thời gian kết thúc không được lớn hơn thời gian bắt đầu !",
    },
    date_start: {
        required: "Chưa nhập trường này !",
        min: "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !",
        max: "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc !",
    }
};