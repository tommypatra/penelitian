@extends('akun.template')

@section('head')
  <title>Profil Akun</title> 
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
      <h3 class="fw-bold mb-3">Profil Akun</h3>
      <h6 class="op-7 mb-2">Pengelolaan profil akun</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
      
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card card-round">
        <div class="card-body">

              <form id="form">
                <input type="hidden" id="id" name="id">
   
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
  
                  <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                
            </form>

        </div>

      </div>
    </div>
  </div>

</div>
@endsection


@section('modal')
@endsection

@section('script')
<script src="{{ asset('js/crud.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>

<script>
  const endpoint = base_url+'/api/user';

  $(document).ready(function() {

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

    dataLoad();
    function dataLoad() {
      var url = base_url + '/api/data-profil';
      fetchData(url, function(response) {
          renderData(response);
      },true);
    }

    // Handle page change
    $('#btn-refresh').click(function() {
        dataLoad();
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
        const url = endpoint + '/' + id;

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
    function renderData(response){
        const tmpfoto=(response.data.identitas.foto!='images/user-avatar.png')? base_url+'/storage/'+response.data.identitas.foto:base_url+'/'+response.data.identitas.foto;

        $('#id').val(response.data.id);
        $('#name').val(response.data.name);
        $('#email').val(response.data.email);
        
        $('#gelar_depan').val(response.data.identitas.gelar_depan);
        $('#gelar_belakang').val(response.data.identitas.gelar_belakang);
        $('#no_hp').val(response.data.identitas.no_hp);
        $('#nip').val(response.data.identitas.nip);
        $('#nidn').val(response.data.identitas.nidn);
        $('#jabatan').val(response.data.identitas.jabatan);

        $('#display_foto').html(`<img src="${tmpfoto}" height="75px">`);

        $('#pangkat_id').val(response.data.identitas.pangkat_id).trigger('change');            
        $('#unit_kerja_id').val(response.data.identitas.unit_kerja_id).trigger('change');            
        $('#jenis_kelamin').val(response.data.identitas.jenis_kelamin).trigger('change');            
    }


  });

</script>
@endsection