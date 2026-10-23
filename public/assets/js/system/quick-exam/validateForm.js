const elForm = "#myForm";
const onkeyup = true;
const rules = {
    skill: {
        required: true,
    },
    total_easy: {
        required: true,
        number: true,
        min: 0
    },
    total_medium: {
        required: true,
        number: true,
        min: 0
    },
    total_hard: {
        required: true,
        number: true,
        min: 0
    },
};
const messages = {
    skill: {
        required: "Chưa nhập trường này !",
    },
    total_easy: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !",
        min: "Số câu tối thiểu là 0"
    },
    total_medium: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !",
        min: "Số câu tối thiểu là 0"
    },
    total_hard: {
        required: "Chưa nhập trường này !",
        number: "Sai định dạng !",
        min: "Số câu tối thiểu là 0"
    },
};
