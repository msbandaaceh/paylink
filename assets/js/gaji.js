$(function () {

    if (document.getElementById('tabel-bulan')) {
        $("#tabel-bulan").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false
        }).buttons().container().appendTo('#tabel-bulan_wrapper .col-md-6:eq(0)');
    }

    if (document.getElementById('tabel-bulan')) {
        $("#tabel-gaji").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false
        }).buttons().container().appendTo('#tabel-bulan_wrapper .col-md-6:eq(0)');
    }
});

function detailBulan(bulan) {
    var form = $('<form action="detail_gaji" method="post">' +
        '<input type="hidden" name="tgl" value="' + bulan + '">' +
        '</form>');
    // Menambahkan formulir ke dalam dokumen
    $('body').append(form);
    // Mengirimkan formulir
    form.submit();
}

function detailPotonganBulan(bulan) {
    var form = $('<form action="detail_potongan_gaji" method="post">' +
        '<input type="hidden" name="tgl" value="' + bulan + '">' +
        '</form>');
    // Menambahkan formulir ke dalam dokumen
    $('body').append(form);
    // Mengirimkan formulir
    form.submit();
}

function ModalRole(id) {
    swal({
        title: "Memuat...",
        text: "Silakan tunggu sebentar.",
        imageUrl: "assets/images/loader.gif", // loader custom jika mau (opsional)
        showConfirmButton: false,
        allowOutsideClick: false
    });

    if (id != '-1') {
        $('#tabel-role').html('');
    }

    $.post('show_role',
        { id: id },
        function (response) {
            swal.close();

            try {
                const json = JSON.parse(response); // pastikan response valid JSON
                $('#pegawai_').html('');

                let html = `<select class="form-control" id="pegawai" name="pegawai" style="width:100%">`;
                json.pegawai.forEach(row => {
                    html += `<option value="${row.userid}" data-nama="${row.fullname}" data-jabatan="${row.jabatan}">${row.fullname}</option>`;
                });
                html += `</select>`;
                $('#pegawai_').append(html);

                $('#pegawai').select2({
                    dropdownParent: $('#role-pegawai'),
                    templateResult: formatPegawaiOption,
                    templateSelection: formatPegawaiSelection,
                    width: '100%',
                    placeholder: "Pilih pegawai"
                });

                $('#peran_').html('');
                let role = `<select class="form-control" id="peran" name="peran" style="width:100%">`;
                role += `<option value="operator">Operator Keuangan</option>`;
                role += `</select>`;
                $('#peran_').append(role);

                $('#peran').select2({
                    dropdownParent: $('#role-pegawai'),
                    width: '100%',
                    placeholder: "Pilih Peran"
                });
                $('#role-pegawai').modal('show');
                if (id != '-1') {
                    $('#id').val('');

                    $('#id').val(json.id);
                    $('#pegawai').val(json.editPegawai).trigger('change');
                    $('#peran').val(json.editPeran).trigger('change');

                    $('#pegawai').on('select2:opening select2:selecting', function (e) {
                        e.preventDefault(); // mencegah dropdown terbuka
                    });
                } else {
                    $('#tabel-role').html('');

                    let data = `
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead><tbody>`;
                    json.data_peran.forEach(row => {
                        if (`${row.peran}` == 'operator') {
                            var peran = 'Operator Keuangan';
                        }
                        data += `
                        <tr>
                            <td>${row.nama}</td>
                            <td>`;


                        if (`${row.hapus}` == '0') {
                            data += `<span class='badge bg-green'>${peran}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs bg-orange" id="editPeran" onclick="ModalRole('${row.id}')" title="Edit Peran">
                                    <i class="material-icons">mode_edit</i>
                                </button>
                                <button type="button" class="btn btn-xs bg-red" id="hapusPeran" onclick="blokPeran('${row.id}')" title="Blok Pegawai">
                                    <i class="material-icons">block</i>
                                </button>`;
                        } else {
                            data += `<span class='badge bg-grey'>${peran}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs bg-success" id="hapusPeran" onclick="aktifPeran('${row.id}')" title="Aktifkan Pegawai">
                                    <i class="material-icons">check</i>
                                </button>`;
                        }
                        data += `
                            </td>
                        </tr>`;
                    });
                    data += `
                        </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <span class='badge bg-green'>aktif</span>
                        <span class='badge bg-grey'>non-aktif</span>
                    </div>`;
                    $('#tabel-role').append(data);
                }
            } catch (e) {
                console.error("Gagal parsing JSON:", e);
                $('#pegawai_').html('<div class="alert alert-danger">Gagal memuat data pegawai.</div>');
            }
        }
    );
}

function aktifPeran(id) {
    swal({
        title: "Yakin ingin mengaktifkan peran pegawai?",
        text: "Data peran ini akan diaktifkan kembali perannya.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, aktifkan!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
    }, function () {
        // Eksekusi penghapusan setelah konfirmasi
        $.post('aktif_peran', { id: id }, function (response) {
            // kamu bisa parse response jika berupa JSON
            swal("Berhasil!", "Peran telah aktifkan.", "success");
            // misal reload tabel setelah hapus:
            ModalRole('-1');
        }).fail(function () {
            swal("Gagal", "Terjadi kesalahan saat menghapus data.", "error");
        });
    });
}

function blokPeran(id) {
    swal({
        title: "Yakin ingin menonaktifkan peran pegawai?",
        text: "Data peran ini akan dinonaktifkan perannya.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, nonaktifkan!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
    }, function () {
        // Eksekusi penghapusan setelah konfirmasi
        $.post('blok_peran', { id: id }, function (response) {
            // kamu bisa parse response jika berupa JSON
            swal("Berhasil!", "Peran telah nonaktifkan.", "success");
            // misal reload tabel setelah hapus:
            ModalRole('-1');
        }).fail(function () {
            swal("Gagal", "Terjadi kesalahan saat menghapus data.", "error");
        });
    });
}

function formatPegawaiOption(option) {
    if (!option.id) return option.text;

    const nama = $(option.element).data('nama');
    const jabatan = $(option.element).data('jabatan');

    return $(`
        <div style="line-height:1.2">
            <div style="font-weight:bold;">${nama}</div>
            <div style="font-size:12px; color:#555;">${jabatan}</div>
        </div>
    `);
}

// Menampilkan teks terpilih di kotak select
function formatPegawaiSelection(option) {
    if (!option.id) return option.text;

    const nama = $(option.element).data('nama');
    const jabatan = $(option.element).data('jabatan');

    return `${nama} > ${jabatan}`;
}

function loadKategori(id) {
    $.post('show_kategori', { id: id }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $('#modalAddKategori').modal('show');
            $("#id").val('');
            $("#judul_").html('');
            $("#kategori_").val('');

            $("#id").val(json.id);
            $("#judul_").append(json.judul);
            $("#kategori_").val(json.kategori);

        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }
    });
}

function hapusKategori(id) {
    //console.log(id);

    swal({
        title: "<h5>HAPUS AGENDA RAPAT</h5>",
        text: "<h5>Apa Anda Yakin Akan Menghapus Kategori?</h5>",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#DD2A2A",
        confirmButtonText: "Ya, Hapus !",
        cancelButtonText: "Tidak !",
        html: true,
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.post('hapus_kategori', { id: id }, function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {
                    swal({
                        title: "Berhasil !",
                        text: "Anda Sudah Menghapus Agenda Rapat",
                        type: "success",
                        confirmButtonColor: "#8EC165",
                        confirmButtonText: "Oke",
                    }, function () {
                        location.reload();
                    });
                } else if (json.st == 2) {
                    swal("Gagal", "Anda Gagal Menghapus Kategori, Kategori tersebut masih digunakan", "error");
                } else if (json.st == 0) {
                    swal("Gagal", "Anda Gagal Menghapus Kategori, Silakan Ulangi Lagi", "error");
                }
            })
        } else {
            swal("Batal", "Anda Batal Menghapus Kategori", "error");
        }
    }
    );

}

var result = config.result;
var pesan = config.pesan;
if (result != '-1') {
    if (result == '1') {
        sukses(pesan);
    } else if (result == '2') {
        peringatan(pesan);
    } else {
        gagal(pesan);
    }
}

function sukses(pesan) {
    swal({
        title: "<h4>Sukses<h4>",
        type: "success",
        text: "<h5>" + pesan + "</h5>",
        html: true
    });
}

function peringatan(pesan) {
    swal({
        title: "<h4>Oops...<h4>",
        type: "warning",
        text: "<h5>" + pesan + "</h5>",
        html: true
    });
}

function gagal(pesan) {
    swal({
        title: "<h4>Oops...<h4>",
        type: "error",
        text: "<h5>" + pesan + "</h5>",
        html: true
    });
}



