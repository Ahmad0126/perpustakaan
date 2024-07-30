<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $title }}</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });

    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                            height="20" />
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
                        <li class="nav-item active">
                            <a href="{{ route('base') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Components</h4>
                        </li>
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('user') }}">
                                    <i class="fas fa-user"></i>
                                    <p>User</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('member') }}">
                                <i class="fas fa-users"></i>
                                <p>Member</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('buku') }}">
                                <i class="fas fa-book"></i>
                                <p>Buku</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori') }}">
                                <i class="fas fa-table"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pinjaman') }}">
                                <i class="fas fa-edit"></i>
                                <p>Pinjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sghdgs">
                                <i class="far fa-chart-bar"></i>
                                <p>Koleksi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sghdgs">
                                <i class="far fa-chart-bar"></i>
                                <p>Ulasan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sghdgs">
                                <i class="far fa-chart-bar"></i>
                                <p>Pengunjung</p>
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
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                                height="20" />
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
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ asset('assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">{{ Auth::user()->nama }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <a class="dropdown-item" href="#">My Profile</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
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
                <div class="page-inner">
                    {{ $slot }}
                </div>
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
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $e)
                $.notify({
                    title: 'FAILED',
                    message: '{{ $e }}',
                    icon: 'fas fa-exclamation-triangle',
                }, {
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right',
                    },
                    time: 1000,
                    delay: 3000,
                });
            @endforeach
        @endif
        @if($notif = Session::get('alert'))
            $.notify({
                title: 'OK',
                message: '{{ $notif }}',
                icon: 'fas fa-check',
            }, {
                type: 'success',
                placement: {
                    from: 'top',
                    align: 'right',
                },
                time: 1000,
                delay: 3000,
            });
        @endif

        $('.edit-user').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var level = button.data('level');
            var nama = button.data('nama');
            var id = button.data('id');
            var modal = $(this);
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="nama"]').val(nama);
            modal.find('select[name="level"]').val(level);
        });
        $('.edit-kategori').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var nomor_rak = button.data('nomor_rak');
            var nama = button.data('nama');
            var id = button.data('id');
            var modal = $(this);
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="nama"]').val(nama);
            modal.find('input[name="nomor_rak"]').val(nomor_rak);
        });
        $('.edit-member').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('input[name="id"]').val(button.data('id'));
            modal.find('#inp_tanggal_lahir').val(button.data('tanggal_lahir'));
            modal.find('#inp_nama').val(button.data('nama'));
            modal.find('#inp_alamat').val(button.data('alamat'));
            modal.find('#inp_pendidikan').val(button.data('pendidikan'));
            modal.find('#inp_pekerjaan').val(button.data('pekerjaan'));
        });
        $('.edit-buku').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('input[name="id"]').val(button.data('id'));
            modal.find('#inp_tanggal_rilis').val(button.data('tanggal_rilis'));
            modal.find('#inp_penulis').val(button.data('penulis'));
            modal.find('#inp_penerbit').val(button.data('penerbit'));
            modal.find('#inp_id_kategori').val(button.data('id_kategori'));
            modal.find('#inp_judul').val(button.data('judul'));
            modal.find('#inp_jumlah').val(button.data('jumlah'));
        });
        $('.info-buku').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var id = button.data('id');
            var modal = $(this);
            modal.find('#info-rilis').html(button.data('tanggal_rilis'));
            modal.find('#info-penulis').html(button.data('penulis'));
            modal.find('#info-penerbit').html(button.data('penerbit'));
            modal.find('#info-dipinjam').html(button.data('dipinjam'));
            modal.find('#info-kategori').html(button.data('kategori'));
            modal.find('#info-judul').html(button.data('judul'));
            modal.find('#info-jumlah').html(button.data('jumlah'));
            modal.find('#info-nomor').html(button.data('nomor'));
            if(action == 'koleksi'){
                modal.find('form').attr('action', 'koleksi');
                modal.find('input[name="id"]').val(id);
                modal.find('.modal-footer').removeClass('d-none');
                modal.find('.modal-title').html('Tambahkan ke Koleksi');
            }
            else if(action == 'pinjam'){
                modal.find('form').attr('action', '{{ route("buku_pinjam") }}');
                modal.find('input[name="id"]').val(id);
                modal.find('.modal-footer').removeClass('d-none');
                modal.find('.modal-title').html('Pinjam Buku');
            }
            else{
                modal.find('form').attr('action', '');
                modal.find('.modal-footer').addClass('d-none');
                modal.find('.modal-title').html('Informasi Buku');
            }
        });
    </script>
</body>

</html>
