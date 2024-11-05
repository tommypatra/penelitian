@extends('akun.template')

@section('head')
  <title>Timeline Penelitian</title> 
  <style>
      .form-select {
        width: auto;
        min-width: 175px; /* Tetap tetapkan batas minimal */      
      }
      a {
        z-index: 10; /* Pastikan link di atas elemen lainnya */
        position: relative; /* Pastikan link tidak tertutup */
      }  
</style>
@endsection

@section('container')
<div class="page-inner">
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Timeline <span id="nama-penelitian"></span></h3>
      <h6 class="op-7 mb-2">Pengelolaan timeline penelitian</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
      {{-- <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" name="search-input" id="search-input" aria-label="Text input with dropdown button">
          <div class="input-group-append">
            <button class="btn btn-primary btn-border" type="button" id="btn-cari">
              <i class="fas fa-search"></i> Cari
            </button>
          </div>
        </div>
      </div>       --}}
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <ul class="timeline">
        <li>
          <div class="timeline-badge">
            <i class="far fa-paper-plane"></i>
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Pendaftaran Judul Berhasil</h4>
              <p>
                <small class="text-muted"><i class="far fa-paper-plane"></i> terdaftar <span id="tanggal-daftar"></span></small>
              </p>
            </div>
            <div class="timeline-body">
              <form id="formJudul">
                <input type="hidden" id="penelitian_id" name="penelitian_id">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="user_role_id" name="user_role_id">
                <div class="form-group">
                  <textarea rows="3" type="text" class="form-control" id="judul" name="judul" required></textarea>
                  <button type="submit" class="btn btn-primary mt-2 btn-sm" id="btn-ganti-judul"><i class="far fa-save"></i> Ganti Judul</button>
                </div>
              </form>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge warning">
            <i class="fas fa-upload"></i>
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Lengkapi dokumen syarat</h4>
            </div>
            <div class="timeline-body">
              <p>
                silahkan untuk mengupload dokumen syarat berikut
              </p>
              <div id="dokumen-upload"></div>
              <button class="btn btn-primary mt-2 btn-sm" id="btn-kirim-dokumen"><span id="label-kirim-dokumen"><i class="fas fa-file-import"></i> Kirim Dokumen</span></button>

            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge danger">
            <i class="fas fa-user-shield"></i>
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Verifikasi oleh Admin/ JFU LPPM</h4>
            </div>
            <div class="timeline-body">
              <p id="label-verifikasi"></p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Persetujuan Kepala LPPM</h4>
            </div>
            <div class="timeline-body">
              <p id="persetujuan-kepala-lppm">
                Admin/ JFU LPPM memverifikasi terlebih dahulu sebelum melakukan pengajuan surat penugasan kepada Ketua LPPM
              </p>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge info">
            <i class="fas fa-qrcode"></i>
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Penomoran Surat</h4>
            </div>
            <div class="timeline-body">
              <p id="penomoran-surat">
                Menunggu tahapan persetujuan ketua LPPM  
              </p>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Download Surat Penugasan</h4>
            </div>
            <div class="timeline-body">
              <p id="download-surat">
                Belum bisa di download, masih ada proses belum selesai 
              </p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge success">
            <i class="fas fa-book"></i>
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Lengkapi Output</h4>
            </div>
            <div class="timeline-body">
              <p id="output-penelitian">
                Setelah surat pengasan terbit dan penelitian selesai dilakukan, mohon upload output pada web ini.
              </p>
              <div id="syarat-upload"></div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>

</div>
@endsection


@section('modal')
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog ">
      <div class="modal-content">
          <form id="form">
              <input type="hidden" id="id" name="id">

              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Form Role Akun</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                <div class="row">
                  <div class="col-lg-12">
                    
                    <div class="form-group">
                      <label for="nama">Role Akun</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="role akun" required>
                    </div>

                    <div class="form-group">
                      <label for="keterangan">Keterangan</label>
                      <textarea rows="3" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan" ></textarea>
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

    function renderDokumen(dokumen,dokumen_peneliti,elementId,kategori,is_valid){
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

                // untuk list file yang sudah di upload               
                const ul_file = $('<ul class="file-upload" style="list-style-type: none; padding-left: 0;"></ul>');
                if(dokumen_peneliti.length>0){
                  $.each(dokumen_peneliti, function(index_file, dt_file) {
                    if(dt_file.dokumen_id==dt.id){
                      const link =`${base_url}/storage/${dt_file.path}`;
                      const li_file = $(`<li class="daftar-file">
                                            <span class="badge bg-success">                                             
                                              ${dt.nama}-${index_file+1}
                                            </span>  
                                            <span style="font-size:12px">${timeAgo(dt_file.created_at)}</span>
                                            <a href="${base_url+'/storage/'+dt_file.path}" target="_blank"><i class="fas fa-file-download"></i></a>
                                            ${is_valid ? '' : `<a href="javascript:;" data-id="${dt_file.id}" class="btn-hapus-download"><i class="fas fa-trash"></i></a>`}                                       
                                          </li>`);
                      ul_file.append(li_file);
                    }
                  });
                } 

                //membuat list untuk dokumen               
                const li = $(`<li class="daftar-dokumen" data-is_wajib="${dt.is_wajib}" data-jumlah_dokumen_upload="${dokumen_peneliti.length}">
                                <span class="nama_dokumen">${dt.nama} (${dt.tipe_file})</span> ${is_wajib}
                                <div class="text-muted" style="font-style:italic;">${dt.keterangan}</div>
                                ${is_valid ? '' : `<input style="font-size:10px;" type="file" class="file-dokumen" data-id="${dt.id}" accept="${acceptType}">`}
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

    function renderData(response) {
      const surat_penugasan = response.surat_penugasan;
      $('#tanggal-daftar').text(timeAgo(response.created_at));
      $('#judul').val(response.judul);
      $('#id').val(response.id);
      $('#penelitian_id').val(response.penelitian_id);
      $('#user_role_id').val(response.user_role_id);
      $('#nama-penelitian').text(`${response.penelitian.nama} (tahun ${response.penelitian.tahun})`);

      if(surat_penugasan.length>0){
        if(surat_penugasan[0].is_disetujui==null){
          $('#persetujuan-kepala-lppm').text(`Menunggu persetujuan oleh Ketua LPPM ${timeAgo(surat_penugasan[0].created_at)}`);
        }else if(surat_penugasan[0].is_disetujui){
          $('#persetujuan-kepala-lppm').text(`Surat penugasan sudah disetujui oleh ketua LPPM ${timeAgo(surat_penugasan[0].persetujuan_at)}`);
          $('#penomoran-surat').text(`Penomoran sedang proses silahkan menunggu`);
          if(surat_penugasan[0].nomor_surat!=null){
            $('#penomoran-surat').text(`Nomor surat penugasan telah terbit ${timeAgo(surat_penugasan[0].updated_at)} dengan nomor ${surat_penugasan[0].nomor_surat} pada tanggal ${surat_penugasan[0].tanggal_surat}`);
            $('#download-surat').html(`Surat penugasan ${timeAgo(surat_penugasan[0].updated_at)} sudah dapat <a href="${base_url}/cetak-surat-penugasan/${surat_penugasan[0].id}" target="_blank">di download disini</a> `);            
          }
        }else{
          $('#persetujuan-kepala-lppm').text(`Maaf, surat penugasan ditolak oleh Ketua LPPM ${timeAgo(surat_penugasan[0].persetujuan_at)} dengan catatan "${surat_penugasan[0].catatan}"`);
        }
      }

      let label_verifikasi="...";
      if(response.is_valid==null){
        label_verifikasi="Lengkapi seluruh dokumen syarat wajib dan Kirim Dokumen agar dapat diverifikasi";
      }else if(response.is_valid){
        label_verifikasi=`Selamat, verifikasi dokumen anda memenuhi syarat ${timeAgo(response.validated_at)}`;
      }else if(response.is_valid==false){
        label_verifikasi=`Dokumen anda telah diperiksa dan tidak memenuhi syarat ${timeAgo(response.validated_at)}, catatannya : ${labelWeb(response.catatan)}`;
      }

      let label_kirim_dokumen=`<i class="fas fa-file-import"></i> Kirim Dokumen`;
      if(response.is_selesai){
        if(!response.is_valid || response.is_valid==null)
          label_verifikasi=`Terima kasih telah mengirim dokumen ${timeAgo(response.updated_at)}, tinggal menunggu hasil verifikasi`;
        label_kirim_dokumen=`<i class="fas fa-ban"></i> Batalkan Pengiriman Dokumen`;
      }
      $('#label-kirim-dokumen').html(label_kirim_dokumen);
      $('#label-verifikasi').text(label_verifikasi);

      if(response.is_valid){
        $('#btn-kirim-dokumen').remove();
        $('#btn-ganti-judul').remove();
        $('#judul').prop('disabled', true);
        renderDokumen(response.penelitian.dokumen,response.dokumen_peneliti,'#syarat-upload','output',false);
      }
      renderDokumen(response.penelitian.dokumen,response.dokumen_peneliti,'#dokumen-upload','syarat',response.is_valid);
    }    

    function dataLoad() {
      var search = $('#search-input').val();
      var url = endpoint + '?page=' + page + '&limit=1&id={{ $peneliti_id }}';

      fetchData(url, function(response) {
        if(response.data.data.length>0)
          renderData(response.data.data[0]);
        else
          window.location.href = base_url+'/daftar-penelitian';
      },true);
    }

    // Handle page change
    $('#btn-refresh').click(function() {
        dataLoad();
    });

    $(document).on('change', '.file-dokumen', function() {
      const dokumen_id = $(this).data('id');
      const file = this.files[0]; // Mendapatkan file yang dipilih
      const type = 'POST';
      const url = base_url + '/api/upload-dokumen-peneliti';

      if (file) {
          const formData = new FormData();
          formData.append('dokumen', file);
          formData.append('dokumen_id', dokumen_id);
          formData.append('peneliti_id', {{ $peneliti_id }});

          saveData(url, type, formData, function(response) {
            toastr.success('operasi berhasil dilakukan!', 'berhasil');
            dataLoad();
          });
      }
    });


    //validasi dan save, jika id ada maka PUT/edit jika tidak ada maka POST/simpan baru
    $("#formJudul").validate({
      submitHandler: function(form) {
        const id = $('#id').val();
        const type = 'PUT';
        const url = endpoint + '/' + id;
        saveData(url, type, $(form).serialize(), function(response) {
          //jika berhasil
          toastr.success('operasi berhasil dilakukan!', 'berhasil');
        });
      }
    });

    //ganti data
    $(document).on('click', '.btn-ganti', function() {
      const id = $(this).data('id');
      showDataById(endpoint, id, function(response) {
        formReset();
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

    //hapus list download
    $(document).on('click', '.btn-hapus-download', function() {
      const id = $(this).data('id');
      const v_endpoint = base_url + '/api/upload-dokumen-peneliti';
      deleteData(v_endpoint, id, function() {
          toastr.success('berhasil dilakukan!', 'berhasil');
          dataLoad();
      });
    });


    function validasiDokumen() {
      let valid = true;
      $('.daftar-dokumen').each(function() {
          const is_wajib = $(this).data('is_wajib'); // Cek apakah dokumen ini wajib
          const jumlah_dokumen_upload = $(this).data('jumlah_dokumen_upload'); // Jumlah dokumen yang sudah di-upload

          if (is_wajib && jumlah_dokumen_upload <1) {
              toastr.error(`Dokumen "${$(this).find('.nama_dokumen').text().trim()}" wajib diunggah minimal 1 file.`, 'gagal');
              valid = false;
              return false;          
          }
      });

      return valid; // Mengembalikan hasil validasi
    }

    $('#btn-kirim-dokumen').click(function(){
      if(confirm('Apakah anda yakin?') && validasiDokumen()){
        const formData = new FormData();
        const url = base_url + '/api/finalisasi-peneliti/' + {{ $peneliti_id }};
        saveData(url, 'put', null, function(response) {
          toastr.success('kirim data penelitian telah dilakukan!', 'berhasil');
          dataLoad();
        });
      }
    });

  
  });

</script>
@endsection