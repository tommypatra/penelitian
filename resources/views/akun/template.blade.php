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
    @yield('head')

  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="purple">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="purple">
            <a href="index.html" class="logo">
                <img
                src="{{ asset('images/logo-app.png')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="50"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            
            <ul class="nav nav-secondary">
              <li class="nav-item">
                <a href="javascript:;">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>

            <ul class="nav nav-secondary" id="menu-admin" style="display: none">
                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Admin</h4>
                </li>

                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#menu-penelitian">
                    <i class="fab fa-readme"></i>
                    <p>Penelitian</p>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse" id="menu-penelitian">
                    <ul class="nav nav-collapse">
                      <li>
                        <a href="{{ route('jadwal-penelitian') }}">
                          <span class="sub-item">Jadwal</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ route('dokumen-penelitian') }}">
                          <span class="sub-item">Dokumen</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ route('verifikasi') }}">
                          <span class="sub-item">Verifikasi</span>
                        </a>
                      </li>
                      <li>
                        <a href="components/panels.html">
                          <span class="sub-item">Output</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="nav-item">
                  <a href="javascript:;">
                    <i class="far fa-file-alt"></i>
                    <p>Surat Penugasan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('user') }}">
                    <i class="fas fa-users"></i>
                    <p>Pengguna</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#menu-referensi">
                    <i class="fas fa-folder"></i>
                    <p>Referensi</p>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse" id="menu-referensi">
                    <ul class="nav nav-collapse">
                      <li>
                        <a href="{{ route('unit-kerja') }}">
                          <span class="sub-item">Unit Kerja</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ route('pangkat') }}">
                          <span class="sub-item">Pangkat</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ route('role') }}">
                          <span class="sub-item">Role</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ route('jenis-penelitian') }}">
                          <span class="sub-item">Jenis Penelitian</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
            </ul>
            <ul class="nav nav-secondary" id="menu-jfu" style="display: none">
                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">JFU LPPM</h4>
                </li>

                <li class="nav-item">
                  <a href="javascript:;">
                    <i class="fab fa-readme"></i>
                    <p>Penelitian</p>
                  </a>
                </li>              
                <li class="nav-item">
                  <a href="javascript:;">
                    <i class="far fa-file-alt"></i>
                    <p>Surat Penugasan</p>
                  </a>
                </li>              
              </ul>

              <ul class="nav nav-secondary" id="menu-ketua" style="display: none">
                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Ketua LPPM</h4>
                </li>

                <li class="nav-item">
                  <a href="javascript:;">
                    <i class="fab fa-readme"></i>
                    <p>Penelitian</p>
                  </a>
                </li>              
                <li class="nav-item">
                  <a href="javascript:;">
                    <i class="far fa-file-alt"></i>
                    <p>Surat Penugasan</p>
                  </a>
                </li>        
              </ul>
              <ul class="nav nav-secondary" id="menu-dosen" style="display: none">
                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Dosen</h4>
                </li>
                <li class="nav-item">
                  <a href="{{ route('daftar-penelitian') }}">
                    <i class="fab fa-readme"></i>
                    <p>Penelitian</p>
                  </a>
                </li>              
                <li class="nav-item">
                  <a href="javascript:;">
                    <i class="far fa-file-alt"></i>
                    <p>Surat Penugasan</p>
                  </a>
                </li>        
              </ul>

            <ul class="nav nav-secondary" >
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">General Menu</h4>
              </li>

              <li class="nav-item" id="menu-ganti-akses" style="display: none">
                <a href="javascript:;" id="ganti-akses">
                  <i class="fas fa-user-check"></i>
                  <p>Ganti Akses</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="javascript:;" class="logout">
                  <i class="fas fa-power-off"></i>
                  <p>Keluar/ Logout</p>
                </a>
              </li>
            </ul>

          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="purple2">
              <a href="index.html" class="logo">
                <img
                  src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                {{-- <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">
                        You have 4 new notification
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-icon notif-primary">
                              <i class="fa fa-user-plus"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> New user registered </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-success">
                              <i class="fa fa-comment"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Rahmad commented on Admin
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="{{ asset('templates/kaiadmin-lite-1.2.0')}}/assets/img/profile2.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Reza send messages to you
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-danger">
                              <i class="fa fa-heart"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> Farrah liked Admin </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all notifications<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li> --}}
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{ asset('images/user-avatar.png')}}"
                        alt="..."
                        class="avatar-img rounded-circle user-foto"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold user-name">Akun</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{ asset('images/user-avatar.png')}}"
                              alt="image profile"
                              class="avatar-img rounded user-foto"
                            />
                          </div>
                          <div class="u-text">
                            <h4 class="user-name">Akun</h4>
                            <p class="text-muted user-email">akun@iainkendari.ac.id</p>
                            <span class="role-akses">COBA</span>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item logout" href="javascript:;">Keluar/ Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          @yield('container')
        </div>

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="http://www.themekita.com">
                    ThemeKita
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Help </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Licenses </a>
                </li>
              </ul>
            </nav>
            <div class="copyright">
              2024, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="http://www.themekita.com">ThemeKita</a>
            </div>
            <div>
              Distributed by
              <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
            </div>
          </div>
        </footer>
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

    @yield('modal')
  
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
      var user_name = localStorage.getItem('user_name');
      var role_akses = localStorage.getItem('role_akses');
      var user_role_id = localStorage.getItem('user_role_id');
      var user_email = localStorage.getItem('user_email');
      var user_foto = base_url+'/'+localStorage.getItem('user_foto');

      function setAkses(vrole_akses) {
        ajaxRequest(base_url + '/api/cek-akses/' + vrole_akses, 'GET', null, false,
          function(response) {
            localStorage.setItem('role_akses', vrole_akses);
            localStorage.setItem('user_role_id', response.data.user_role_id);
            var goUrl = `{{ url('/dashboard') }}`;
            window.location.replace(goUrl);
          },
          function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
          }
        );
      }

      function logout(){
        ajaxRequest(base_url + '/api/logout', 'POST', null, false,
          function(response) {
            console.log('berhasil keluar');
          },
          function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
          }
        );
        localStorage.removeItem('access_token');
        localStorage.removeItem('daftar_akses');
        localStorage.removeItem('role_akses');
        localStorage.removeItem('user_role_id');
        localStorage.removeItem('user_name');
        localStorage.removeItem('user_email');
        localStorage.removeItem('user_foto');
        window.location.replace(base_url + '/login');
      }

      $(document).ready(function() {
        cekToken();
        function cekToken() {
          ajaxRequest(base_url + '/api/cek-akses/' + role_akses, 'GET', null, false,
            function(response) {
              console.log('diterima');
            },
            function(jqXHR, textStatus, errorThrown) {
              console.error('Error:', textStatus, errorThrown);
            }
          );
        }

        //init warna template
        $(".logo-header").attr("data-background-color", 'purple');
        $(".main-header .navbar-header").attr("data-background-color", 'purple2');
        $(".sidebar").attr("data-background-color", 'white');
        $(".user-foto").attr("src", user_foto);
        $(".user-name").text(user_name);
        $(".role-akses").text(role_akses);
        $(".user-email").text(user_email);

        //untuk menu set akses
        var daftar_akses = localStorage.getItem('daftar_akses');
        daftar_akses = JSON.parse(daftar_akses);       
        if (daftar_akses && daftar_akses.length > 1) {
          $("#menu-ganti-akses").show();
        }
          
        //untuk menu sesuai role aktif
        if(role_akses=='Admin')
          $('#menu-admin').show();
        else if(role_akses=='Dosen')
          $('#menu-dosen').show();
        else if(role_akses=='Ketua')
          $('#menu-ketua').show();
        else if(role_akses=='JFU')
          $('#menu-jfu').show();

        //untuk logout
        $(".logout").click(function(){
          logout();
        });

        //untuk modal set akses
        var myModalAkses = new bootstrap.Modal(document.getElementById('aksesModal'), {
          backdrop: 'static', // Disable click outside to close
          keyboard: false     // Disable Esc key to close    
        });

        function showModalAkses() {
          $('#daftar-akses').html('');
          var daftar_akses = localStorage.getItem('daftar_akses');
          daftar_akses = JSON.parse(daftar_akses);
          if (daftar_akses && daftar_akses.length > 1) {
            var htmlOptions = `<div>Hi ${user_name}, pilih akses anda:</div>`;
            htmlOptions += '<ul>';
            daftar_akses.forEach(function(akses, index) {
              htmlOptions += `<li><a href="javascript:;" class="set-akses" data-role="${akses.role}" >${akses.role}</a></li>`;
            });
            htmlOptions += '</ul>';
            $('#daftar-akses').html(htmlOptions);
            myModalAkses.show();
          }else{
            var goUrl = `{{ url('/dashboard') }}`;
            window.location.replace(goUrl);
          }
        }

        $('#ganti-akses').click(function(){
          showModalAkses();
        });

        $(document).on('click','.set-akses',function(){
          setAkses($(this).data('role'));
        });

      });
    </script>
    @yield('script')
  </body>
</html>
