jQuery.extend(jQuery.validator.messages, {
    required: "Silakan isi field ini.",
    remote: "Silakan perbaiki isian field ini.",
    email: "Silakan masukkan alamat e-mail yang valid.",
    url: "Silakan masukkan alamat URL yang valid.",
    date: "Silakan masukkan format tanggal yang valid.",
    dateISO: "Silakan masukkan format tanggal ISO yang valid.",
    number: "Silakan masukkan angka yang valid.",
    digits: "Silakan hanya masukkan karakter angka.",
    equalTo: "Silakan masukkan kembali nilai yang sama.",
    minlength: jQuery.validator.format("Silakan masukkan setidaknya {0} karakter."),
    maxlength: jQuery.validator.format("Silakan masukkan kurang dari {0} karakter."),
    max: jQuery.validator.format("Silakan masukkan kurang dari atau sama dengan {0}."),
    min: jQuery.validator.format("Silakan masukkan lebih dari atau sama dengan {0}.")
});
jQuery.loadProvinsi = function (target) {
    var url = baseUrl + 'ajax/namadaerah.php';
    jQuery.ajax({
        url: url,
        beforeSend: function (xhr) {
            jQuery(target).after('<img src="' + baseUrl + 'assets/common/images/ajax-loader.gif" class="loading-gif-field"/>');
        },
        complete: function (xhr) {
            jQuery(target).parent().find('.loading-gif-field').remove();
        },
        dataType: 'JSON',
        success: function (response) {
            //console.log(response);
        }
    });
};
jQuery.loadKota = function (provinsi, target) {
    var url = baseUrl + 'ajax/namadaerah.php?prov=' + provinsi;
    jQuery.ajax({
        url: url,
        beforeSend: function (xhr) {
            jQuery(target).after('<img src="' + baseUrl + 'assets/common/images/ajax-loader.gif" class="loading-gif-field"/>');
        },
        complete: function (xhr) {
            jQuery(target).parent().find('.loading-gif-field').remove();
        },
        dataType: 'JSON',
        success: function (response) {
            var optString = '<option value="0">Pilih Kabupaten/Kota</option>';
            for (var kt in response) {
                if (typeof (response[kt].kota) !== 'undefined') {
                    optString += '<option value="' + response[kt].kota + '">' + response[kt].kota + '</option>';
                }
                ;
            }
            ;
            jQuery(target).html(optString);
            if (jQuery(target).hasClass('chosen-select')) {
                jQuery(target).trigger('chosen:updated');
            }
        }
    });
};


jQuery.loadKecamatan = function (kota, target) {
    var url = baseUrl + 'ajax/namadaerah.php?kota=' + kota;
    jQuery.ajax({
        url: url,
        beforeSend: function (xhr) {
            jQuery(target).after('<img src="' + baseUrl + 'assets/common/images/ajax-loader.gif" class="loading-gif-field"/>');
        },
        complete: function (xhr) {
            jQuery(target).parent().find('.loading-gif-field').remove();
        },
        dataType: 'JSON',
        success: function (response) {
            var optString = '<option value="0">Pilih Kecamatan</option>';
            for (var kC in response) {
                if (typeof (response[kC].kec) !== 'undefined') {
                    optString += '<option value="' + response[kC].kec + '">' + response[kC].kec + '</option>';
                }
                ;
            }
            ;
            jQuery(target).html(optString);
            if (jQuery(target).hasClass('chosen-select')) {
                jQuery(target).trigger('chosen:updated');
            }

        }
    });
};
jQuery.resetSelectBox = function (stringDefault, target, defaultValue) {
    var defaultValue = typeof (defaultValue) === 'undefined' ? 0 : defaultValue;
    jQuery(target).html('<option value="' + defaultValue + '">' + stringDefault + '</option>');
};