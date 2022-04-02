<script>
    var hostUrl = "assets/";
</script>
<script src="https://kit.fontawesome.com/29b41ee1c8.js" crossorigin="anonymous"></script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
{{-- <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script> --}}
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
{{-- <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
<!-- JavaScript Bundle with Popper -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js">
</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "500",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    $(".kt_daterangepicker").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format("YYYY"), 10),
        locale: {
            format: "DD/MM/YYYY H:mm"
        }
    });
</script>
