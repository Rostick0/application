(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.querySelectorAll('select');
        M.FormSelect.init(select);

        const datepicker = document.querySelectorAll('.datepicker');
        M.Datepicker.init(datepicker, {
            i18n: {
                months,
                monthsShort,
                weekdays,
                weekdaysShort,
                weekdaysAbbrev: weekdaysShort
            }
        });
    });
})()