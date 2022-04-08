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
    start_time: {
        required: "Chưa nhập trường này !",
        date: true,
    },
    end_time: {
        required: "Chưa nhập trường này !",
        date: true,
    },
    description: {
        required: "Chưa nhập trường này !",
    },
};
