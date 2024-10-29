@extends('akun.template')

@section('head')
  <title>Verifikasi</title> 
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
      <h3 class="fw-bold mb-3">Verifikasi</h3>
      <h6 class="op-7 mb-2">Pengelolaan verifikasi berkas</h6>
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
            <h4 class="card-title">Data Verifikasi Berkas</h4>
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
                      <th>Peneliti/ Waktu Update</th>
                      <th>Penelitian/ Tahun</th>
                      <th>Judul</th>
                      <th>Verifikasi</th>
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
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Verifikasi</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-12">

                    <div class="form-group">                      
                      <div class="card-list">
                        <h5 id="modal-penelitian">Penelitian</h5>
                        <div class="item-list">
                          <div class="avatar">
                            <img src="{{ asset('images/user-avatar.png') }}" id="modal-foto" class="avatar-img rounded-circle">
                          </div>
                          <div class="info-user ms-3">
                            <div class="username" id="modal-nama">Nama Peneliti</div>
                            <div class="status" >NIDN. <span id="modal-nidn"></span></div>
                            <div class="status" id="modal-email"></div>
                          </div>
                        </div>
                        <h4>Judul Penelitian : "<span id="modal-judul-penelitian"></span>"</h4>
                        <span class="badge rounded-pill bg-primary" id="modal-waktu-update"></span>
                      </div>               
                    </div>
                    
                    <div class="form-group">
                      <!-- Nav Tabs -->
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="file-upload-tab" data-bs-toggle="tab" data-bs-target="#file-upload" type="button" role="tab" aria-controls="file-upload" aria-selected="true">Verifikasi File Upload</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="kesimpulan-tab" data-bs-toggle="tab" data-bs-target="#kesimpulan" type="button" role="tab" aria-controls="kesimpulan" aria-selected="false">Kesimpulan</button>
                        </li>
                      </ul>

                      <!-- Tab Content -->
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="file-upload" role="tabpanel" aria-labelledby="file-upload-tab">
                            <p id="modal-daftar-file"></p>
                        </div>
                        <div class="tab-pane fade p-3" id="kesimpulan" role="tabpanel" aria-labelledby="kesimpulan-tab">
                          <form id="form">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="admin_role_id" name="admin_role_id">

                            <div class="form-group">
                              <label for="is_valid">Status Verifikasi</label>
                              <select class="form-select" id="is_valid" name="is_valid" required>
                                <option value="1">Diterima</option>
                                <option value="0">Ditolak</option>
                              </select>
                            </div>
        
                            <div class="form-group">
                              <label for="catatan">Catatan Verifikasi</label>
                              <textarea rows="3" class="form-control" id="catatan" name="catatan" placeholder="catatan verifikator" ></textarea>
                              <button type="submit" class="btn btn-primary mt-3"><i class="far fa-save"></i> Simpan</button>
                            </div>
                          </form>


                        </div>
                      </div>                      
                    </div>

                  </div>
                </div>

              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-door-closed"></i> Tutup</button>
              </div>

      </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/crud.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>

<script>
  const endpoint = base_url+'/api/peneliti';
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
                const identitas = dt.user_role.user.identitas[0];
                const foto = base_url+'/'+identitas.foto;
                const row = `<tr>
                            <td>${no++}</td>
                            <td>
                              <div class="card-list py-4">
                                <div class="item-list">
                                  <div class="avatar">
                                    <img src="${foto}" class="avatar-img rounded-circle">
                                  </div>
                                  <div class="info-user ms-3">
                                    <div class="username">${dt.user_role.user.name}</div>
                                    <div class="status">NIDN. ${identitas.nidn}</div>
                                  </div>
                                </div>
                              <span class="badge rounded-pill bg-primary">${timeAgo(dt.updated_at)}</span>
                              </div>
                            </td>
                            <td>${dt.penelitian.tahun} - ${dt.penelitian.nama}</td>
                            <td>
                                <div>"${dt.judul}"</div> 
                            </td>
                            <td>${labelWeb(dt.catatan)}</td>
                            <td>                        
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item btn-verifikasi" data-id="${dt.id}" href="javascript:;"><i class="fas fa-tasks"></i> Verifikasi</a></li>
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
      var url = base_url + '/api/peneliti?page=' + page + '&search=' + search + '&limit=' + vLimit +'&tahap=verifikasi';

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

    //validasi dan save, jika id ada maka PUT/edit jika tidak ada maka POST/simpan baru
    $("#form").validate({
      submitHandler: function(form,e) {
        e.preventDefault();
        const id = $('#id').val();
        const type = 'PUT';
        const url = base_url+'/api/verifikasi-peneliti/' + id;

        if(confirm('Apakah anda yakin?'))
            saveData(url, type, $(form).serialize(), function(response) {
              //jika berhasil
              toastr.success('operasi berhasil dilakukan!', 'berhasil');
              dataLoad();
            });
      }
    });

    //ganti data
    $(document).on('click', '.btn-verifikasi', function() {
      const id = $(this).data('id');
      showDataById(endpoint, id, function(response) {
        formReset();
        const peneliti=response.data.user_role.user.identitas[0];
        const penelitian=response.data.penelitian;
        const user=response.data.user_role.user;
        const dokumen=response.data.penelitian.dokumen;
        // console.log(peneliti);
        $('#id').val(response.data.id);
        $('#admin_role_id').val(user_role_id);
        $('#modal-penelitian').text(penelitian.tahun+' - '+penelitian.nama);
        $('#modal-nama').text(user.name);
        $('#modal-email').text(user.email);
        $('#modal-nidn').text(peneliti.nidn);
        $('#modal-foto').attr('href',base_url+'/'+peneliti.foto);
        $('#modal-judul-penelitian').text(response.data.judul);
        $('#modal-waktu-update').text(timeAgo(response.data.updated_at));
        renderDokumen(dokumen,'#modal-daftar-file','syarat')

        showModalForm();
      });
    });

    function renderDokumen(dokumen,elementId,kategori){
      const ul = $('<ul class="dokumen"></ul>');
      $(elementId).empty();
      if (dokumen.length > 0) {
          $.each(dokumen, function(index, dt) {

              if(dt.jenis==kategori){
                //untuk batasi file yang diplih berdasarkan konfigurasi               
                let acceptType = '';
                let is_wajib = (dt.is_wajib)?"*":"";
                if (dt.tipe_file === 'pdf') {
                    acceptType = 'application/pdf';
                } else if (dt.tipe_file === 'gambar') {
                    acceptType = 'image/*'; 
                }

                //untuk list file yang sudah di upload               
                const ul_file = $('<ul class="file-upload" style="list-style-type: none; padding-left: 0;"></ul>');
                if(dt.dokumen_peneliti.length>0){
                  $.each(dt.dokumen_peneliti, function(index_file, dt_file) {
                    const li_file = $(`<li class="daftar-file">
                                          <span class="badge bg-success">                                             
                                            ${dt.nama}-${index_file+1}
                                          </span>  
                                          <span style="font-size:12px">${timeAgo(dt_file.created_at)}</span>
                                          <a href="${base_url+'/storage/'+dt_file.path}" target="_blank"><i class="fas fa-file-download"></i></a>
                                        </li>`);
                    ul_file.append(li_file);
                  });
                } 

                //membuat list untuk dokumen               
                const li = $(`<li class="daftar-dokumen" data-is_wajib="${dt.is_wajib}" data-jumlah_dokumen_upload="${dt.dokumen_peneliti.length}">
                                <span class="nama_dokumen">${dt.nama} (${dt.tipe_file})</span> ${is_wajib}
                                <div class="text-muted" style="font-style:italic;">${dt.keterangan}</div>
                                <div class="ul_file"></div>                                
                              </li>`);
                li.find('.ul_file').append(ul_file);
                ul.append(li);
              }
          });
      } else {
          ul.append('<li>Tidak ada dokumen tersedia</li>');
      }
      $(elementId).append(ul);
    }

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