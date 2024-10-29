@extends('akun.template')

@section('head')
  <title>Penelitian Dosen</title> 
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
      <h3 class="fw-bold mb-3">Penelitian Dosen</h3>
      <h6 class="op-7 mb-2">Pengelolaan penelitian dosen</h6>
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

  <div class="row justify-content-center align-items-center mb-1" id="data-list">
  </div>

  <div class="row">
              <!-- Pagination -->
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center" id="pagination"></ul>
              </nav>
  </div>
@endsection


@section('modal')
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog ">
      <div class="modal-content">
          <form id="form">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="user_role_id" name="user_role_id">
            <input type="hidden" id="penelitian_id" name="penelitian_id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Pendaftaran Penelitian</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-12">
                    
                    <div class="form-group">
                      <label for="judul">Judul</label>
                      <textarea rows="3" type="text" class="form-control" id="judul" name="judul" required></textarea>
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
  const endpoint = base_url+'/api/peneliti';
  var page = 1;

  $(document).ready(function() {

    dataLoad();

    function daftarDokumen(dokumen){
      var syarat = [];
      var output = [];

      $.each(dokumen, function(index, dt) {
        if (dt.jenis == 'syarat') {
          syarat.push(dt.nama);
        } else if (dt.jenis == 'output') {
          output.push(dt.nama);
        }
      });

      return {
        syarat: syarat.length > 0 ? syarat.join(', ') : 'Tidak ada',
        output: output.length > 0 ? output.join(', ') : 'Tidak ada'
      };    
    }

    function renderData(response) {
        const dataList = $('#data-list');
        const pagination = $('#pagination');
        const data=response.data.data;
        let no = (response.data.current_page - 1) * response.data.per_page + 1;
        dataList.empty();
        pagination.empty();
        let jumlah_data = data.length;
        if (jumlah_data > 0) {
            $.each(data, function(index, dt) {
                const dokumen = daftarDokumen(dt.dokumen);
                let bgColor='';
                let btnColor='btn-primary';
                if(index==1){
                  bgColor='card-primary';
                  btnColor='btn-light';
                }

                let btnDef=`<button class="btn ${btnColor} w-100 btn-daftar" data-id="${dt.id}">
                              <b>Daftar Sekarang</b>
                            </button>`;

                if(dt.peneliti.length>0){
                  btnDef=`<button class="btn btn-success w-100 btn-timeline" data-id="${dt.peneliti[0].id}">
                            <b>Timeline Penelitian</b>
                          </button>
                          <button class="btn btn-warning w-100 btn-hapus mt-2" data-id="${dt.peneliti[0].id}">
                            <b>Batalkan!</b>
                          </button>`;
                }

                const row = `<div class="col-md-4">
                              <div class="card card-pricing ${bgColor}">
                                <div class="card-header">
                                  <h4 class="card-title">${dt.nama}</h4>
                                </div>
                                <div class="card-body">
                                  <ul class="specification-list">
                                    <li>
                                      <span class="name-specification">Tahun</span>
                                      <span class="status-specification">${dt.tahun}</span>
                                    </li>
                                    <li>
                                      <span class="name-specification">Jenis</span>
                                      <span class="status-specification">${dt.jenis_penelitian.nama}</span>
                                    </li>
                                    <li>
                                      <span class="name-specification">Jadwal</span>
                                      <span class="status-specification">${dt.daftar_mulai} sd ${dt.daftar_selesai}</span>
                                    </li>
                                  </ul>


                                  <div>
                                    <h5>Dokumen Pendaftaran</h5> 
                                    <small class="status-specification">${labelWeb(dokumen.syarat)}</small>
                                  </div>
                                  <div>
                                    <h5>Output</h5>
                                    <small class="status-specification">${labelWeb(dokumen.output)}</small>
                                  </div>
                                </div>
                                <div class="card-footer">
                                  ${btnDef}
                                </div>
                              </div>
                            </div>`;
                dataList.append(row);
            });
            renderPagination(response.data, pagination);
        }
    }    

    function dataLoad() {
      var search = $('#search-input').val();
      var url = base_url + '/api/daftar-jadwal-penelitian?page=' + page + '&search=' + search + '&limit=3&user_role_id='+user_role_id;

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
      $('#user_role_id').val($('#user_role_id').val());
      $('#penelitian_id').val($('#penelitian').val());
    }

    // Handle page change
    $('#btn-refresh').click(function() {
        dataLoad();
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

    // Handle daftar
    $(document).on('click', '.btn-daftar', function() {
      $('#penelitian_id').val($(this).data('id'));
      $('#user_role_id').val(user_role_id);
      showModalForm();
    });

    // Handle daftar
    $(document).on('click', '.btn-timeline', function() {

      window.location.href = base_url+'/timeline-penelitan/'+$(this).data('id');
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