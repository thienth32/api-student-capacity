const elForm = "#formTeam";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    image: {
        required: true,
    },

};
const messages = {
    name: {
        required: "Chưa nhập trường này !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    image: {
        required: "Chưa nhập trường này !",
    },

};