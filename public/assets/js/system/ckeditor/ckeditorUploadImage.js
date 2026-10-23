import {
	ClassicEditor,
	Alignment,
	AutoImage,
	BlockQuote,
	Bold,
	Essentials,
	GeneralHtmlSupport,
	Heading,
	ImageBlock,
	ImageCaption,
	ImageInline,
	ImageInsert,
	ImageInsertViaUrl,
	ImageResize,
	ImageStyle,
	ImageTextAlternative,
	ImageToolbar,
	ImageUpload,
	Indent,
	IndentBlock,
	Italic,
	Link,
	LinkImage,
	List,
	ListProperties,
	MediaEmbed,
	Paragraph,
	PasteFromOffice,
	SimpleUploadAdapter,
	Table,
	TableCaption,
	TableCellProperties,
	TableColumnResize,
	TableProperties,
	TableToolbar,
	TextTransformation,
	TodoList,
	Underline
} from './ckeditor5.js';

const editorConfig = {
    toolbar: {
        alignment: {
            options: ['left', 'right', 'center', 'justify',]
        },
        items: [
            'heading',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'alignment',
            '|',
            'link',
            'insertImage',
            'mediaEmbed',
            'insertTable',
            'blockQuote',
            '|',
            'bulletedList',
            'numberedList',
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        AutoImage,
        Alignment,
        BlockQuote,
        Bold,
        Essentials,
        Heading,
        ImageBlock,
        ImageCaption,
        ImageInline,
        ImageInsert,
        ImageInsertViaUrl,
        ImageResize,
        ImageStyle,
        ImageTextAlternative,
        ImageToolbar,
        ImageUpload,
        Indent,
        IndentBlock,
        Italic,
        Link,
        LinkImage,
        List,
        ListProperties,
        MediaEmbed,
        Paragraph,
        PasteFromOffice,
        SimpleUploadAdapter,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TodoList,
        Underline
    ],
    heading: {
        options: [
            {
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
        ]
    },
    image: {
        toolbar: [
            'toggleImageCaption',
            'imageTextAlternative',
            '|',
            'imageStyle:inline',
            'imageStyle:wrapText',
            'imageStyle:breakText',
            '|',
            'resizeImage'
        ]
    },
    licenseKey: 'GPL',
    simpleUpload: {
        // uploadUrl: "{{ route('admin.ckeditor.upfile')"
        uploadUrl: "/admin/upload-image",
        withCredentials: true,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
    }
};

ClassicEditor
    .create( document.querySelector('#kt_docs_ckeditor_classic'), editorConfig)
    .catch( error => {
        console.error( error );
    } );

ClassicEditor
    .create( document.querySelector('#kt_docs_ckeditor_classic2'), editorConfig)
    .catch( error => {
        console.error( error );
    } );
