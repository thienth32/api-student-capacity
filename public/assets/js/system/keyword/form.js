const elForm = "#formKeyword";
const onkeyup = false;
const rules = {
    keyword: {
        required: true,
        minlength: 4,
    },
    keyword_en: {
        required: true,
        minlength: 4,
    },
    keyword_slug: {
        required: true,
        minlength: 4,
    },
};
const messages = {
    keyword: {
        required: "Trường này không được để trống !",
        minlength: "Tối thiểu là 4 kí tự !",
    },
    keyword_en: {
        required: "Trường này không được để trống !",
        minlength: "Tối thiểu là 4 kí tự !",
    },
    keyword_slug: {
        required: "Trường này không được để trống !",
        minlength: "Tối thiểu là 4 kí tự !",
    },
};