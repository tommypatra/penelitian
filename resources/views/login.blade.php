<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login Permanen - IAIN Kendari</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{ asset('images/favicon.png') }}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>
    <script>
      const base_url = "{{ url('/') }}";
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/css/kaiadmin.min.css" />

    <link href="{{ asset('plugins/toastr/build/toastr.min.css') }}" rel="stylesheet" />

  </head>
  <body>
    <div class="wrapper d-flex justify-content-center align-items-center min-vh-100">

      <div class="row w-100 justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card">
            <form id="myform">
              <div class="card-header">
                <div class="d-flex flex-column align-items-center">
                  <img src="{{ asset('images/favicon.png')}}" height="100px">
                  <h4 class="mb-0">PERMANEN</h4>
                  <div style="font-size:10px">Apps LPPM IAIN Kendari</div>
                </div>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="required">Email Address</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" required minlength="8">
                    </div>
                  </div>

                </div>
              </div>
              <div class="card-footer">
                <button class="btn btn-success">Masuk</button>
                <div>Belum ada akun klik <a href="javascript:;" id="daftar-sekarang">Mendaftar Sekarang</a></div>
              </div>
          </form>
        </div>
      </div>


    </div>

    
  </div>


  <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('images/loading.gif') }}" height="150px" alt="Loading..." />
                <p>Sabar... lagi proses <span class='proses-berjalan'></span></p>
            </div>
        </div>
    </div>
  </div>

  <div class="modal fade" id="aksesModal" tabindex="-1" aria-labelledby="aksesModallLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
              <div id="daftar-akses"></div>
            </div>
        </div>
    </div>
  </div>

  <div class="modal fade" id="modalPendaftaran"  aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formPendaftaran">
  
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Pendaftaran Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
  
                <div class="modal-body">
  
                  <div class="row">
                    <div class="col-lg-8">                    
                      <div class="form-group">
                        <label for="femail">Email</label>
                        <input type="email" class="form-control" id="femail" name="email" placeholder="email" required>
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
                        <label for="jabatan">Jabatan</label><br>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="jabatan">
                      </div>
                    </div>
  
                    <div class="col-lg-12">                  
                      <div class="form-group">
                        <label for="foto">Foto Profil</label>
                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                        <div class="col-lg-4 mt-2" id="display_foto"></div>
  
                      </div>
                    </div>
  
                    <div class="col-lg-6">                  
                      <div class="form-group">
                        <label for="fpassword">Password</label>
                        <input type="password" class="form-control" id="fpassword" name="password" placeholder="password" required>
                      </div>
                    </div>
                    <div class="col-lg-6">                  
                      <div class="form-group">
                        <label for="fpassword_lagi">Ulangi Password</label>
                        <input type="password" class="form-control" id="fpassword_lagi" name="password_lagi" placeholder="ulangi password">
                      </div>
                    </div>
  
                  </div>
  
                </div>
  
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Tutup</button>
                </div>
            </form>
  
        </div>
    </div>
  </div>
  

  <!--   Core JS Files   -->
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/core/popper.min.js"></script>
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/kaiadmin.min.js"></script>


  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <script src="{{ asset('plugins/toastr/build/toastr.min.js') }}"></script>

  <script src="{{ asset('js/token.js') }}"></script>
  <script src="{{ asset('js/myapp.js') }}"></script>
  <script src="{{ asset('js/crud.js') }}"></script>

  <script>

  function logout() {
    $.ajax({
        url: base_url + '/api/logout',
        type: 'post',
        success: function(response) {
            console.log(respose);
        },
    });
    localStorage.removeItem('access_token');
    localStorage.removeItem('daftar_akses');
    localStorage.removeItem('role_akses');
    localStorage.removeItem('user_role_id');
    localStorage.removeItem('user_name');
    localStorage.removeItem('user_email');
    localStorage.removeItem('user_foto');
    window.location.replace(base_url + '/login');
  }

  //set akses bagi yang memiliki role lebih dari 1
  function setAkses(role_akses) {
    var access_token = localStorage.getItem('access_token');
    $.ajax({
        headers: {
            'Authorization': 'Bearer ' + access_token,
        },
        url: base_url + '/api/cek-akses/' + role_akses,
        type: 'get',
        success: function(response) {
          localStorage.setItem('role_akses', role_akses);
          localStorage.setItem('user_role_id', response.data.user_role_id);
          var goUrl = base_url+'/dashboard';
          window.location.replace(goUrl);
        },
    });
  }

  $(document).ready(function() {
    toastr.options.closeButton = true;
    //khusus saat laman login saja
    cekToken();
    function cekToken() {
      var role_akses = localStorage.getItem('role_akses');
      if (role_akses) {
        ajaxRequest(base_url + '/api/cek-akses/' + role_akses, 'GET', null, false,
          function(response) {
            var goUrl = `{{ url('/dashboard') }}`;
            window.location.replace(goUrl);
          },
          function(jqXHR, textStatus, errorThrown) {
            logout();
            console.error('Error:', textStatus, errorThrown);
          }
        );
      }
    }

    var myModalAkses = new bootstrap.Modal(document.getElementById('aksesModal'), {
      backdrop: 'static', // nda bisa klik diluar modal
      keyboard: false     // tombol esc tidak berfungsi untuk tutup modal  
    });

    var myModalPendaftaran = new bootstrap.Modal(document.getElementById('modalPendaftaran'), {
      backdrop: 'static', // nda bisa klik diluar modal
      keyboard: false     // tombol esc tidak berfungsi untuk tutup modal  
    });

    function showModalAkses(url) {
      $('#daftar-akses').html('');
      var daftar_akses = localStorage.getItem('daftar_akses');
      var user_name = localStorage.getItem('user_name');
      daftar_akses = JSON.parse(daftar_akses);
      if (daftar_akses && daftar_akses.length > 1) {
        var htmlOptions = `<div>Hi ${user_name}, pilih akses anda:</div>`;
        htmlOptions += '<ul>';
        daftar_akses.forEach(function(akses, index) {
          htmlOptions += `<li><a href="javascript:;" class="set-akses" data-role="${akses.role}" data-user_role_id="${akses.user_role_id}">${akses.role}</a></li>`;
        });
        htmlOptions += '</ul>';
        $('#daftar-akses').html(htmlOptions);
        myModalAkses.show();
      }else{
        var goUrl = url+'/dashboard';
        window.location.replace(goUrl);
      }
    }

    //untuk login
    $("#myform").validate({
        submitHandler: function(form) {
          ajaxRequest(base_url + '/api/auth-cek', 'post', $(form).serialize(), false,
            function(response) {
              localStorage.setItem('access_token', response.data.access_token);
              localStorage.setItem('daftar_akses', JSON.stringify(response.data.daftar_akses));
              localStorage.setItem('role_akses', response.data.role_akses);
              localStorage.setItem('user_role_id', response.data.user_role_id);
              localStorage.setItem('user_name', response.data.user.name);
              localStorage.setItem('user_email', response.data.user.email);
              localStorage.setItem('user_foto', response.data.user.identitas.foto);
              showModalAkses();
            }
          );
        }
    });

    $(document).on('click','.set-akses',function(){
      setAkses($(this).data('role'),$(this).data('user_role_id'));
    });

    // untuk pendaftaran akun

    $('#daftar-sekarang').click(function(){
      $('#formPendaftaran').trigger('reset');
      myModalPendaftaran.show();
    });


    dataUnitKerja();
    function dataUnitKerja() {
      var url = base_url + '/api/daftar-unit-kerja?page=1&limit=1000';
      // console.log(url);
      fetchData(url, function(response) {
        renderSelect(response.data,'#unit_kerja_id', 'id', ['nama']);
      },false);
    }

    dataPangkatGol();
    function dataPangkatGol() {
      var url = base_url + '/api/daftar-pangkat?page=1&limit=1000';
      // console.log(url);
      fetchData(url, function(response) {
        renderSelect(response.data,'#pangkat_id', 'id', ['gol', 'nama']);
      },false);
    }

    //untuk login
    $("#formPendaftaran").validate({
        rules: {
          password: {
            required: true,
            minlength: 8
          },
          password_lagi: {
              equalTo: "#fpassword", // Password_lagi harus sama dengan password
              required: function() {
                  return $('#fpassword').val() !== ''; // Wajib jika password terisi
              }
          }        
        },      
        submitHandler: function(form) {
          ajaxRequest(base_url + '/api/simpan-pendaftaran', 'post', $(form).serialize(), false,
            function(response) {
              $(form).trigger('reset');
              alert('akun berhasil terdaftar, silahkan login');
              myModalPendaftaran.hide(); // Close the modal
            }
          );
        }
    });    

  });

  </script>
  </body>
</html>
