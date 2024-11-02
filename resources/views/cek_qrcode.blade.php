<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Cer Barcode Permanen - IAIN Kendari</title>
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
                  <div class="col-md-12" style="text-align: center">
                    <h3><i class="fas fa-key"></i> QRCode eSign Tervalidasi</h3>
                    
                    <table style="text-align: left; margin-top:15px; margin-bottom:15px;">
                      <tr>
                        <td class="top" width="35%">Nomor Surat</td>
                        <td class="top center" width="3%">:</td>
                        <td class="top nomor_surat"></td>
                      </tr>
                      <tr>
                        <td class="top">Tanggal Surat</td>
                        <td class="top center">:</td>
                        <td class="top tanggal_surat"></td>
                      </tr>
                      <tr>
                        <td class="top">Perihal</td>
                        <td class="top center">:</td>
                        <td class="top" style="font-weight: bold;">Surat Keterangan Penelitian</td>
                      </tr>
                      <tr>
                        <td class="top">Judul Penelitian</td>
                        <td class="top center">:</td>
                        <td class="top peneliti_judul"></td>
                      </tr>
                      <tr>
                        <td class="top">Nama Penelitian</td>
                        <td class="top center">:</td>
                        <td  class="top peneliti_nama"></td>
                      </tr>
                    </table>
                    
                    <div style="font-style: italic;font-weight:bold;">Dokumen ini ditanda tangani secara digital oleh <span class="ttd_nama"></span> sebagai <span class="ttd_jabatan"></span></div>
                  </div>
                </div>
              </div>
              <div class="card-footer" style="text-align: center">
                <div class="btn btn-success" id="cetak-surat"><i class="fas fa-print"></i> Cetak Surat</div>
              </div>
          </form>
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
  <script src="{{ asset('plugins/toastr/build/toastr.min.js') }}"></script>
  <script src="{{ asset('js/myapp.js') }}"></script>
  <script>
    const base_url = "{{ url('/') }}";
    const id = {{ $id }};

    $(document).ready(function() {
      toastr.options.closeButton = true;

      suratPenugasan();
      function suratPenugasan() {
        $.ajax({
            url: base_url + '/api/cek-qrcode/' + id,
            type: 'GET', 
            data: null, 
            success: function(response) {
              const surat=response.data;
              const peneliti=surat.peneliti.user_role.user;
              const ketua_lppm=surat.ketua_lppm_role.user;

              const qr_link = `${base_url}/cek-qrcode/${surat.id}`;
              const qr_ttd = `eSing ${ketua_lppm.name} for ${surat.nomor_surat} ${qr_link}`;


              const ketua_nama = `${labelWeb(ketua_lppm.identitas.gelar_depan)} ${ketua_lppm.name} ${labelWeb(ketua_lppm.identitas.gelar_belakang)}`;
              const peneliti_nama = `${labelWeb(peneliti.identitas.gelar_depan)} ${peneliti.name} ${labelWeb(peneliti.identitas.gelar_belakang)}`;
              // console.log(peneliti.identitas);

              $('.link_cek').attr('href',qr_link);
              $('.link_cek').text(qr_link);

              $('title').text(`Verifikasi Suket Penelitian - ${peneliti.name}`);

              $('.tanggal_surat').text(labelTanggal(surat.tanggal_surat));
              $('.nomor_surat').text(surat.nomor_surat);
              $('.ttd_nama').text(ketua_nama.trim());
              $('.ttd_nip').text(`${ketua_lppm.identitas.nip}`);
              $('.ttd_jabatan').text(`${ketua_lppm.identitas.jabatan}`);

              $('.peneliti_judul').text(`${surat.peneliti.judul}`);
              $('.peneliti_nama').text(peneliti_nama.trim());
              $('.peneliti_nip').text(`${peneliti.identitas.nip}`);
            },
            error: function(xhr) {
              alert('Tidak ditemukan');
              window.location.href = base_url;
            }
        });        
      }      

      $('#cetak-surat').click(function(e){
        var url=base_url+'/cetak-surat-penugasan/'+id;
        // console.log(url);
        window.location.href = url;
      });

    });

  </script>
  </body>
</html>
