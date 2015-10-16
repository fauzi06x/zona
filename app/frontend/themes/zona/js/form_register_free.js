document.addEventListener("DOMContentLoaded", function (event) {
    (function ($) {
        $('#buttonSubmitReg').click(function () {
            $('#freeMemberForm').submit();
        });
        $('#freeMemberForm').validate({
            rules: {
                nama: {
                    required: true,
                    minlength: 3
                },
                provinsi: {
                    required: true,
                    valueNotEquals: '0',
                },
                kota: {
                    required: true,
                    valueNotEquals: '0',
                },
                kecamatan: {
                    required: true,
                    valueNotEquals: '0',
                },
                email: {
                    email: true,
                    required: true
                },
                kontak: {
                    
                    required: true
                },
                kontak2: {
                    digits: true
                },
                fax: {
                    digits: true
                },
                perusahaan: {
                    required:true,
                    minlength: 3
                },
                ymid: {
                    minlength: 3
                }
            },
            messages: {
                provinsi: 'Silakan pilih Provinsi',
                kota: 'Silakan pilih Kabupaten/Kota',
                kecamatan: 'Silakan pilih Kecamatan',
            }
        });
        $('#uploadBtn').change(function(){
            $('#uploadFile').val($(this).val().replace('C:\\fakepath\\',''));
        });
        $('#provinsi').change(function (event) {
            $.resetSelectBox('Pilih Kabupaten/Kota', '#kota');
            $.resetSelectBox('Pilih Kecamatan', '#kecamatan');
            $.loadKota($(this).val(), '#kota');
        });

        $('#kota').change(function (event) {
            $.resetSelectBox('Pilih Kecamatan', '#kecamatan');
            $.loadKecamatan($(this).val(), '#kecamatan'); 
        });
    })(jQuery);
});