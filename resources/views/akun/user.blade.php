@extends('akun.template')

@section('head')
  <title>Pengguna Aplikasi</title> 
  <style>
      .form-select {
        width: auto;
        min-width: 175px; /* Tetap tetapkan batas minimal */      
      }
      .no-underline {
        text-decoration: none;
        color: inherit;
      }      
  </style>
@endsection

@section('container')
<div class="page-inner">
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Pengguna</h3>
      <h6 class="op-7 mb-2">Pengelolaan pengguna aplikasi</h6>
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
            <h4 class="card-title">Data Pengguna</h4>
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
                      <th>Nama/ Jenis Kelamin/ Email/ HP</th>
                      <th>NIP/NIDN</th>
                      <th>Gol/ Pangkat</th>
                      <th>Unit Kerja</th>
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
<div class="modal fade" id="modalForm"  aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <form id="form">
              <input type="hidden" id="id" name="id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Unit Kerja</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-8">                    
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-lg-3">                    
                    <div class="form-group">
                      <label for="gelar_depan">Gelar Depan</label>
                      <input type="text" class="form-control" id="gelar_depan" name="gelar_depan" placeholder="gelar depan">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Nama</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="nama" required>
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="gelar_belakang">Gelar Belakang</label>
                      <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang" placeholder="gelar belakang">
                    </div>
                  </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="no_hp">Nomor HP/WA</label>
                      <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="nomor hp" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="jenis_kelamin">Jenis Kelamin</label><br>
                      <select class="form-control" data-dropdown-parent="body" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-pilih-</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="nidn">NIDN</label>
                      <input type="text" class="form-control" id="nidn" name="nidn" placeholder="nidn">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="nip">NIP</label>
                      <input type="text" class="form-control" id="nip" name="nip" placeholder="nip">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="unit_kerja_id">Unit Kerja</label>
                      <select class="form-control" data-dropdown-parent="body" id="unit_kerja_id" name="unit_kerja_id" required>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="pangkat_id">Gol/ Pangkat</label><br>
                      <select class="form-control" data-dropdown-parent="body" id="pangkat_id" name="pangkat_id" required>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">                  
                    <div class="form-group">
                      <label for="foto">Foto Profil</label>
                      <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                      <div class="col-lg-4 mt-2" id="display_foto"></div>

                    </div>
                  </div>

                  <div class="col-lg-6">                  
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="password">
                    </div>
                  </div>
                  <div class="col-lg-6">                  
                    <div class="form-group">
                      <label for="password_lagi">Ulangi Password</label>
                      <input type="password" class="form-control" id="password_lagi" name="password_lagi" placeholder="ulangi password">
                    </div>
                  </div>

                </div>

              </div>

              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Tutup</button>
              </div>
          </form>

      </div>
  </div>
</div>

<div class="modal fade" id="modalRoleUser"  aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="formRoleUser">
              <input type="hidden" id="user_id" name="user_id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Role User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-12">                    
                    <div class="form-group">
                      <label for="email">Pilih Role User</label>
                      <div id="role_user"></div>
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
  const endpoint = base_url+'/api/user';
  var page = 1;

  $(document).ready(function() {

    dataLoad();
    dataUnitKerja();
    function dataUnitKerja() {
      var url = base_url + '/api/unit-kerja?page=1&limit=1000';
      // console.log(url);
      fetchData(url, function(response) {
        renderSelect(response.data,'#unit_kerja_id', 'id', ['nama']);
      },false);
    }

    dataPangkatGol();
    function dataPangkatGol() {
      var url = base_url + '/api/pangkat?page=1&limit=1000';
      // console.log(url);
      fetchData(url, function(response) {
        renderSelect(response.data,'#pangkat_id', 'id', ['gol', 'nama']);
      },false);
    }

    //untuk render dari database
    function renderData(response) {
        const dataList = $('#data-list');
        const pagination = $('#pagination');
        const data=response.data.data;
        let no = (response.data.current_page - 1) * response.data.per_page + 1;
        dataList.empty();
        pagination.empty();
        if (data.length > 0) {
            $.each(data, function(index, dt) {
                const parent = dt.parent!=null?dt.parent.nama:"";
                const pilihan = dt.is_pilihan?"YA":"TIDAK";
                const pangkat_gol = (dt.identitas[0].pangkat_id)?dt.identitas[0].pangkat.gol+' ('+dt.identitas[0].pangkat.nama+')':"";
                const unit_kerja = (dt.identitas[0].unit_kerja_id)?dt.identitas[0].unit_kerja.nama:"";
                const nip = (dt.identitas[0].nip)?'NIP. '+dt.identitas[0].nip:"";
                const nidn = (dt.identitas[0].nidn)?'NIDN. '+dt.identitas[0].nidn:"";
                const tmpfoto=(dt.identitas[0].foto!='images/user-avatar.png')? base_url+'/storage/'+dt.identitas[0].foto:base_url+'/'+dt.identitas[0].foto;

                var user_role=`<span class="badge badge-danger">Tidak Ada Role</span>`;

                if(dt.user_role.length>0){
                  user_role=`<div>`;
                  $.each(dt.user_role, function(index, dp) {
                    user_role+=`<span class="badge badge-success">${dp.role.nama} <a href="javascript:;" class="no-underline btn-hapus-role" data-id="${dp.id}"><i class="fas fa-trash-alt"></i></a></span>`;
                  });
                  user_role+=`<div>`;
                }

                const row = `<tr>
                            <td>${no++}</td>
                            <td>
                              <div div style="display: flex; align-items: center;">
                                <img src="${tmpfoto}" height="75px" style="margin-right: 10px; border-radius: 50%;">
                                ${dt.name} (${dt.identitas[0].jenis_kelamin}) / ${dt.email}
                                HP. ${dt.identitas[0].no_hp}
                              </div>
                            </td>
                            <td>${nip+' '+nidn}</td>
                            <td>${pangkat_gol}</td>
                            <td>${unit_kerja} ${user_role}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item btn-tambah-akses" data-id="${dt.id}" href="javascript:;"><i class="fas fa-user-check"></i> Role User</a></li>
                                        <li><a class="dropdown-item btn-ganti" data-id="${dt.id}" href="javascript:;"><i class="far fa-edit"></i> Ganti</a></li>
                                        <li><a class="dropdown-item btn-hapus" data-id="${dt.id}" href="javascript:;"><i class="fas fa-trash-alt"></i></i> Hapus</a></li>
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
    function showModal(idForm) {
      var fModal = new bootstrap.Modal(document.getElementById(idForm), {
          keyboard: false
      });
      fModal.show();
    }

    function formReset(){
      const tmpfoto=base_url+'/images/user-avatar.png';
      $('#form').trigger('reset');
      $('#form input[type="hidden"]').val('');
      $('#pangkat_id').val(null);            
      $('#jenis_kelamin').val(null);            
      $('#unit_kerja_id').val(null);
      $('#display_foto').html(`<img src="${tmpfoto}" height="75px">`);
    }

    // Handle page change
    $('#btn-tambah').click(function() {
      formReset();      
      showModal('modalForm');    
    });

    //validasi dan save, jika id ada maka PUT/edit jika tidak ada maka POST/simpan baru
    $("#form").validate({
      rules: {
        password: {
          required: function() {
            return $('#id').val() === ''; // Password wajib jika id kosong
          },
          minlength: 8
        },
        password_lagi: {
            equalTo: "#password", // Password_lagi harus sama dengan password
            required: function() {
                return $('#password').val() !== ''; // Wajib jika password terisi
            }
        }        
      },      
      submitHandler: function(form) {
        const id = $('#id').val();
        const type = 'POST';
        const url = (id === '') ? endpoint : endpoint + '/' + id;

        var formData = new FormData(form);
        var fotoFile = $('#foto')[0].files[0]; // Asumsi ada input file dengan id #foto
        if (fotoFile) {
          formData.append('foto', fotoFile);
        }
        if (id !== '') {
          formData.append('_method', 'PUT');
        }

        saveData(url, type, formData, function(response) {
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
        const tmpfoto=(response.data.identitas[0].foto!='images/user-avatar.png')? base_url+'/storage/'+response.data.identitas[0].foto:base_url+'/'+response.data.identitas[0].foto;

        $('#id').val(response.data.id);
        $('#name').val(response.data.name);
        $('#email').val(response.data.email);
        
        $('#gelar_depan').val(response.data.identitas[0].gelar_depan);
        $('#gelar_belakang').val(response.data.identitas[0].gelar_belakang);
        $('#no_hp').val(response.data.identitas[0].no_hp);
        $('#nip').val(response.data.identitas[0].nip);
        $('#nidn').val(response.data.identitas[0].nidn);

        $('#display_foto').html(`<img src="${tmpfoto}" height="75px">`);

        $('#pangkat_id').val(response.data.identitas[0].pangkat_id).trigger('change');            
        $('#unit_kerja_id').val(response.data.identitas[0].unit_kerja_id).trigger('change');            
        $('#jenis_kelamin').val(response.data.identitas[0].jenis_kelamin).trigger('change');            
        showModal('modalForm');
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
  
    function renderRoleUser(user_id){
      showDataById(base_url+'/api/user-role-detail', user_id, function(response) {
        //membuat daftar role user dari respon api
        $('#role_user').empty();
        $.each(response.data.user_role, function(index, dt) {
          console.log(dt);
          var checked=(dt.role_user!==null)?'checked':'';
          var disabled=(checked=='checked')?'disabled':'';
          $('#role_user').append(`
            <div>
              <input class="form-check-input" type="checkbox" name="role_id[]" value="${dt.id}" id="role_${dt.id}" ${disabled} ${checked}>
              <label class="form-check-label" for="role_${dt.id}">
                  ${dt.nama}
              </label>
            </div>
          `);
        });        
      });
    }

    //hapus data role user
    $(document).on('click', '.btn-tambah-akses', function() {
      showModal('modalRoleUser');
      $('#user_id').val($(this).data('id'));
      var user_id = $('#user_id').val();
      renderRoleUser(user_id);
    });

    //hapus data role user
    $(document).on('click', '.btn-hapus-role', function() {
      const id = $(this).data('id');
      deleteData(base_url+'/api/user-role', id, function() {
          toastr.success('berhasil dilakukan!', 'berhasil');
          dataLoad();
      });
    });

    //validasi dan save, jika id ada maka PUT/edit jika tidak ada maka POST/simpan baru
    $("#formRoleUser").validate({
      submitHandler: function(form) {
        const user_id = $('#user_id').val();
        const type = 'POST';
        const url = base_url + '/api/user-role';
        let requests = []; // Array untuk menyimpan semua request AJAX

        // Mengumpulkan semua role_id yang diceklis, kecuali yang disabled
        $('input[name="role_id[]"]:checked').each(function () {
          if (!$(this).is(':disabled')) { 
            let postData = {
              user_id: user_id,
              role_id: $(this).val()
            };
            
            // Menambahkan request ke dalam array untuk pelacakan
            let request = saveData(url, type, postData, function(response) {
              console.log('berhasil');
            });
            
            requests.push(request); // Menyimpan request di array
          }
        });

        // Menunggu semua request selesai sebelum memanggil renderRoleUser
        if (requests.length > 0) {
          $.when.apply($, requests).done(function() {
            toastr.success('Operasi berhasil dilakukan!', 'Berhasil');
            renderRoleUser(user_id);
            dataLoad();
          });
        }

      }
    });


  });

</script>
@endsection