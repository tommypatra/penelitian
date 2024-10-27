const endpoint = base_url+'/api/interviewer';
const role_user_id = localStorage.getItem('role_user_id');

function updateDOMVerifikasi(kesimpulan,keterangan){
    var status = `Belum Diverifikasi`;
    var label_ket = (keterangan!=null)?` (${keterangan})`:``;
    if(kesimpulan==1){
        status = `Memenuhi Syarat`;
    }else if(kesimpulan==0){
        status = `Tidak Memenuhi Syarat`;
    }
    return status+label_ket;
}

$(document).ready(function() {
    // Menampilkan data awal
    dataLoad();

    $('#refresh').click(function(){
        dataLoad();
    });

    $('#editor').summernote({
        height: 150,
        toolbar: [
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]            
    });

    //listener untuk btn-aksi baik itu ganti atau hapus langsung ke endpoint
    $(document).on('click', '.btn-aksi', function() {
        const id = $(this).data('id');
        const action = $(this).data('action');
        if (action === 'config') {
            window.location.replace(base_url + '/pengaturan/' + id);
        } else if (action === 'edit') {
            showDataById(endpoint, id, function(response) {
                //jika tidak ada erorr eksekusi form ganti dengan response
                formGanti(response.data);
            });
        } else if (action === 'delete') {
            deleteData(endpoint, id, function() {
                toastr.success('operasi berhasil dilakukan!', 'berhasil');
                dataLoad();
            });
        }
    });

    // Handle item-paging limit change
    $('.item-paging').on('click', function() {
        vLimit = $(this).data('nilai');
        dataLoad();
    })

    // Handle page change
    $(document).on('click', '#pagination .page-link', function() {
        var page = $(this).data('page');
        var search = $('#search-input').val();
        dataLoad(page, search);
    });

    $("#form").validate({
        rules: {
            nilai: {
                required: true,
                min: 0,
                max: 100
            }
        },
        messages: {
            nilai: {
                required: "Nilai harus diisi",
                min: "Nilai tidak boleh kurang dari 0",
                max: "Nilai tidak boleh lebih dari 100"
            }
        },        
        submitHandler: function(form) {
            var content = $('#editor').summernote('code');
            var id=$("#nilai_interview_id").val();
            var type=(id=='')?'post':'put';
            var enpoint_nilai = base_url+'/api/nilai-interview';
            var url=(id=='')?enpoint_nilai:enpoint_nilai+'/'+id;


            var strippedContent = content.replace(/<\/?[^>]+(>|$)/g, '').trim();

            if (strippedContent === '') {
                toastr.error('Keterangan wajib diisi dan tidak boleh hanya berupa enter atau spasi!', 'Gagal');    
            }else if(confirm('apakah anda yakin?')){
                saveData(url, type, $(form).serialize(), function(response) {
                    // console.log(response);
                    toastr.success(response.message, 'berhasil');

                    // Mencari tombol aktif
                    var activeButton = $('#nav-soal .active');
                    var topikInterviewId = activeButton.data('index');
                    
                    // Cek apakah nilai_interview_id ada di response
                    if (response.data && response.data.nilai_interview_id !== null) {
                        // Update warna tombol aktif menjadi hijau
                        activeButton.css('background-color', 'green');
                        activeButton.css('color', 'white'); // Untuk kontras yang lebih baik

                        // Atau tambahkan class 'answered' jika Anda menggunakan CSS
                        activeButton.addClass('answered');

                        topik_interviews[topikInterviewId].nilai_interview = response.data.nilai;
                        topik_interviews[topikInterviewId].nilai_keterangan = response.data.keterangan;
                        topik_interviews[topikInterviewId].nilai_interview_id = response.data.id;            
                    }
                });
            }
        }
    });
});

//untuk show modal form
function showModalForm() {
    var fModalForm = new bootstrap.Modal(document.getElementById('modalForm'), {
        keyboard: false
    });

    $('#kesimpulan-verifikasi').show();
    fModalForm.show();
}

//load data interviewer pada jadwal tersedia
function dataLoad(page = 1, search = '') {
    var url = base_url+'/api/peserta-interviewer' + '?seleksi_id='+seleksi_id+'&role_user_id='+role_user_id+'&page=' + page + '&search=' + search + '&limit=' + vLimit;
    fetchData(url, function(response) {
        renderData(response);
    },true);
}

function hasilInterview(wawancara){
    var data=wawancara[0];
    var bgver = (data.nilai!=null) ? 'success' : 'danger';
    var status_interview=`<span class="badge rounded-circle bg-${bgver}"><i class="bi bi-x"></i></span>`;
    if(bgver=='success'){
        status_interview=`<span class="badge rounded-circle bg-${bgver}"><i class="bi bi-check2"></i></span>`;
    }

    return status_interview;
}

//untuk render dari database
function renderData(response) {
    const dataList = $('#data-list');
    const pagination = $('#pagination');
    let no = (response.current_page - 1) * response.per_page + 1;
    dataList.empty();
    if (response.data.length > 0) {
        $.each(response.data, function(index, dt) {
            // const publish=(dt.is_publish==1)?'Terpublikasi':'Belum Terpublikasi';
            // const bgdft = (dt.daftar_status) ? 'success' : 'danger';
            const row = `<tr>
                        <td>${no++}</td>
                        <td>
                            <figure>
                                <blockquote class="blockquote">
                                    <p>${dt.peserta_user_name}</p>
                                </blockquote>
                                <figcaption class="blockquote-footer">${dt.peserta_user_email}</figcaption>
                            </figure>                            
                        </td>
                        <td>${dt.noid}</td>
                        <td>${dt.institusi_nama}/ ${dt.sub_institusi_nama} - ${dt.sub_institusi_jenis}</td>
                        <td>${hasilInterview(dt.wawancara)}</td>
                        <td>
                            <button class="btn btn-secondary btn-sm" onClick="penilaianPeserta(${dt.id})" type="button" data-jum_pendaftar="${dt.jumlah_pendaftar}" data-role_user_id="${dt.id}" data-seleksi_id="${dt.id}"><i class="bi bi-journal-check"></i></button>
                        </td>
                    </tr>`;
            dataList.append(row);
        });
        renderPagination(response, pagination);
    }
}

function penilaianPeserta(pendaftar_id){
    var url = base_url + '/api/penilaian-interview/'+pendaftar_id;
    fetchData(url, function(response) {
        currentIndex = 0;        
        topik_interviews=response.topik_interviews;
        // pendaftar=response.pendaftar;
        // renderFormVerifikasi(response);
        displayPendaftar(response.pendaftar);
        displaySoal(currentIndex);
        createNavSoal();
        $('#nav-soal button[data-index="0"]').addClass('active');
        showModalForm();
    },false);
}

function displayPendaftar(dt){
    $('#wawancara_id').val(dt.wawancara_id);

    $('#identitas_peserta').html(`
        <div class="row">
            <div class="col-lg-12">
                <h4>${dt.seleksi_nama.toUpperCase()} (${dt.seleksi_tahun})</h4>
            </div>
        </div>


        <div class="mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="${base_url+'/'+dt.identitas_foto}" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <h5 class="card-title">${dt.user_name.toUpperCase()}</h5>
                <div class="card-text">Nomor ID : ${dt.peserta_noid}</div>
                <div class="card-text">${dt.sub_institusi_nama} ${dt.institusi_nama}</div>
                <div class="card-text"><small class="text-muted">${dt.identitas_alamat} - ${dt.identitas_hp}</small></div>
            </div>
        </div>
        </div>
    `);
}

function displaySoal(index) {
    var soal = topik_interviews[index];
    console.log(soal);
    $('#topik_interview_id').val(soal.id);
    $('#nilai_interview_id').val(soal.nilai_interview_id);

    $('#nilai').val(soal.nilai_interview);
    $('#editor').summernote('code', soal.nilai_keterangan);


    $('#soal').text(soal.bank_soal);
    $('#kategori').text("Kategori: " + soal.kategori_soal);
    $('#bobot').text("Bobot: " + soal.bobot);
    $('#soal-info').html(`<span class="badge bg-secondary">Soal ke ${(index + 1)} dari ${topik_interviews.length} total soal</span>`);

    // Logika untuk hide/show tombol "Soal Sebelumnya" dan "Soal Berikutnya"
    if (index === 0) {
        $('#prev').hide(); 
    } else {
        $('#prev').show(); 
    }

    if (index === topik_interviews.length - 1) {
        $('#next').hide(); 
    } else {
        $('#next').show();
    }    

    // Update navigasi soal aktif
    $('#nav-soal button').removeClass('active');
    $(`#nav-soal button[data-index="${index}"]`).addClass('active');    
}

// Fungsi untuk membuat tombol navigasi soal
function createNavSoal() {
    var navContainer = $('#nav-soal');
    navContainer.empty(); // Hapus konten navigasi sebelumnya

    var lastKategori = ''; // Variabel untuk menyimpan kategori terakhir
    var soalNumber = 1; // Nomor soal yang akan ditampilkan

    topik_interviews.forEach((soal, index) => {
        // Jika kategori berubah, tambahkan heading kategori
        if (soal.kategori_soal !== lastKategori) {
            navContainer.append(`<div class="mb-1"><span class="badge bg-secondary"><b>${soal.kategori_soal}</b></span></div>`); // Menampilkan kategori soal
            lastKategori = soal.kategori_soal; // Update kategori terakhir
        }

        // Tentukan kelas tombol berdasarkan nilai_interview_id
        var btnClass = soal.nilai_interview_id ? 'btn-success' : 'btn-outline-primary'; // Hijau jika nilai_interview_id tidak null

        // Buat tombol untuk navigasi soal
        var button = `<button type="button" class="btn ${btnClass} mx-1 mb-1" data-index="${index}">${soalNumber}</button>`;
        navContainer.append(button);

        soalNumber++; // Nomor soal terus bertambah meskipun kategori berubah
    });

    // Event handler untuk klik pada tombol navigasi soal
    $('#nav-soal button').click(function() {
        var selectedIndex = $(this).data('index');
        currentIndex = selectedIndex;
        displaySoal(currentIndex);
    });

    // Aktifkan tombol pertama saat modal dibuka
    $('#nav-soal button').first().addClass('active');
}


$('#prev').click(function() {
    if (currentIndex > 0) {
        currentIndex--;
        displaySoal(currentIndex);
    } else {
        alert("Ini adalah soal pertama!");
    }
});

// Event handler untuk tombol 'Soal Berikutnya'
$('#next').click(function() {
    if (currentIndex < topik_interviews.length - 1) {
        currentIndex++;
        displaySoal(currentIndex);
    } else {
        alert("Ini adalah soal terakhir!");
    }
});