<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Pendaftaran Akun Permanen - IAIN Kendari</title>
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

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/css/kaiadmin.min.css" />

    <link href="{{ asset('plugins/toastr/build/toastr.min.css') }}" rel="stylesheet" />
    <style>
      .top {
        vertical-align: top;
      }

      .center {
        text-align: center; 
      }

      .left {
        text-align: left; 
      }

      .right {
        text-align: right; 
      }

    </style>
  </head>
  <body>
    <div class="wrapper d-flex justify-content-center align-items-center min-vh-100">
      <form id="myform">

      <div class="row w-100 justify-content-center">
        <div class="col-md-6 col-lg-5">
        
          <div class="card">
              <div class="card-header">
                <div class="d-flex flex-column align-items-center">
                  <img src="{{ asset('images/favicon.png')}}" height="100px">
                  <h4 class="mb-0">PERMANEN</h4>
                  <div style="font-size:10px">Apps LPPM IAIN Kendari</div>
                </div>
              </div>

              <div class="card-body">
     
                    <div class="row">
                      <div class="col-lg-8">                    
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                        </div>
                      </div>
                    </div>
    
    
                    <div class="row">
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
              <div class="card-footer" style="text-align: center">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
              </div>
          </div>

      </div>
    </div>
  </form>
</div>

  <!--   Core JS Files   -->
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/core/popper.min.js"></script>
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/kaiadmin.min.js"></script>
  <script src="{{ asset('plugins/toastr/build/toastr.min.js') }}"></script>
  <script src="{{ asset('js/myapp.js') }}"></script>
  <script>
    const base_url = "{{ url('/') }}";

    $(document).ready(function() {
      toastr.options.closeButton = true;

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

    });

  </script>
  </body>
</html>
