<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Peneltian - IAIN Kendari</title>
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
                <div>Belum ada akun klik <a href="#">Mendaftar Sekarang</a></div>
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
          var goUrl = `{{ url('/dashboard') }}`;
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
              localStorage.setItem('user_foto', response.data.user.identitas[0].foto);
              showModalAkses();
            }
          );
        }
    });

    $(document).on('click','.set-akses',function(){
      setAkses($(this).data('role'),$(this).data('user_role_id'));
    });

  });

  </script>
  </body>
</html>
