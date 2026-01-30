$(document).ready(function () {
    var datatableUrl = "/master/umkm/datatable";

    var table = $('#kt_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: datatableUrl,
            type: 'GET'
        },
        columns: [
            { data: 'umkm_code', name: 'umkm_code' },
            { data: 'nama_usaha', name: 'nama_usaha' },
            { data: 'jenis_usaha', name: 'jenis_usaha' },
            { data: 'nama_pemilik', name: 'nama_pemilik' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'source_badge', name: 'source_input', orderable: false, searchable: false },
            { data: 'status_badge', name: 'status_umkm', orderable: false, searchable: false },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-end'
            }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
            errorLoading: function () {
                console.warn('Failed to load DataTables Indonesian language file from CDN. Using default English.');
            }
        },
        order: [[0, 'desc']],
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]]
    });

    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data UMKM akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/master/umkm/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(function () {
                                table.ajax.reload();
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus data'
                        });
                    }
                });
            }
        });
    });

    // Change Status Handler
    $(document).on('click', '.change-status-btn', function () {
        var id = $(this).data('id');
        var status = $(this).data('status');

        $('#status_umkm_id').val(id);
        $('#status_umkm_select').val(status).trigger('change');

        $('#kt_modal_change_status').modal('show');
    });

    $('#kt_modal_change_status_form').on('submit', function (e) {
        e.preventDefault();

        var id = $('#status_umkm_id').val();
        var status = $('#status_umkm_select').val();
        var submitBtn = $('#kt_modal_change_status_submit');

        submitBtn.attr('data-kt-indicator', 'on').prop('disabled', true);

        $.ajax({
            url: '/master/umkm/' + id + '/change-status',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status_umkm: status
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#kt_modal_change_status').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {
                        table.ajax.reload();
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat mengupdate status'
                });
            },
            complete: function () {
                submitBtn.removeAttr('data-kt-indicator').prop('disabled', false);
            }
        });
    });
});
