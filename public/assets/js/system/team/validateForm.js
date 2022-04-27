const elForm = "#formTeam";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
};
const messages = {
    name: {
        required: "Chưa nhập trường này !",
        maxlength: "Tối đa là 255 kí tự !",
    },
};