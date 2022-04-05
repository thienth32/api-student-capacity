const elForm = "#formAddContest";
const onkeyup = false;
const rules = {
    name: {
        required: true,
        minlength: 4,
    },
    slug: {
        required: true,
    },
};
const messages = {
    name: {
        required: "Chưa nhập trường này !",
        minlength: "Tối thiểu là 4 kí tự !",
    },
    slug: {
        required: "Chưa nhập trường này !",
    },
};
