$('#kt_docs_repeater_basic').repeater({
    initEmpty: false,

    defaultValues: {
        'text-input': 'foo'
    },

    show: function() {
        $(this).slideDown();
    },

    hide: function(deleteElement) {
        $(this).slideUp(deleteElement);
    }
});