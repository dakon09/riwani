$(document).ready(function () {
    var form = $('#fixForm');
    if (!form.length) {
        return;
    }

    var provincesUrl = form.data('provinces-url');
    var citiesUrl = form.data('cities-url');
    var districtsUrl = form.data('districts-url');
    var villagesUrl = form.data('villages-url');

    function initDependent($element, urlTemplate, parentVal) {
        if (!parentVal) {
            return;
        }

        var finalUrl = urlTemplate.replace('/0', '/' + parentVal);

        $element.select2({
            width: '100%',
            placeholder: $element.data('placeholder'),
            allowClear: true,
            ajax: {
                url: finalUrl,
                dataType: 'json',
                delay: 250,
                data: function (params) { return { q: params.term }; },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return { text: item.name, id: item.code };
                        })
                    };
                }
            }
        });
        $element.prop('disabled', false);
    }

    $('.province-select').select2({
        width: '100%',
        placeholder: 'Pilih Provinsi',
        allowClear: true,
        ajax: {
            url: provincesUrl,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return { text: item.name, id: item.code };
                    })
                };
            }
        }
    });

    $(document).on('change', '.province-select', function () {
        var provinceId = $(this).val();
        var $row = $(this).closest('tr');
        var $city = $row.find('.city-select');

        $row.find('.city-select, .district-select, .village-select').empty().prop('disabled', true);

        if (provinceId) {
            initDependent($city, citiesUrl, provinceId);
        }
    });

    $(document).on('change', '.city-select', function () {
        var cityId = $(this).val();
        var $row = $(this).closest('tr');
        var $district = $row.find('.district-select');

        $row.find('.district-select, .village-select').empty().prop('disabled', true);

        if (cityId) {
            initDependent($district, districtsUrl, cityId);
        }
    });

    $(document).on('change', '.district-select', function () {
        var districtId = $(this).val();
        var $row = $(this).closest('tr');
        var $village = $row.find('.village-select');

        $row.find('.village-select').empty().prop('disabled', true);

        if (districtId) {
            initDependent($village, villagesUrl, districtId);
        }
    });

    $('.city-select, .district-select, .village-select').select2({
        width: '100%',
        placeholder: 'Pilih...',
        disabled: true
    });
});
