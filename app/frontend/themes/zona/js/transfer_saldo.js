document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    (function ($) {
        jQuery.fillTrfsalForm = function (iObject) {
            jQuery('.fa.fa-check.green').removeClass('green');
            var jQiObj = jQuery(iObject);
            jQiObj.addClass('green');
            jQuery('#infNama').text(jQiObj.data('nama'));
            jQuery('#infMemberId').text(jQiObj.data('memberid'));
            jQuery('#infPerusahaan').text(jQiObj.data('perusahaan'));
            jQuery('#inpNominal').val(0);
            jQuery('#inpMemberId').val(jQiObj.data('memberid'));
        }
        $('#tblTrfSaldo').show().DataTable({
            ajax: {
                url: baseUrl + 'ajax/listDownlineTrfSal.php',
                type: 'POST',
            },
            serverSide: true,
            processing: true,
            columns: [
                {data: "num", sortable: false},
                {data: "agi"},
                {data: "n"},
                {data: "a", render: function (data, type, full, meta) {
                        return data + ' ' + (full.kc.trim()) + ', ' + (full.ko.trim()) + ', ' + (full.pr.trim());
                    }},
                {data: "kc", visible: false},
                {data: "ko", visible: false},
                {data: "pr", visible: false},
                {data: "per"},
                {data: "pa"},
                {data: "sa",
                    searchable: false,
                    render: function (data) {
                        return parseInt(data).formatMoney(0);
                    }},
                {data: 'uid', render: function (data, ty, row) {
                        var greenClass = $('#inpMemberId').val() == row.agi ? 'green' : '';
                        return '<i class="fa fa-check ' + greenClass + '" style="cursor:pointer" title="Pilih" '
                                + ' data-memberid="' + row.agi.trim() + '" '
                                + ' onClick="jQuery.fillTrfsalForm(this);" '
                                + ' data-perusahaan="' + row.per.trim() + '" '
                                + ' data-nama="' + row.n.trim() + '" '
                                + '></i>';
                    }},
            ]
        });

        $('#frmTrfSal').submit(function (event) {
            if ($('#frmTrfSal').valid()) {
                swal({
                    title: 'Konfirmasi Transfer',
                    html: 'Anda akan melakukan transfer saldo kepada ' + $('#infNama').text() + ' (' + $('#infMemberId').text() + ') sebesar '
                            + parseInt(jQuery('#inpNominal').val()).formatMoney(0) + '. Lanujtkan?',
                    type: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                    closeOnConfirm: false
                }, function (cfM) {
                    if (cfM) {

                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            data: $('#frmTrfSal').serialize(),
                            url: baseUrl + 'ajax/doTransferSaldo.php',
                            beforeSend: function (xhr) {
                                swal.disableButtons();
                            }, error: function (jqXHR, textStatus, errorThrown) {
                                swal('Error', 'Kesalahan saat meminta ke server', 'error');
                            },
                            success: function (data, textStatus, jqXHR) {
                                console.log(data);
                                if (data.success) {
                                    swal('Success', 'Saldo berhasil di transfer, sisa saldo anda adalah '
                                            + data.lastbalance + '.', 'success');
                                }
                                else {
                                    var defaultErrorMsg = 'Tidak dapat melakukan transfer saldo.';
                                    swal('Gagal', typeof (data.message) == 'undefined' ? defaultErrorMsg : data.message, 'error');
                                }
                            }
                        });
                    }
                });
            }
            ;
            event.preventDefault();
        });
    })(jQuery);
});