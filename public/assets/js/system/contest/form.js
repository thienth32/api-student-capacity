const elForm = "#formAddContest";
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
    date_start: {
        required: "Chưa nhập trường này !",
        date: true,
    },
    register_deadline: {
        required: "Chưa nhập trường này !",
        date: true,
    },
    description: {
        required: "Chưa nhập trường này !",
    },
};
