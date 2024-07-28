<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Buku</div>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button class="btn btn-primary me-0" type="button" data-bs-toggle="modal" data-bs-target=".modal-tambah">
                                    Tambah
                                </button>
                            </div>
                        </div>
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
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($buku as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td id="nomor_buku">{{ $u->nomor_buku }}</td>
                                    <td id="judul">{{ $u->judul }}</td>
                                    <td id="kategori">{{ $u->kategori->nama }}</td>
                                    <td id="jumlah">{{ $u->jumlah }}</td>
                                    <td>
                                        <div class="d-none d-xl-block">    
                                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".info-buku" data-penulis="{{ $u->penulis }}" data-penerbit="{{ $u->penerbit }}" data-tanggal_rilis="{{ date('j F Y', strtotime($u->tanggal_rilis)) }}" data-dipinjam="{{ $u->dipinjam($u->id) }}">
                                                <i class="fas fa-info"></i> Info 
                                            </a>
                                            @can('admin')
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".edit-buku" data-id="{{ $u->id }}" data-penulis="{{ $u->penulis }}" data-penerbit="{{ $u->penerbit }}" data-tanggal_rilis="{{ $u->tanggal_rilis }}" data-id_kategori="{{ $u->id_kategori }}">
                                                    <i class="fas fa-pen"></i> Edit 
                                                </a>
                                                <a class="btn btn-danger" href="{{ route('buku_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus buku ini?')"><i class="fas fa-trash"></i> Hapus </a>
                                            @endcan
                                        </div>
                                        <div class="dropdown d-block d-xl-none">
                                            <button class="btn btn-icon btn-clean me-0" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".info-buku" data-penulis="{{ $u->penulis }}" data-penerbit="{{ $u->penerbit }}" data-tanggal_rilis="{{ date('j F Y', strtotime($u->tanggal_rilis)) }}" data-dipinjam="{{ $u->dipinjam($u->id) }}">
                                                    <i class="fas fa-info"></i> Info 
                                                </a>
                                                @can('admin')
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".edit-buku" data-id="{{ $u->id }}" data-penulis="{{ $u->penulis }}" data-penerbit="{{ $u->penerbit }}" data-tanggal_rilis="{{ $u->tanggal_rilis }}" data-id_kategori="{{ $u->id_kategori }}">
                                                        <i class="fas fa-pen"></i> Edit 
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('buku_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus buku ini?')"><i class="fas fa-trash"></i> Hapus </a>
                                                @endcan
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
    <div class="modal fade modal-tambah" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambahkan Buku</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('buku_tambah') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
                                    <input name="judul" type="text" class="form-control" placeholder="Masukkan Judul" value="{{ old('judul') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penulis</label>
                                <div class="col-sm-10">
                                    <input name="penulis" type="text" class="form-control" placeholder="Masukkan Penulis" value="{{ old('penulis') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penerbit</label>
                                <div class="col-sm-10">
                                    <input name="penerbit" type="text" class="form-control" placeholder="Masukkan Penerbit" value="{{ old('penerbit') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Rilis</label>
                                <div class="col-sm-10">
                                    <input name="tanggal_rilis" type="date" class="form-control" placeholder="Masukkan Tanggal" value="{{ old('tanggal_rilis') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select name="id_kategori" class="form-select mr-sm-2">
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jumlah</label>
                                <div class="col-sm-10">
                                    <input name="jumlah" type="number" class="form-control" placeholder="Masukkan Jumlah" value="{{ old('jumlah') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade edit-buku" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Buku</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('buku_edit') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
                                    <input id="inp_judul" name="judul" type="text" class="form-control" placeholder="Masukkan Judul" value="{{ old('judul') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penulis</label>
                                <div class="col-sm-10">
                                    <input id="inp_penulis" name="penulis" type="text" class="form-control" placeholder="Masukkan Penulis" value="{{ old('penulis') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penerbit</label>
                                <div class="col-sm-10">
                                    <input id="inp_penerbit" name="penerbit" type="text" class="form-control" placeholder="Masukkan Penerbit" value="{{ old('penerbit') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Rilis</label>
                                <div class="col-sm-10">
                                    <input id="inp_tanggal_rilis" name="tanggal_rilis" type="date" class="form-control" placeholder="Masukkan Tanggal" value="{{ old('tanggal_rilis') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select id="inp_id_kategori" name="id_kategori" class="form-select mr-sm-2">
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jumlah</label>
                                <div class="col-sm-10">
                                    <input id="inp_jumlah" name="jumlah" type="number" class="form-control" placeholder="Masukkan Jumlah" value="{{ old('jumlah') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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