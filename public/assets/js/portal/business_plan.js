"use strict";

var KTBusinessPlan = function () {
    // Private functions
    var initRepeater = function () {
        $('.repeater-init').each(function () {
            $(this).repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    $(this).slideDown();

                    // Re-init Select2 if inside repeater
                    $(this).find('[data-control="select2"]').select2();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        });
    }

    return {
        // Public functions
        init: function () {
            initRepeater();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTBusinessPlan.init();
});
