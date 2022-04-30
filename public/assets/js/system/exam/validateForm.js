const elForm = "#myForm";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    description: {
        required: true,
        maxlength: 255,
    },
    max_ponit: {
        required: true,
        number: true
    },
    ponit: {
        required: true,
        number: true
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
    max_ponit: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !"
    },
    ponit: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !"

    },

};