const elForm = "#formTeam";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    contest_id: {
        required: true,
    }
};
const messages = {
    name: {
        required: "Chưa nhập trường này !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    contest_id: {
        required: "Chưa nhập trường này !",
    },
};