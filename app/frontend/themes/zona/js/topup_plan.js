
document.addEventListener('DOMContentLoaded', function (evtContentLoaded) {
    (function ($) {
        $('.pym-label').click(function (e) {
            $('.pym-box').removeClass('white');
            $(this).parent().addClass('white');
        });
        $("#tabs-panduan").tabs();
        $('#frmTopUpPlan').submit(function (evt) {
            var metode = $('input[type=radio]:checked').length;
            if(metode<1){
                swal('Gagal','Silakan pilih metode pembayaran','error');
            }
            if (!$(this).valid() || metode < 1) {
                evt.preventDefault();
            }
            
        });
        $('#submitTopUpPlan').click(function (event) {
            if ($('#frmTopUpPlan').valid()) {
                $('#frmTopUpPlan').submit();
            }
            ;
        })
    })(jQuery);
});