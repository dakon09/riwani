"use strict";

var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_permission").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url + "/master/permission/data",
                type: "GET",
                data: function (data) {
                    data.name = $('#search_permission_name').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'id' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    },
                },
                {
                    targets: [2, 3],
                    render: function (data, type, full, meta) {
                        return moment(data).format('D MMMM YYYY');
                    }
                },
                {
                    targets: -1,
                    width: "75px",
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        return `<div class="d-flex flex-row align-items-center">
                            <a href="javascript:void(0)" onclick="KTDataEdit.open(`+ data + `);">
                                <button id="button_edit_permission" class="btn p-1">
                                    <i class="las la-edit fs-2"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)" onclick="delete_permission(`+ data + `);">
                                <button id="button_delete_permission" class="btn p-1">
                                    <i class="las la-trash fs-2"></i>
                                </button>
                            </a>
                        </div>
                        `;
                    },
                },

            ]
        });

    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-permissions-table-filter="search"]');
        filterSearch.addEventListener('keyup', delay(function (e) {
            dt.search(e.target.value).draw();
        }, 1000));
    }
    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
        }
    }
}();

$('#search_permission_name').keyup(delay(function (e) {
    $('#kt_datatable_permission').DataTable().ajax.reload();
}, 500));

// Modul untuk mengelola logika form Tambah Permission
const KTDataAdd = function () {
    const modalElement = document.getElementById('kt_modal_add_permission');
    const form = document.getElementById('kt_docs_form_add_permission');
    const submitButton = document.getElementById('kt_docs_form_add_permission_submit');
    const modal = new bootstrap.Modal(modalElement);
    let validator;

    const handleForm = function () {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: { message: 'Nama Permission Harus Diisi' }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    $.ajax({
                        type: "POST",
                        url: base_url + '/master/permission/insert',
                        data: {
                            'name': $('#name').val(),
                            '_token': csrf_token
                        },
                        success: function (response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: "Data Permission Berhasil Ditambahkan!",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#kt_datatable_permission').DataTable().ajax.reload();
                                    modal.hide();
                                    form.reset();
                                });
                            }
                            else {
                                Swal.fire('Oops...', response.data, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", "Terjadi kesalahan saat menyimpan.", "error");
                        },
                        complete: function () {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                        }
                    });
                } else {
                    Swal.fire({
                        text: "Maaf, Mohon lengkapi form terlebih dahulu.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, Mengerti!",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
        });
    }

    return {
        init: function () {
            handleForm();
        }
    };
}();

// Modul untuk mengelola logika form Edit Permission
const KTDataEdit = function () {
    const modalElement = document.getElementById('kt_modal_edit_permission');
    const form = document.getElementById('kt_docs_form_edit_permission');
    const submitButton = document.getElementById('kt_docs_form_edit_permission_submit');
    const modal = new bootstrap.Modal(modalElement);
    let validator;

    const openModal = function (id) {
        // Reset form
        form.reset();

        $.ajax({
            type: "GET",
            url: base_url + '/master/permission/detail/' + id,
            success: function (response) {
                if (response.status == true) {
                    $('#permission_id').val(response.data.id);
                    $('#name_edit').val(response.data.name);

                    modal.show();
                }
                else {
                    Swal.fire('Oops...', 'Something went wrong, please try again later!', 'error');
                }
            },
            error: function () {
                Swal.fire("Error", "Gagal mengambil data.", "error");
            }
        });
    };

    const handleForm = function () {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name_edit': {
                        validators: {
                            notEmpty: { message: 'Nama Permission Harus Diisi' }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    $.ajax({
                        type: "POST",
                        url: base_url + '/master/permission/update/' + $('#permission_id').val(),
                        data: {
                            'name': $('#name_edit').val(),
                            '_token': csrf_token
                        },
                        success: function (response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: "Data Permission Berhasil Diupdate!",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#kt_datatable_permission').DataTable().ajax.reload();
                                    modal.hide();
                                    form.reset();
                                });
                            }
                            else {
                                Swal.fire('Oops...', response.data, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", "Terjadi kesalahan saat update.", "error");
                        },
                        complete: function () {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                        }
                    });
                } else {
                    Swal.fire({
                        text: "Maaf, Mohon lengkapi form terlebih dahulu.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, Mengerti!",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
        });
    };

    return {
        init: function () {
            handleForm();
        },
        open: openModal
    };
}();

// Initialize modules on document ready
jQuery(document).ready((function () {
    KTDatatablesServerSide.init();

    KTDataAdd.init();
    KTDataEdit.init();
}));

function delete_permission(id) {
    swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Permission akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        showLoaderOnConfirm: true,

        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    url: base_url + '/master/permission/delete/' + id,
                    type: 'POST',
                    data: { '_method': 'POST', '_token': csrf_token },
                    dataType: 'json'
                }).done(function (response) {
                    swal.fire({
                        title: "Sukses",
                        text: "Data Permission berhasil di hapus!",
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function () {
                        $('#kt_datatable_permission').DataTable().ajax.reload();
                    }
                    );
                }).fail(function () {
                    swal.fire('Oops...', 'Something went wrong, please try again !', 'error');
                });
            });
        }, allowOutsideClick: false
    });
}
