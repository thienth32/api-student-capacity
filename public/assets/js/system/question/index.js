const question = {

    selectAnswer: function() {
        function checkSelected(ele = "select.answer-select option") {
            const val = $(ele).filter(":selected").val();
            element = document.querySelectorAll('input.is_correct');
            if (val == 1) {
                for (const item of element) {
                    $(item).attr('type', 'checkbox');
                }
                return;
            } else {
                for (const item of element) {
                    $(item).attr('type', 'radio');
                }
                return;
            }
        }
        checkSelected("select.answer-select option");
        $(document).on('change', 'select.answer-select', function(e) {
            e.preventDefault();
            var key = 0;
            let val = $(this).val();
            element = document.querySelectorAll('input.is_correct');
            if (val == 1) {
                for (const item of element) {
                    $(item).prop('checked', false);
                    $(item).attr('type', 'checkbox');
                    if ((key++) % 2 == 0) {
                        $(item).prop('checked', true);
                    }

                }
                return;
            } else {
                for (const item of element) {
                    $(item).prop('checked', false);
                    $(item).attr('type', 'radio');
                    if ((key++) == 2) {
                        $(item).prop('checked', true);
                    }
                }
                return;
            }

        });
    },
    inputCheckedRadioClick: function() {
        $(document).on('change', 'input.is_correct[type="radio"]', function(e) {
            e.preventDefault();
            element = document.querySelectorAll('input.is_correct[type="radio"]');
            for (const item of element) {
                $(item).prop('checked', false);
            }
            return $(this).prop('checked', true);
        });

    },

    selectSkillList: function(element = '#selectSkill') {
        $(element).change(function() {
            let idContest = $(this).val();
            if (idContest == 0) {
                window.location = url;
                return;
            }
            checkUrlOut('skill', idContest)
        })
    },
    selectLevelList: function(element = '#select-level') {
        $(element).change(function() {
            let val = $(this).val();
            if (val == 3) {
                window.location = url;
                return;
            }
            checkUrlOut('level', val)
        })
    },
    selectTypeList: function(element = '#select-type') {
        $(element).change(function() {
            let val = $(this).val();
            if (val == 3) {
                window.location = url;
                return;
            }
            checkUrlOut('type', val)
        })
    }


}