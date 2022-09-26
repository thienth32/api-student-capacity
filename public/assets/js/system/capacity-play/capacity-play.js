const capacity_play = {
    copytext: function () {
        $(document).on("click", "button.copy_to", function (e) {
            e.preventDefault();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).text()).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success("Copied!");
        });
    },
};

capacity_play.copytext();
