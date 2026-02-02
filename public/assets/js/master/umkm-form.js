$(document).ready(function () {
    var form = $('#umkm_form');
    if (!form.length) {
        return;
    }

    var provincesUrl = form.data('provinces-url');
    var citiesUrl = form.data('cities-url');
    var districtsUrl = form.data('districts-url');
    var villagesUrl = form.data('villages-url');

    var initialProv = form.data('initial-province') || '';
    var initialCity = form.data('initial-city') || '';
    var initialDistrict = form.data('initial-district') || '';
    var initialVillage = form.data('initial-village') || '';

    function loadProvinces() {
        $.ajax({
            url: provincesUrl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#provinsi_id').empty().append('<option value="">Pilih Provinsi</option>');
                $.each(data, function (key, value) {
                    var selected = (value.code == initialProv) ? 'selected' : '';
                    $('#provinsi_id').append('<option value="' + value.code + '" ' + selected + '>' + value.name + '</option>');
                });

                if (initialProv) {
                    $('#provinsi_id').val(initialProv).trigger('change');
                }
            }
        });
    }

    function loadCities(provinceId) {
        var url = citiesUrl.replace('/0', '/' + provinceId);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#kabupaten_id').append('<option value="' + value.code + '">' + value.name + '</option>');
                });
                $('#kabupaten_id').prop('disabled', false);

                if (initialCity && provinceId == initialProv) {
                    $('#kabupaten_id').val(initialCity).trigger('change');
                    initialCity = '';
                }
            }
        });
    }

    function loadDistricts(cityId) {
        var url = districtsUrl.replace('/0', '/' + cityId);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#kecamatan_id').append('<option value="' + value.code + '">' + value.name + '</option>');
                });
                $('#kecamatan_id').prop('disabled', false);

                if (initialDistrict && cityId == form.data('initial-city')) {
                    $('#kecamatan_id').val(initialDistrict).trigger('change');
                    initialDistrict = '';
                }
            }
        });
    }

    function loadVillages(districtId) {
        var url = villagesUrl.replace('/0', '/' + districtId);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#kelurahan_id').append('<option value="' + value.code + '">' + value.name + '</option>');
                });
                $('#kelurahan_id').prop('disabled', false);

                if (initialVillage && districtId == form.data('initial-district')) {
                    $('#kelurahan_id').val(initialVillage).trigger('change');
                    initialVillage = '';
                }
            }
        });
    }

    loadProvinces();

    $('#provinsi_id').on('change', function () {
        var provinceId = $(this).val();
        $('#kabupaten_id').empty().append('<option value="">Pilih Kabupaten/Kota</option>').prop('disabled', true);
        $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
        $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', true);

        if (provinceId) {
            loadCities(provinceId);
        }
    });

    $('#kabupaten_id').on('change', function () {
        var cityId = $(this).val();
        $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
        $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', true);

        if (cityId) {
            loadDistricts(cityId);
        }
    });

    $('#kecamatan_id').on('change', function () {
        var districtId = $(this).val();
        $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', true);

        if (districtId) {
            loadVillages(districtId);
        }
    });
});
