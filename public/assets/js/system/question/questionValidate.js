const elForm = "#formQuestion";
const onkeyup = true;
const rules = {
    content: {
        // required: function() {
        //     CKEDITOR.instances.content.updateElement();
        // },
        required: true,
    },
    'answers[*][content]': {
        required: true,
    },
    'skill[]': {
        required: true,
    }
};
const messages = {
    'answers[*][content]': {
        required: "Chưa nhập trường này !",
    },
    content: {
        required: "Chưa nhập trường này !",
    },
    'skill[]': {
        required: "Chưa nhập trường này !",
    },
};