$(document).ready(function () {
    var dropzone;
    var previewSection = $('#previewSection');
    var errorsSection = $('#errorsSection');
    var importUrl = "/master/umkm/import";

    if (typeof Dropzone !== 'undefined') {
        dropzone = new Dropzone("#kt_dropzonejs", {
            url: importUrl,
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 10,
            acceptedFiles: ".xlsx,.xls,.csv",
            addRemoveLinks: true,
            autoProcessQueue: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                this.on("addedfile", function (file) {
                    var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-danger'>Batal</button>");
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        _this.removeFile(file);
                    });
                    file.previewElement.appendChild(removeButton);
                });

                this.on("success", function (file, response) {
                    // Check if response is HTML (Import Preview View)
                    if (typeof response === 'string') {
                        document.open();
                        document.write(response);
                        document.close();
                        return;
                    }

                    if (response.status === 'success') {
                        showPreview(response.data);
                        dropzone.disable();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                        this.removeFile(file);
                    }
                });

                this.on("error", function (file, errorMessage) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: typeof errorMessage === 'string' ? errorMessage : 'Terjadi kesalahan saat upload file'
                    });
                });

                this.on("processing", function () {
                    Swal.fire({
                        title: 'Processing',
                        text: 'Mohon tunggu, sedang memproses file...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });

                this.on("complete", function () {
                    Swal.close();
                });
            }
        });

        $('#cancelBtn').on('click', function () {
            dropzone.enable();
            dropzone.removeAllFiles();
            previewSection.hide();
            errorsSection.hide();
        });
    }

    function showPreview(data) {
        $('#totalRow').text(data.total);
        $('#successRow').text(data.success);
        $('#failedRow').text(data.failed);
        $('#warningRow').text(data.errors ? data.errors.length : 0);

        if (data.errors && data.errors.length > 0) {
            errorsSection.show();
            var tbody = $('#errorsTableBody');
            tbody.empty();

            data.errors.forEach(function (error) {
                var row = '<tr>' +
                    '<td>' + (error.row || '-') + '</td>' +
                    '<td>' + (error.nama_usaha || '-') + '</td>' +
                    '<td class="text-danger">' + error.message + '</td>' +
                    '</tr>';
                tbody.append(row);
            });
        } else {
            errorsSection.hide();
        }

        previewSection.show();
        Swal.fire({
            icon: data.failed > 0 ? 'warning' : 'success',
            title: data.failed > 0 ? 'Import Selesai dengan Warning' : 'Import Berhasil',
            text: 'Total: ' + data.total + ' | Berhasil: ' + data.success + ' | Gagal: ' + data.failed,
            timer: 2000,
            showConfirmButton: false
        });
    }
});
