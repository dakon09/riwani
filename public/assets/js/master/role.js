var KTDatatablesContent = {
    // region
    initDatatable: function () {
        $("#kt_datatable_role").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url + "/master/role/data",
                type: "GET",
                data: function (data) {
                    data.name = $('#search_role_name').val();
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
                        // console.log(meta.row+1);
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
                    render: function (data, type, row) {
                        return `<div class="d-flex flex-row align-items-center">
                            <a href="javascript:void(0)" onclick="KTDataEdit.open(`+ data + `);">
                                <button id="button_edit_category" class="btn p-1">
                                    <i class="las la-edit fs-2"></i>
                                </button>
                            </a>
                        </div>
                        `;
                    },
                },

            ]
        })
    }
};

$('#search_role_name').keyup(delay(function (e) {
    $('#kt_datatable_role').DataTable().ajax.reload();
}, 500));

// Modul untuk mengelola logika form Tambah Role
const KTDataAdd = function () {
    const modalElement = document.getElementById('kt_modal_add_role');
    const form = document.getElementById('kt_docs_form_add_role');
    const submitButton = document.getElementById('kt_docs_form_add_role_submit');
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
                    'permission': {
                        validators: {
                            notEmpty: { message: 'Permission Harus Diisi' }
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
        $(form.querySelector('[name="permission"]')).on('change', function () {
            validator.revalidateField('permission');
        });

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    $.ajax({
                        type: "POST",
                        url: base_url + '/master/role/insert',
                        data: {
                            'name': $('#name').val(),
                            'permission': $('#permission').val(),
                            '_token': csrf_token
                        },
                        success: function (response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: "Data Role Berhasil Ditambahkan!",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#kt_datatable_role').DataTable().ajax.reload();
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

// Modul untuk mengelola logika form Edit Role
const KTDataEdit = function () {
    const modalElement = document.getElementById('kt_modal_edit_role');
    const form = document.getElementById('kt_docs_form_edit_role');
    const submitButton = document.getElementById('kt_docs_form_edit_role_submit');
    const modal = new bootstrap.Modal(modalElement);
    let validator;

    const openModal = function (id) {
        // Reset form
        form.reset();

        $.ajax({
            type: "GET",
            url: base_url + '/master/role/detail/' + id,
            success: function (response) {
                if (response.status == true) {
                    $('#role_id').val(response.data.detail_role.id);
                    $('#name_edit').val(response.data.detail_role.name);
                    $("#permission_edit").select2().val(response.data.role_permission).trigger('change.select2');

                    modal.show();
                }
                else {
                    Swal.fire('Oops...', 'Ada yang salah, silakan coba lagi!', 'error');
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
                    'permission_edit': {
                        validators: {
                            notEmpty: { message: 'Permission Harus Diisi' }
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
        $(form.querySelector('[name="permission_edit"]')).on('change', function () {
            validator.revalidateField('permission_edit');
        });

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    $.ajax({
                        type: "POST",
                        url: base_url + '/master/role/update/' + $('#role_id').val(),
                        data: {
                            'name': $('#name_edit').val(),
                            'permission': $('#permission_edit').val(),
                            '_token': csrf_token
                        },
                        success: function (response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: "Data Role Berhasil Diupdate!",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#kt_datatable_role').DataTable().ajax.reload();
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
    KTDatatablesContent.initDatatable();

    KTDataAdd.init();
    KTDataEdit.init();
}));