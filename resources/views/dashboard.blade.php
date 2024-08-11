<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
            <h6 class="op-7 mb-2">Selamat Datang, {{ Auth::user()->nama }}</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('buku') }}" class="btn btn-label-info btn-round me-2">Daftar Buku</a>
            <a href="{{ route('pinjaman') }}" class="btn btn-primary btn-round">Daftar Pinjaman</a>
        </div>
    </div>
    @can('petugas')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Member</p>
                                <h4 class="card-title">{{ $jml_member }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Buku</p>
                                <h4 class="card-title">{{ $jml_buku }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-luggage-cart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Dipinjam</p>
                                <h4 class="card-title">{{ $jml_dipinjam }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Dikembalikan</p>
                                <h4 class="card-title">{{ $jml_kembali }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('member')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Pinjam Buku</p>
                                <h4 class="card-title">{{ $jml_pinjam }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Pinjam di Bulan ini</p>
                                <h4 class="card-title">{{ $jml_pinjam_pbulan }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-luggage-cart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Koleksi</p>
                                <h4 class="card-title">{{ $jml_koleksi }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Ulasan</p>
                                <h4 class="card-title">{{ $jml_ulasan }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Buku Terbaru</div>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button class="btn btn-icon btn-clean me-0" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(0)">Judul <i class="fas fa-sort"></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(1)">Penulis <i class="fas fa-sort"></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(2)">Tanggal Rilis <i class="fas fa-sort"></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(3)">Rating <i class="fas fa-sort"></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(4)">Ulasan <i class="fas fa-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buku as $b)
                                <tr>
                                    <td><a href="{{ route('buku_detail', $b->nomor_buku) }}">{{ $b->judul }} </a> </td>
                                    <td>{{ $b->penulis }}</td>
                                    <td>{{ date('j F Y', strtotime($b->tanggal_rilis)) }}</td>
                                    <td>{{ $b->rating($b->id) }}</td>
                                    <td>{{ $b->jumlah_ulasan($b->id) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin>
