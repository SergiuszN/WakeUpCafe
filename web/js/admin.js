(function () {
    $('#app_bundle_reservation_form_date select').change(function () {
        var date = ('0' + $('#app_bundle_reservation_form_date_day').val()).slice(-2)
        + '-' + ('0' + $('#app_bundle_reservation_form_date_month').val()).slice(-2)
        + '-' + $('#app_bundle_reservation_form_date_year').val();
        window.location.href = $('#path').html() + '?date=' + date;
    });
})();