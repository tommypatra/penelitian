@extends('akun.template')

@section('head')
  <title>Daftar Surat Penugasan</title> 
  <style>
      .form-select {
        width: auto;
        min-width: 175px; /* Tetap tetapkan batas minimal */      
      }
  </style>
@endsection

@section('container')
<div class="page-inner">
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Daftar Surat Penugasan</h3>
      <h6 class="op-7 mb-2">Daftar surat penugasan yang telah diajukan</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" name="search-input" id="search-input" aria-label="Text input with dropdown button">
          <div class="input-group-append">
            <button class="btn btn-primary btn-border" type="button" id="btn-cari">
              <i class="fas fa-search"></i> Cari
            </button>
          </div>
        </div>
      </div>      
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card card-round">
        <div class="card-header">
          <div class="card-head-row card-tools-still-right">
            <h4 class="card-title">Daftar Surat Penugasan</h4>
            <div class="card-tools">
              <a href="#" class="btn btn-primary btn-round" id="btn-refresh"><i class="fas fa-sync-alt"></i></a>
            </div>
          </div>
          {{-- <p class="card-category">
            Data unit kerja
          </p> --}}
        </div>
        <div class="card-body">
          <div class="row">

            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-hover table-head-bg-success">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tahun/ Penelitian</th>
                      <th>Surat Penugasan</th>
                      <th>Judul</th>
                      <th>QrCode Ketua</th>
                      <th>QrCode Link</th>
                      <th>Download</th>
                    </tr>
                  </thead>
                  <tbody id="data-list">
                    <!-- Data akan dimuat di sini -->
                  </tbody>
                </table>
              </div>
              <!-- Pagination -->
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center" id="pagination"></ul>
              </nav>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection


@section('modal')

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="{{ asset('js/crud.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>

<script>
  const endpoint = base_url+'/api/surat-tugas-dosen';
  var page = 1;

  $(document).ready(function() {

    dataLoad();

    function renderData(response) {
        const dataList = $('#data-list');
        const pagination = $('#pagination');
        const data=response.data.data;
        let no = (response.data.current_page - 1) * response.data.per_page + 1;
        dataList.empty();
        pagination.empty();
        if (data.length > 0) {
            $.each(data, function(index, dt) {
                const peneliti = dt.peneliti;
                const penelitian = peneliti.penelitian;
                const ketua_lppm = dt.ketua_lppm_role.user;
                const user = dt.peneliti.user_role.user;
                const identitas = user.identitas[0];
                const qr_id = `qr-code-${index}`;
                const qr_content = `disetujui ${ketua_lppm.name} untuk ${user.name}; ${dt.nomor_surat}`;
                const qr_id_link = `qr-code-link-${index}`;
                const qr_content_link = `${base_url}/cek-qrcode/${dt.id}`;

                const row = `<tr>
                            <td>${no++}</td>
                            <td>${penelitian.tahun} - ${penelitian.nama}</td>
                            <td>
                              ${dt.nomor_surat}   
                              ${dt.tanggal_surat} 
                            </td>
                            <td>
                              ${peneliti.judul}
                              <div style="font-size:11px;">${user.name}</div>
                            </td>
                            <td><div id="${qr_id}"></div></td>
                            <td><div id="${qr_id_link}"></div></td>
                            <td><a href="${base_url}/cetak-surat-penugasan/${dt.id}" target="_blank">Download Surat</a></td>
                        </tr>`;
                dataList.append(row);

                // Buat QR code menggunakan QRCode.js
                new QRCode(document.getElementById(qr_id), {
                    text: qr_content,
                    width: 75,
                    height: 75
                });                

                // Buat QR code menggunakan QRCode.js
                new QRCode(document.getElementById(qr_id_link), {
                    text: qr_content_link,
                    width: 75,
                    height: 75
                });                

            });
            renderPagination(response.data, pagination);
        }
    }    

    function dataLoad() {
      var search = $('#search-input').val();
      var url = endpoint + '?page=' + page + '&search=' + search + '&limit=' + vLimit;

      fetchData(url, function(response) {
          renderData(response);
      },true);
    }

    // Handle page change
    $(document).on('click', '.page-link', function() {
      page = $(this).data('page');
      dataLoad();
    });

    // Handle page change
    $('#btn-cari').click(function() {
      page = 1;
      dataLoad();
    });

    // Handle page change
    $('#btn-refresh').click(function() {
        dataLoad();
    });

    //untuk show modal form
    function showModalForm() {
      var fModalForm = new bootstrap.Modal(document.getElementById('modalForm'), {
          keyboard: false
      });
      fModalForm.show();
    }

    function formReset(){
      $('#form').trigger('reset');
      $('#form input[type="hidden"]').val('');
    }

    // Handle page change
    $('#btn-tambah').click(function() {
      formReset();
      showModalForm();    
    });

    //validasi dan save, jika id ada maka PUT/edit jika tidak ada maka POST/simpan baru
    $("#form").validate({
      submitHandler: function(form) {
        const id = $('#id').val();
        const type = (id === '') ? 'POST' : 'PUT';
        const url = (id === '') ? endpoint : endpoint + '/' + id;
        saveData(url, type, $(form).serialize(), function(response) {
          //jika berhasil
          toastr.success('operasi berhasil dilakukan!', 'berhasil');
          if(type=='POST'){
            $('#form').trigger('reset');
            $('#form input[type="hidden"]').val('');
          }
          dataLoad();
        });
      }
    });

    //ganti data
    $(document).on('click', '.btn-ganti', function() {
      const id = $(this).data('id');
      showDataById(endpoint, id, function(response) {
        formReset();
        showModalForm();
      });
    });

    //hapus data
    $(document).on('click', '.btn-hapus', function() {
      const id = $(this).data('id');
      deleteData(endpoint, id, function() {
          toastr.success('berhasil dilakukan!', 'berhasil');
          dataLoad();
      });
    });
  
  });

</script>
@endsection