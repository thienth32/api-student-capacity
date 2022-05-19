tinymce.init({
    selector: "#kt_docs_tinymce_hidden",
    menubar: false,
    toolbar: [
        "styleselect fontselect fontsizeselect",
        "undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify",
        "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code",
    ],
    plugins: "advlist autolink link image lists charmap print preview code",
});
// Stepper lement
var element = document.querySelector("#kt_stepper_example_basic");

// Initialize Stepper
var stepper = new KTStepper(element);

// Handle next step
stepper.on("kt.stepper.next", function (stepper) {
    stepper.goNext(); // go next step
});

// Handle previous step
stepper.on("kt.stepper.previous", function (stepper) {
    stepper.goPrevious(); // go previous step
});
