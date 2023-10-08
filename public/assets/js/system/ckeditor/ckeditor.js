const pageCkeditor = {
    classicCk: function () {
        ClassicEditor.create(
            document.querySelector("#kt_docs_ckeditor_classic"),
            {
                alignment: {
                    options: ['left', 'right', 'center', 'justify',]
                },
                toolbar: [
                    "heading",
                    "undo",
                    "redo",
                    "bold",
                    "italic",
                    "blockQuote",
                    "ckfinder",
                    "imageTextAlternative",
                    '|',
                    'alignment',
                    '|',
                    // "imageUpload",
                    // "heading",
                    "imageStyle:full",
                    "imageStyle:side",
                    "link",
                    "numberedList",
                    "bulletedList",
                    "insertTable",
                    "mediaEmbed",
                    "tableColumn",
                    "tableRow",
                    "mergeTableCells",
                ],
            }
        )
            .then((editor) => {
            })
            .catch((error) => {
            });
    },
    classicCk2: function () {
        ClassicEditor.create(
            document.querySelector("#kt_docs_ckeditor_classic2"),
            {
                alignment: {
                    options: ['left', 'right', 'center', 'justify',]
                },
                toolbar: [
                    "heading",
                    "undo",
                    "redo",
                    "bold",
                    "italic",
                    "blockQuote",
                    "ckfinder",
                    "imageTextAlternative",
                    '|',
                    'alignment:left',
                    'alignment:right',
                    'alignment:center',
                    'alignment:justify',
                    '|',
                    // "imageUpload",
                    // "heading",
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
            })
            .catch((error) => {
            });
    },
};
pageCkeditor.classicCk();
pageCkeditor.classicCk2();
