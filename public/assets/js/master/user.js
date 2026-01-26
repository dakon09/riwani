"use strict";

var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_user").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url + "/master/user/data",
                type: "GET",
                data: function (data) {
                    data.name = $('#search_user_name').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'username' },
                { data: 'email' },
                { data: 'role' },
                { data: 'updated_at' },
                { data: 'id' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    width: "10px",
                    orderable: false,
                    render: function (data, type, row, meta) {
                        // console.log(meta.row+1);
                        return meta.row + 1;
                    },
                },
                {
                    targets: 5,
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
                                <button id="button_edit_category" class="btn p-1">
                                    <i class="las la-edit fs-2"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)" onclick="delete_user(`+ data + `);">
                                <button id="button_delete_user" class="btn p-1">
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
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
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

jQuery(document).ready((function () {
    // KTDatatablesContent.init_region();
    KTDatatablesServerSide.init();
}));

$('#search_user_name').keyup(delay(function (e) {
    $('#kt_datatable_user').DataTable().ajax.reload();
}, 500));

// Modul untuk mengelola logika form Tambah User
const KTDataAdd = function () {
    const modalElement = document.getElementById('kt_modal_add_user');
    const form = document.getElementById('kt_docs_form_add_user');
    const submitButton = document.getElementById('kt_docs_form_add_user_submit');
    const modal = new bootstrap.Modal(modalElement);
    let validator;

    const handleForm = function () {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: { message: 'Nama Harus Diisi' }
                        }
                    },
                    'username': {
                        validators: {
                            notEmpty: { message: 'Username Harus Diisi' }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: { message: 'Email Harus Diisi' },
                            emailAddress: { message: 'The value is not a valid email address' },
                        }
                    },
                    'password': {
                        validators: {
                            notEmpty: { message: 'Password Harus Diisi' }
                        }
                    },
                    'password_confirmation': {
                        validators: {
                            notEmpty: { message: 'Konfirmasi Password harus diisi' },
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'Password konfirmasi tidak sama'
                            }
                        }
                    },
                    'role': {
                        validators: {
                            notEmpty: { message: 'Role Harus Diisi' }
                        }
                    },
                    '2fa': {
                        validators: {
                            notEmpty: { message: 'Pilihan 2FA Harus Diisi' }
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

        // Revalidate Select2 input
        $(form.querySelector('[name="role"]')).on('change', function () {
            validator.revalidateField('role');
        });

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    $.ajax({
                        url: base_url + '/master/user/insert',
                        type: 'POST',
                        data: {
                            'name': $('#name').val(),
                            'username': $('#username').val(),
                            'email': $('#email').val(),
                            'password': $('#password').val(),
                            'password_confirmation': $('#password_confirmation').val(),
                            'role': $('#role').val(),
                            'mandatory_2fa': $('#2fa').val(),
                            '_token': csrf_token
                        },
                        success: function (response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: "Data User Berhasil Ditambahkan!",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    modal.hide();
                                    form.reset();
                                    $('#kt_datatable_user').DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire('Oops...', response.data, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                text: "Maaf, terjadi kesalahan.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: { confirmButton: "btn btn-danger" }
                            });
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

// Modul untuk mengelola logika form Edit User
const KTDataEdit = function () {
    const modalElement = document.getElementById('kt_modal_edit_user');
    const form = document.getElementById('kt_docs_form_edit_user');
    const submitButton = document.getElementById('kt_docs_form_edit_user_submit');
    const modal = new bootstrap.Modal(modalElement);
    let validator;

    const openModal = function (id) {
        // Reset form
        form.reset();

        $.ajax({
            type: "GET",
            url: base_url + '/master/user/show/' + id,
            success: function (response) {
                if (response.status == true) {
                    $('#name_edit').val(response.data.name);
                    $('#username_edit').val(response.data.username);
                    $('#user_id').val(response.data.id);
                    $('#email_edit').val(response.data.email);

                    $("#role_edit").select2().val(response.data.roles[0].name).trigger('change.select2');
                    $("#permission_additional").select2().val(response.permissions[0]).trigger('change.select2');
                    $("#2fa_edit").select2().val(response.data.mandatory_2fa).trigger('change.select2');

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
                            notEmpty: { message: 'Nama Harus Diisi' }
                        }
                    },
                    'username_edit': {
                        validators: {
                            notEmpty: { message: 'Username Harus Diisi' }
                        }
                    },
                    'email_edit': {
                        validators: {
                            notEmpty: { message: 'Email Harus Diisi' },
                            emailAddress: { message: 'The value is not a valid email address' },
                        }
                    },
                    'password_confirmation_edit': {
                        validators: {
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password_edit"]').value;
                                },
                                message: 'Password dan konfirmasi tidak sama'
                            }
                        }
                    },
                    'role_edit': {
                        validators: {
                            notEmpty: { message: 'Role Harus Diisi' }
                        }
                    },
                    '2fa_edit': {
                        validators: {
                            notEmpty: { message: 'Pilihan 2FA Harus Diisi' }
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

        // Revalidate Select2 input
        $(form.querySelector('[name="role_edit"]')).on('change', function () {
            validator.revalidateField('role_edit');
        });

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    $.ajax({
                        type: "POST",
                        url: base_url + '/master/user/update/' + $('#user_id').val(),
                        data: {
                            'name': $('#name_edit').val(),
                            'username': $('#username_edit').val(),
                            'email': $('#email_edit').val(),
                            'password': $('#password_edit').val(),
                            'role_id': $('#role_edit').val(),
                            'permission': $('#permission_additional').val(),
                            'mandatory_2fa': $('#2fa_edit').val(),
                            '_token': csrf_token
                        },
                        success: function (response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: "Data User Berhasil Diupdate!",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                })
                                    .then(() => {
                                        $('#kt_datatable_user').DataTable().ajax.reload();
                                        modal.hide();
                                        form.reset();
                                    })
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
    KTDataAdd.init();
    KTDataEdit.init();
}));

function delete_user(id_user) {
    swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data User akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        showLoaderOnConfirm: true,

        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    url: base_url + '/master/user/delete/' + id_user,
                    type: 'POST',
                    data: { '_method': 'POST', '_token': csrf_token },
                    dataType: 'json'
                }).done(function (response) {
                    swal.fire({
                        title: "Sukses",
                        text: "Data User berhasil di hapus!",
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function () {
                        $('#kt_datatable_user').DataTable().ajax.reload();
                    }
                    );
                }).fail(function () {
                    swal.fire('Oops...', 'Something went wrong, please try again !', 'error');
                });
            });
        }, allowOutsideClick: false
    });
}
