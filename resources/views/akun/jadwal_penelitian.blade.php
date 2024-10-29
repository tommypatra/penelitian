@extends('akun.template')

@section('head')
  <title>Jadwal Penelitian</title> 
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
@endsection

@section('container')
<div class="page-inner">
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Jadwal Penelitian</h3>
      <h6 class="op-7 mb-2">Pengelolaan jadwal penelitian</h6>
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
            <h4 class="card-title">Data Jadwal Penelitian</h4>
            <div class="card-tools">
              <a href="#" class="btn btn-primary btn-round" id="btn-tambah"><i class="fas fa-plus"></i></a>
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
                      <th>Penelitian (Tahun)</th>
                      <th>Jenis Penelitian</th>
                      <th>Jadwal Pendaftaran</th>
                      <th>Buka Jadwal</th>
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
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <form id="form">
              <input type="hidden" id="id" name="id">
              <input type="hidden" id="user_role_id" name="user_role_id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Jadwal Penelitian</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-4">                    
                    <div class="form-group">
                      <label for="tahun">Tahun</label>
                      <input type="number" class="form-control" id="tahun" name="tahun" placeholder="tahun" value="{{ date('Y') }}" required>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-group">
                      <label for="nama">Nama Kegiatan</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="nama" required>
                    </div>
                  </div>
                  
                
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="jenis_penelitian_id">Jenis Penelitian</label>
                      <select class="form-select" id="jenis_penelitian_id" name="jenis_penelitian_id" ></select>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-lg-4">                    
                    <div class="form-group">
                      <label for="daftar_mulai">Pendaftaran Mulai</label>
                      <input type="text" class="form-control datepicker" id="daftar_mulai" name="daftar_mulai" placeholder="tanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="daftar_selesai">Pendaftaran Selesai</label>
                      <input type="text" class="form-control datepicker" id="daftar_selesai" name="daftar_selesai" placeholder="tanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="daftar_terbuka">Buka Pendaftaran</label>
                      <select class="form-select" id="daftar_terbuka" name="daftar_terbuka" >
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                      </select>
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
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

<script src="{{ asset('js/crud.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>

<script>
  const endpoint = base_url+'/api/penelitian';
  var page = 1;

  $(document).ready(function() {

    dataLoad();

    $(".datepicker").datepicker({
      dateFormat: "yy-mm-dd"
    });

    loadDataPenelitian();
    function loadDataPenelitian() {
      var url = base_url + '/api/jenis-penelitian?page=1&limit=1000';
      $('#jenis_penelitian_id').empty();
      fetchData(url, function(response) {
        if (response.data.data.length > 0) {
          $.each(response.data.data, function(index, dt) {
            $('#jenis_penelitian_id').append(
              $('<option>', {value: dt.id,text: dt.nama})
            );
          });
        } else {
          $('#jenis_penelitian_id').append(
            $('<option>', {value: '',text: 'Tidak ada data tersedia'})
          );
        }
      });
    }

    function renderData(response) {
        const dataList = $('#data-list');
        const pagination = $('#pagination');
        const data=response.data.data;
        let no = (response.data.current_page - 1) * response.data.per_page + 1;
        dataList.empty();
        pagination.empty();
        if (data.length > 0) {
            $.each(data, function(index, dt) {
                const terbuka = (dt.daftar_terbuka)?"Terbuka":"Tertutup";
                const row = `<tr>
                            <td>${no++}</td>
                            <td>${dt.nama} (${dt.tahun})</td>
                            <td>${dt.jenis_penelitian.nama}</td>
                            <td>${dt.daftar_mulai} sd ${dt.daftar_selesai}</td>
                            <td>${terbuka}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item btn-ganti" data-id="${dt.id}" href="javascript:;"><i class="far fa-edit"></i> Ganti</a></li>
                                        <li><a class="dropdown-item btn-hapus" data-id="${dt.id}" href="javascript:;"><i class="fas fa-trash-alt"></i> Hapus</a></li>
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
      $('#user_role_id').val(user_role_id);
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
            formReset();
          }
          dataLoad();
        });
      }
    });

    //ganti data
    $(document).on('click', '.btn-ganti', function() {
      const id = $(this).data('id');
      showDataById(endpoint, id, function(response) {
        $('#id').val(response.data.id);
        $('#user_role_id').val(user_role_id);
        $('#nama').val(response.data.nama);
        $('#tahun').val(response.data.tahun);
        $('#jenis_penelitian_id').val(response.data.jenis_penelitian_id);
        $('#daftar_mulai').val(response.data.daftar_mulai);
        $('#daftar_mulai').val(response.data.daftar_mulai);
        $('#daftar_terbuka').val(response.data.daftar_terbuka);
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