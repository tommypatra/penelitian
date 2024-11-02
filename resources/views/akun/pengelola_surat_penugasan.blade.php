@extends('akun.template')

@section('head')
  <title>Pengelola - Surat Penugasan</title> 
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
      <h3 class="fw-bold mb-3">Pengelola - Surat Penugasan</h3>
      <h6 class="op-7 mb-2">Pengelolaan surat penugasan</h6>
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
            <h4 class="card-title">Data Surat Penugasan</h4>
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

                  <div class="btn-group mb-2" role="group" aria-label="Basic radio toggle button group">               
                    <input type="radio" class="btn-check" name="btnaction" id="btnaction1" autocomplete="off" value="proses" checked>
                    <label class="btn btn-outline-primary" for="btnaction1">Proses</label>
  
                    <input type="radio" class="btn-check" name="btnaction" id="btnaction2" autocomplete="off" value="penomoran">
                    <label class="btn btn-outline-primary" for="btnaction2">Penomoran</label>
                  
                    <input type="radio" class="btn-check" name="btnaction" id="btnaction3" autocomplete="off" value="selesai">
                    <label class="btn btn-outline-primary" for="btnaction3">Selesai</label>
                  </div>

                  <table class="table table-hover table-head-bg-primary">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nomor/ Tanggal Surat</th>
                      <th>Judul</th>
                      <th>Peneliti/ Judul</th>
                      <th>Persetujuan Ketua</th>
                      <th>Aksi</th>
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
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog ">
      <div class="modal-content">
          <form id="form">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="ketua_lppm_role_id" name="ketua_lppm_role_id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Persetujuan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-12">
                    
                    <div class="form-group">
                      <label for="is_disetujui">Status Persetujuan</label>
                      <select class="form-select" id="is_disetujui" name="is_disetujui" required>
                        <option value="1">Disetujui</option>
                        <option value="0">Ditolak</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="catatan">Keterangan</label>
                      <textarea rows="3" class="form-control" id="catatan" name="catatan" placeholder="keterangan" ></textarea>
                    </div>

                  </div>
                </div>

              </div>

              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-door-closed"></i> Tutup</button>
              </div>
          </form>

      </div>
  </div>
</div>

<div class="modal fade" id="modalPenomoran" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog ">
      <div class="modal-content">
          <form id="formPenomoran">
            <input type="hidden" id="id" name="id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Penomoran Surat</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-12">
                    
                    <div class="form-group">
                      <label for="nomor_surat">Nomor Surat</label>
                      <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="nomor_surat" required>
                      <div ><span style="font-size:12px;font-style:italic" id="contoh-template-surat">contoh : </span> <i class="far fa-copy" id="auto-format-nomor"></i></div> 
                      
                    </div>

                    <div class="form-group">
                      <label for="tanggal_surat">Keterangan</label>
                      <input type="text" class="form-control datepicker" id="tanggal_surat" name="tanggal_surat" placeholder="tanggal" required>
                    </div>

                  </div>
                </div>

              </div>

              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-door-closed"></i> Tutup</button>
              </div>
          </form>

      </div>
  </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/crud.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>

<script>
  const endpoint = base_url+'/api/surat-penugasan';
  var page = 1;
  var template_nomor = `{{ ".../In.23/L.I/TL.03/" . date('m') . "/" . date('Y') }}`;

  $(document).ready(function() {
    $('#contoh-template-surat').text(template_nomor);
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
                const penelitian = dt.peneliti.penelitian;
                const user = dt.peneliti.user_role.user;
                const identitas = dt.peneliti.user_role.user.identitas;
                const foto = base_url+'/'+identitas.foto;
                var persetujuan = "";
                if(dt.is_disetujui==null)
                  persetujuan = `<span class="badge rounded-pill bg-primary">Proses Persetujuan</span>`;
                else if(dt.is_disetujui)
                  persetujuan = `<span class="badge rounded-pill bg-success">Disetujui</span>`;
                else if(!dt.is_disetujui)
                  persetujuan = `<span class="badge rounded-pill bg-danger">Tidak disetujui</span>`;

                if(dt.catatan)
                  persetujuan+=`<div>${dt.catatan}</div>`;

                const menu_ketua_lppm=(role_akses=='Ketua')?`<li><a class="dropdown-item btn-persetujuan" data-id="${dt.id}" href="javascript:;"><i class="fas fa-check-double"></i> Persetujuan Ketua LPPM</a></li>`:"";  
                const menu_cetak=(dt.is_disetujui)?`<li><a class="dropdown-item btn-cetak" href="${base_url}/cetak-surat-penugasan/${dt.id}" target="_blank"><i class="fas fa-print"></i> Cetak Surat Persertujuan</a></li>`:"";  
                const menu_pengelola=(role_akses=='JFU')?`<li><a class="dropdown-item btn-penomoran" data-id="${dt.id}" data-tanggal_surat="${dt.tanggal_surat}" data-nomor_surat="${dt.nomor_surat}"href="javascript:;"><i class="far fa-file-alt"></i> Penomoran Surat</a></li>`:"";  
                
                const row = `<tr>
                            <td>${no++}</td>
                            <td>
                              ${labelWeb(dt.nomor_surat)}
                              <div style="font-size:11px;">${dt.tanggal_surat}</div>
                              <span class="badge rounded-pill bg-primary">${timeAgo(dt.updated_at)}</span>
                            </td>
                            <td>
                              ${dt.peneliti.judul}
                              <div style="font-size:11px;">${penelitian.tahun} - ${penelitian.nama}</div>
                            </td>
                            <td>
                              <div class="card-list py-4">
                                <div class="item-list">
                                  <div class="avatar">
                                    <img src="${foto}" class="avatar-img rounded-circle">
                                  </div>
                                  <div class="info-user ms-3">
                                    <div class="username">${user.name}</div>
                                    <div class="status">NIDN. ${identitas.nidn}</div>
                                  </div>
                                </div>
                              </div>


                            </td>
                            <td>${persetujuan}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <ul class="dropdown-menu">
                                        ${menu_cetak}
                                        ${menu_ketua_lppm}
                                        ${menu_pengelola}                                        
                                        <li><a class="dropdown-item btn-detail" data-id="${dt.id}" href="javascript:;"><i class="fas fa-info-circle"></i> Detail</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>`;
                dataList.append(row);
            });
            renderPagination(response.data, pagination);
        }
    }    

    function dataLoad() {
      var search = $('#search-input').val();
      let action = $('input[name="btnaction"]:checked').val();
      //action belum menunggu selesai

      var url = endpoint + '?page=' + page + '&search=' + search + '&limit=' + vLimit+'&status='+action;

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
    function showModalForm(elementId) {
      var fModalForm = new bootstrap.Modal(document.getElementById(elementId), {
          keyboard: false
      });
      fModalForm.show();
    }

    function formReset(){
      $('#form').trigger('reset');
      $('#form input[type="hidden"]').val('');

      $('#formPenomoran').trigger('reset');
      $('#formPenomoran input[type="hidden"]').val('');
    }

    //validasi dan save, jika id ada maka PUT/edit jika tidak ada maka POST/simpan baru
    $("#form").validate({
      submitHandler: function(form) {
        const id = $('#id').val();
        const type = 'PUT';
        const url = base_url + '/api/persetujuan-surat-penugasan/' + id;
        saveData(url, type, $(form).serialize(), function(response) {
          //jika berhasil
          toastr.success('operasi berhasil dilakukan!', 'berhasil');
          // formReset();
          dataLoad();
        });
      }
    });

    //validasi dan save, jika id ada maka PUT/edit jika tidak ada maka POST/simpan baru
    $("#formPenomoran").validate({
      submitHandler: function(form) {
        const id = $('#id').val();
        const type = 'PUT';
        const url = base_url + '/api/penomoran-surat-penugasan/' + id;
        saveData(url, type, $(form).serialize(), function(response) {
          toastr.success('operasi berhasil dilakukan!', 'berhasil');
          // formReset();
          dataLoad();
        });
      }
    });    

    //persetujuan
    $(document).on('click', '.btn-persetujuan', function() {
      formReset();
      $('#id').val($(this).data('id'));
      $('#ketua_lppm_role_id').val(user_role_id);
      showModalForm('modalForm');    
    });

    //penomoran
    $(document).on('click', '.btn-penomoran', function() {
      formReset();
      $('#id').val($(this).data('id'));
      $('#nomor_surat').val($(this).data('nomor_surat'));
      $('#tanggal_surat').val($(this).data('tanggal_surat'));
      showModalForm('modalPenomoran');    
    });

    $('input[name="btnaction"]').change(function() {
      dataLoad();
    });
    
    $('#auto-format-nomor').click(function(){
      $('#nomor_surat').val(template_nomor);
    })
  
  });

</script>
@endsection