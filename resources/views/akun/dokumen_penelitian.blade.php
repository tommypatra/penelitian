@extends('akun.template')

@section('head')
  <title>Dokumen Penelitian</title> 
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
@endsection

@section('container')
<div class="page-inner">
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Dokumen Penelitian</h3>
      <h6 class="op-7 mb-2">Pengelolaan dokumen penelitian</h6>
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
        

        <div class="form-group">
          <div class="input-group">
            <input type="number" class="form-control" id="tahun" style="width: 25%;" placeholder="tahun">
            <select class="form-select" id="penelitian" name="penelitian" style="width: 75%;"></select>
          </div>
        </div>

        <div class="card-header">
          <div class="card-head-row card-tools-still-right">
            <h4 class="card-title">Data Dokumen Penelitian</h4>
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
                      <th>Jenis</th>
                      <th>Nama/ Type File</th>
                      <th>Wajib</th>
                      <th>Keterangan</th>
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
              <input type="hidden" id="penelitian_id" name="penelitian_id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Dokumen Penelitian</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-4">                    
                    <div class="form-group">
                      <label for="jenis">Jenis</label>
                      <select class="form-select" id="jenis" name="jenis" required>
                        <option value="syarat">syarat</option>
                        <option value="output">output</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-group">
                      <label for="nama">Nama Dokumen</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="nama" required>
                    </div>
                  </div>                        
                </div>

                <div class="row">
                  <div class="col-lg-4">                    
                    <div class="form-group">
                      <label for="tipe_file">Type File</label>
                      <select class="form-select" id="tipe_file" name="tipe_file" required>
                        <option value="pdf">PDF</option>
                        <option value="gambar">Gambar</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="is_wajib">Wajib</label>
                      <select class="form-select" id="is_wajib" name="is_wajib" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="keterangan">Keterangan</label>
                      <textarea class="form-control" rows="3" id="keterangan" name="keterangan" ></textarea>
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
  const endpoint = base_url+'/api/dokumen-penelitian';
  var page = 1;

  $(document).ready(function() {

    $('#tahun').val("{{ date('Y') }}");
    
    loadPenelitian();
    function loadPenelitian() {
      var tahun = $("#tahun").val();
      var url = base_url + '/api/penelitian?page=1&limit=1000&tahun='+tahun;
      $('#penelitian').empty();
      $('#penelitian').append(
        $('<option>', {value: '',text: '-Pilih-'})
      );

      fetchData(url, function(response) {
        if (response.data.data.length > 0) {
          $.each(response.data.data, function(index, dt) {
            $('#penelitian').append(
              $('<option>', {value: dt.id,text: `${dt.nama} (${dt.jenis_penelitian.nama})`})
            );
          });
        }
      });
    }

    $('#tahun').change(function(){
      loadPenelitian();
    });

    $('#penelitian').on('change', function() {
      dataLoad();
    });    

    function renderData(response) {
        const dataList = $('#data-list');
        const pagination = $('#pagination');
        const data=response.data.data;
        let no = (response.data.current_page - 1) * response.data.per_page + 1;
        dataList.empty();
        pagination.empty();
        if (data.length > 0) {
            $.each(data, function(index, dt) {
                const is_wajib = (dt.is_wajib)?"Ya":"Tidak";
                const row = `<tr>
                            <td>${no++}</td>
                            <td>${dt.jenis}</td>
                            <td>${dt.nama} (${dt.tipe_file})</td>
                            <td>${is_wajib}</td>
                            <td>${labelWeb(dt.keterangan)}</td>
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
      var vPenelitian_id = $('#penelitian').val();
      var url = endpoint + '?page=' + page + '&search=' + search + '&limit=' + vLimit+'&penelitian_id='+ vPenelitian_id;

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
      $('#penelitian_id').val($('#penelitian').val());
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
        $('#penelitian_id').val($('#penelitian').val());
        $('#id').val(response.data.id);
        $('#nama').val(response.data.nama);
        $('#keterangan').val(response.data.keterangan);
        $('#jenis').val(response.data.jenis);
        $('#tipe_file').val(response.data.tipe_file);
        $('#is_wajib').val(response.data.is_wajib);
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