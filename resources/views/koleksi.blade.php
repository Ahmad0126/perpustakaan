<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Koleksi Buku</div>
                        @can('admin')
                            <div class="card-tools">
                                <div class="dropdown">
                                    <button class="btn btn-primary me-0" type="button" data-bs-toggle="modal" data-bs-target=".modal-tambah">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nomor Buku</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Penulis</th>
                                    <th scope="col">Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($koleksi as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->buku->nomor_buku }}</td>
                                    <td>{{ $u->buku->judul }}</td>
                                    <td>{{ $u->buku->penulis }}</td>
                                    <td>{{ $u->buku->kategori->nama }}</td>
                                    <td class="d-none">{{ $u->buku->jumlah }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-eye"></i>  Lihat
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".info-buku" data-penerbit="{{ $u->buku->penerbit }}" 
                                                    data-penulis="{{ $u->buku->penulis }}" data-tanggal_rilis="{{ date('j F Y', strtotime($u->buku->tanggal_rilis)) }}" 
                                                    data-dipinjam="{{ $u->buku->dipinjam($u->buku->id) }}" data-nomor="{{ $u->buku->nomor_buku }}" 
                                                    data-judul="{{ $u->buku->judul }}" data-kategori="{{ $u->buku->kategori->nama }}" data-jumlah="{{ $u->buku->jumlah }}">
                                                    <i class="fas fa-info"></i> Info 
                                                </a>
                                                <a class="dropdown-item" href="{{ route('koleksi_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus buku ini dari koleksi?')"><i class="fas fa-trash"></i> Hapus </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-buku" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Buku</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2 text-end">
                            <h4>
                                Judul
                            </h4>
                        </div>
                        <div class="col-10">
                            <h4>
                                <strong id="info-judul"></strong>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-end">
                            Nomor Buku
                        </div>
                        <div class="col-10">
                            <strong id="info-nomor"></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-end">
                            Penulis
                        </div>
                        <div class="col-10">
                            <strong id="info-penulis"></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-end">
                            Penerbit
                        </div>
                        <div class="col-10">
                            <strong id="info-penerbit"></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-end">
                            Kategori
                        </div>
                        <div class="col-10">
                            <strong id="info-kategori"></strong>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-2 text-end">
                            Tanggal Rilis
                        </div>
                        <div class="col-10">
                            <strong id="info-rilis"></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-end">
                            Jumlah
                        </div>
                        <div class="col-10">
                            <strong id="info-jumlah"></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-end">
                            Dipinjam
                        </div>
                        <div class="col-10">
                            <strong id="info-dipinjam"></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin>