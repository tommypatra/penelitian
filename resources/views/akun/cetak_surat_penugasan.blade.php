<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{ asset('images/favicon.png') }}"
      type="image/x-icon"
    />

    <title>Suket Penelitian</title>
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

    <style>
      /* Mengatur font seluruh halaman menjadi Arial */
      body, html {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
          height: 100%;
          font-size: 11pt;
      }
      .cetak {
          align-items: center;
          width: 100%;
      }

      /* Footer */
      .footer {

          width: 100%;
                  
          text-align: left;
          font-size: 9pt;
          font-style: italic;
          color: #555;
          margin-top: 20px;
          padding-top: 10px;
          border-top: 1px solid #ddd;
      }

      .kop-text {
        text-align: center;
      }

      .kop-contact {
          font-weight: normal;
          font-size:9pt;
      }

      .top {
        vertical-align: top;
      }

      .left {
        text-align: left; 
      }

      .right {
        text-align: right; 
      }

      .w-15 {
          width: 100px;
      }

      .w-1 {
          width: 10px;
      }

      .w-5 {
          width: 5%;
      }

      .center {
        text-align: center; 
      }


      /* Gaya khusus untuk mode cetak */
      @media print {
          @page {
              margin-top: 1cm;
              margin-left: 2.5cm;
              margin-right: 2cm;
              margin-bottom: 2cm;
          }
          .footer {

            width: 100%;
            position: absolute;
            bottom: 0;        
          }
      }
    </style>
</head>
<body>
    <table class="cetak" cellpadding="0" cellspacing="0">
      <tr>
        <td class="kop-logo">
          <img src="{{ asset('images/favicon.png')}}" height="80px" alt="Logo">
        </td>
        <td class="kop-text">
          <span style="font-weight:bold;font-size:16pt;">KEMENTERIAN AGAMA RI</span><br>
          <span style="font-weight:bold;font-size:14pt;">INSTITUT AGAMA ISLAM NEGERI KENDARI</span><br>
          <span style="font-weight:bold;font-size:12pt;">LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</span><br>
          <span class="kop-contact">
              Jl. Sultan Qaimuddin No. 17 Baruga Kendari Sulawesi Tenggara<br>
              Telp. (0401) 3192081, Fax. (0401) 3193710<br>
              Email: lppm@iainkendari.ac.id, Website: lppm.iainkendari.ac.id
          </span>
        </td>
      </tr>
      <tr>
        <td colspan="2"><hr></td>
      </tr>
    </table>

    <table class="cetak" cellpadding="0" cellspacing="0">
      <tr>
          <td class="top center">
            <span style="font-weight:bold;">SURAT KETERANGAN PENELITIAN</span><br>
            Nomor : <span class="nomor_surat"></span>
          </td>
      </tr>
    </table>
    
    <div style="margin-top:15px;">
      Yang bertanda tangan di bawah ini :
      <table class="cetak" cellpadding="0" cellspacing="0">
        <tr>
            <td class="top left w-15">Nama</td>
            <td class="top center w-1">:</td>
            <td class="top left ttd_nama"></td>
        </tr>
        <tr>
          <td class="top left">NIP</td>
          <td class="top center w-1">:</td>
          <td class="top left ttd_nip"></td>
        </tr>
        <tr>
          <td class="top left">Pangkat/Gol.</td>
          <td class="top center w-1">:</td>
          <td class="top left ttd_gol"></td>
        </tr>
        <tr>
          <td class="top left">Jabatan</td>
          <td class="top center w-1">:</td>
          <td class="top left ttd_jabatan"></td>
        </tr>
      </table>
    </div>

    <div style="margin-top:15px;">
      Dengan ini menerangkan bahwa :
      <table class="cetak" cellpadding="0" cellspacing="0">
        <tr>
            <td class="top left w-15">Nama</td>
            <td class="top center w-1">:</td>
            <td class="top left peneliti_nama"></td>
        </tr>
        <tr>
          <td class="top left">NIP/ NIDN</td>
          <td class="top center w-1">:</td>
          <td class="top left peneliti_nip"></td>
        </tr>
        <tr>
          <td class="top left">Pangkat/Gol.</td>
          <td class="top center w-1">:</td>
          <td class="top left peneliti_gol"></td>
        </tr>
        <tr>
          <td class="top left">Jabatan</td>
          <td class="top center w-1">:</td>
          <td class="top left peneliti_jabatan"></td>
        </tr>
        <tr>
          <td class="top left">Unit Kerja</td>
          <td class="top center w-1">:</td>
          <td class="top left peneliti_unit_kerja"></td>
        </tr>
      </table>
    </div>
    <p>
      Benar telah melaksanakan kegiatan penelitian mandiri dengan judul penelitian : <span class="peneliti_judul"></span> 
    </p>
    <p>
      Sebagai bukti pelaksanaan penelitian berikut kami lampirkan (1) laporan hasil penelitian 
      dan (2) bukti luaran artikel/publikasi ilmiah penelitian terlampir. 
    </p>
    <p>  
      Demikian surat keterangan ini diberikan, untuk digunakan sebagaimana mestinya.    
    </p>

    <table class="cetak" cellpadding="0" cellspacing="0">
      <tr>
          <td class="top left" style="width:65%;"></td>
          <td class="top left">
            Kendari, <span class="tanggal_surat"></span>
            <div class="ttd_jabatan">Ketua LPPM IAIN Kendari,</div>
            <div id="qrcode_ttd" style="margin-top:5px;margin-bottom:5px"></div>
            <div class="ttd_nama"></div>
            <div>NIP. <span class="ttd_nip"></span></div>
          </td>
      </tr>
    </table>
        
    <div class="footer" style="display: flex;">
      <div style="margin-right: 10px;font-size: 27px;">
        <i class="fas fa-key"></i>
      </div>
      <div style="margin-left: auto; text-align: left;">
        Dokumen ini telah ditanda tangani secara digital oleh <span class="ttd_nama"></span>  <span class="ttd_jabatan"></span>
        melalui persetujuan eSign App Permanen yang dapat dicek melalui QRCode atau <a href="#" class="link_cek" ></a>
      </div>
    </div>
</body>
<script src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="{{ asset('js/token.js') }}"></script>
<script src="{{ asset('js/myapp.js') }}"></script>
<script>
  var user_name = localStorage.getItem('user_name');
  var role_akses = localStorage.getItem('role_akses');
  var user_role_id = localStorage.getItem('user_role_id');
  var user_email = localStorage.getItem('user_email');
  var user_foto = base_url+'/'+localStorage.getItem('user_foto');

  $(document).ready(function() {
      cekToken();
      function cekToken() {
        $.ajax({
            url: base_url + '/api/cek-akses/' + role_akses,
            type: 'GET', 
            data: null, 
            success: function(response) {
              console.log('diterima');
            },
            error: function(xhr) {
              alert(xhr.responseText);
            }
        });        
      }

      suratPenugasan();
      function suratPenugasan() {
        var id={{ $id }};
        $.ajax({
            url: base_url + '/api/surat-penugasan/' + id,
            type: 'GET', 
            data: null, 
            success: function(response) {
              const surat=response.data;
              const peneliti=surat.peneliti.user_role.user;
              const ketua_lppm=surat.ketua_lppm_role.user;

              const qr_link = `${base_url}/cek-qrcode/${surat.id}`;
              const qr_ttd = `eSing ${surat.nomor_surat} ${qr_link}`;


              const ketua_nama = `${labelWeb(ketua_lppm.identitas.gelar_depan)} ${ketua_lppm.name} ${labelWeb(ketua_lppm.identitas.gelar_belakang)}`;
              const peneliti_nama = `${labelWeb(peneliti.identitas.gelar_depan)} ${peneliti.name} ${labelWeb(peneliti.identitas.gelar_belakang)}`;
              // console.log(peneliti.identitas);

              $('.link_cek').attr('href',qr_link);
              $('.link_cek').text(qr_link);

              $('title').text(`Suket Penelitian - ${peneliti.name}`);

              $('.tanggal_surat').text(labelTanggal(surat.tanggal_surat));
              $('.nomor_surat').text(surat.nomor_surat);
              $('.ttd_nama').text(ketua_nama.trim());
              $('.ttd_nip').text(`${ketua_lppm.identitas.nip}`);
              $('.ttd_gol').text(`${ketua_lppm.identitas.pangkat.gol} ${ketua_lppm.identitas.pangkat.nama}`);
              $('.ttd_jabatan').text(`${ketua_lppm.identitas.jabatan}`);

              $('.peneliti_judul').text(`${surat.peneliti.judul}`);
              $('.peneliti_nama').text(peneliti_nama.trim());
              $('.peneliti_nip').text(`${peneliti.identitas.nip}`);
              $('.peneliti_gol').text(`${peneliti.identitas.pangkat.gol} ${peneliti.identitas.pangkat.nama}`);
              $('.peneliti_jabatan').text(`${peneliti.identitas.jabatan}`);
              $('.peneliti_unit_kerja').text(`${peneliti.identitas.unit_kerja.nama}`);


              // Buat QR code menggunakan QRCode.js
              new QRCode(document.getElementById('qrcode_ttd'), {
                  text: qr_ttd,
                  width: 75,
                  height: 75
              });                

            },
            error: function(xhr) {
              alert('Tidak ditemukan');
              window.location.href = base_url;
            }
        });        
      }

  });
</script>
</html>
