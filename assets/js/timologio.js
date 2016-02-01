/**
 * Created by vagenas on 30/6/2015.
 */
(function ($) {
    $(document).ready(function(){
        var $timologio = $('#billing_timologio');

        function checkTimologioFieldsVisibility() {
            var timologio = $timologio.val() === 'Y';
            if (timologio) {
                $('.timologio-hide').slideDown('fast');
            } else {
                $('.timologio-hide').slideUp('fast');
            }
        }

        $timologio.change(checkTimologioFieldsVisibility);

        checkTimologioFieldsVisibility();
    })
})(jQuery);