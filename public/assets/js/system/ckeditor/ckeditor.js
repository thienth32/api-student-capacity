const pageCkeditor = {
    classicCk: function () {
        ClassicEditor.create(
            document.querySelector("#kt_docs_ckeditor_classic"),
            {
                toolbar: [
                    "heading",
                    "undo",
                    "redo",
                    "bold",
                    "italic",
                    "blockQuote",
                    "ckfinder",
                    "imageTextAlternative",
                    "imageUpload",
                    "heading",
                    "imageStyle:full",
                    "imageStyle:side",
                    "link",
                    "numberedList",
                    "bulletedList",
                    "mediaEmbed",
                    "insertTable",
                    "tableColumn",
                    "tableRow",
                    "mergeTableCells",
                ],
            }
        )
            .then((editor) => {
                console.log(editor);
            })
            .catch((error) => {
                console.error("Bug", error);
            });
    },
};
pageCkeditor.classicCk();
