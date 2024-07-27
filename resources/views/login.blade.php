<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login Perpustakaan</title>
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
    <div class="container-fluid bg-dark">
        <div class="card position-absolute top-50 start-50 translate-middle" style="width: 400px">
            <div class="card-header">
                <div class="card-title">Silahkan Login</div>
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            Login Failed!
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="email2">Username</label>
                        <input name="username" type="text" class="form-control" placeholder="Masukkan Username" value="{{ old('username') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-primary form-control" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
