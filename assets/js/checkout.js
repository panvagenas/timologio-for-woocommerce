/**
 * Created by vagenas on 30/6/2015.
 */
(function ($) {
    var $timologio = $('#timologio');

    function checkTimologioFieldsVisibility() {
        var timologio = $timologio.val() === '1';
        if (timologio) {
            $('.timologio-hide').slideDown('fast');
        } else {
            $('.timologio-hide').slideUp('fast');
        }
    }

    $timologio.change(checkTimologioFieldsVisibility);

    checkTimologioFieldsVisibility();

})(jQuery);