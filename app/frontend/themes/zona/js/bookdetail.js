document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    (function ($) {
        $('#cfmCancelBooking').click(function (evt) {
            swal({
                title: 'Konfirmasi?',
                text: 'Yakin akan membatalkan booking ini?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Konfirmasi Pembatalan',
                closeOnConfirm: false
            }, function (c) {
                var thisBookID = $(this).data('id');
                if (c) {
                    $.ajax({
                        url: baseUrl + 'ajaxCancelBook.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            id: $('#cfmCancelBooking').data('id')
                        },
                        beforeSend: function (xhr) {
                            swal.disableButtons();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swal({title: 'Gagal',
                                text: 'Pembatalan Booking gagal, browser akan di-refresh!',
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                allowOutsideClick: false,
                                confirmButtonText: 'Refresh Browser.',
                                closeOnConfirm: false
                            }, function () {
                                document.location.reload();
                            });
                        },
                        success: function (resp) {
                            if (resp.status === 200) {
                                window.location.reload();
                            }
                            else {
                                swal({
                                    title: 'Gagal',
                                    text: resp.message,
                                    type: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    allowOutsideClick: false,
                                    confirmButtonText: 'Refresh Browser',
                                    closeOnConfirm: false
                                }, function () {
                                    document.location.reload();
                                });

                            }
                        },
                        complete: function (xhr) {

                        }
                    });
                }
            });
        });
        $('#cfmPrint').click(function (evt) {
            window.print();
        });
        $('#cfmAutoTicket').click(function () {
            swal('Terima Kasih', 'Nantikan fitur ini dalam versi berikutnya!', 'info');
        });
        $('#cfmSend').click(function (evt) {
            swal({
                title: 'Input E-mail',
                html: '<p>Masukkan e-mail</p><p><input name="sendto-bookdetail" type="email"/>',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proses',
                cancelButtonText: 'Batal',
                closeOnConfirm: false
            }, function (confirmIssued) {
                var email = jQuery('input[name=sendto-bookdetail]').val();
                if (String(email).indexOf('@') < 0) {
                    alert('E-mail tidak valid');
                }
                else {
                    $.ajax({
                        url: baseUrl + 'ajax/sendBookingByEmail.php',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            email: email,
                            id: getParameterByName('id')
                        },
                        beforeSend: function (xhr) {
                            swal.disableButtons();
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.success) {
                                swal('Berhasil', 'Data booking telah dikirimkan.', 'success');
                            }
                            else {
                                var basicMessage = 'Silakan coba lagi.';
                                swal('Error', typeof (data.message) == 'undefined' ? basicMessage : data.message, 'error');
                            }
                        },
                        complete: function (jqXHR, textStatus) {

                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swal('Error', 'Silakan coba lagi.', 'error');
                        }
                    });
                }
            }
            );
        });
        $('#cfmIssued').click(function (evt) {
            var thisButtn = $(this);
            var thisButton = $(this);
            if (thisButtn.html().trim() == 'Confirm Issued <i class="fa fa-check"></i>') {

                swal({
                    title: 'Konfirmasi?',
                    text: 'Lakukan Proses Issued untuk data ini?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proses',
                    closeOnConfirm: false
                }, function (confirmIssued) {
                    if (!confirmIssued) {
                        return false;
                        evt.preventDefault();
                    } else {
                        var defaultIssuedErrorMessage = 'Prosess Issued Error.';
                        $.ajax({
                            url: baseUrl + 'ajax/confirmIssuedBooking.php',
                            dataType: 'JSON',
                            type: 'POST',
                            beforeSend: function () {
                                swal.disableButtons();
                                thisButtn.html('Please Wait <i class="fa fa-hourglass"></i>');
                            },
                            data: {
                                id: thisButton.data('id')
                            },
                            success: function (resp) {
                                if (resp.success) {
                                    swal('Issued Success', 'Browser akan di refresh', 'success');
                                    document.location.reload();
                                }
                                else {
                                    swal('Gagal', typeof (resp.message) == 'undefined' ? defaultIssuedErrorMessage : resp.message, 'error');
                                }
                            },
                            complete: function () {
                                thisButtn.html('Confirm Issued <i class="fa fa-check"></i>');
                            }
                        });
                    }

                });//swal
            }//if textHtml=blabla

        });
    })(jQuery);
});