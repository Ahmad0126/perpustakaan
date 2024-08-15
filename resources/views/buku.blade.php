<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    @can('petugas')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Menu Buku</h3>
            <h6 class="op-7 mb-2">Daftar Buku yang Tersedia</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" data-bs-target=".modal-filter" data-bs-toggle="modal" class="btn btn-label-info btn-round me-2 filter-btn" data-url="{{ route('buku_filter') }}"><i class="fas fa-filter"></i> Filter</a>
            <a href="#" class="btn btn-primary btn-round filter-btn" data-bs-target=".modal-filter" data-bs-toggle="modal" data-url="{{ route('buku_laporan') }}">Cetak Laporan</a>
        </div>
    </div>
    @endcan
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Buku</div>
                        <div class="card-tools">
                            @can('petugas')
                            <div class="dropdown">
                                <button class="btn btn-primary me-0" type="button" data-bs-toggle="modal"
                                    data-bs-target=".modal-tambah">
                                    Tambah
                                </button>
                            </div>
                            @endcan
                            @can('member')
                            <a href="#" data-bs-target=".modal-filter" data-bs-toggle="modal" class="btn btn-label-info btn-round me-2 filter-btn"  data-url="{{ route('buku_filter') }}"><i class="fas fa-filter"></i> Filter</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th style="cursor: pointer;" scope="col" onclick="sortTable(0)">No <i class="fas fa-sort"></i></th>
                                    <th style="cursor: pointer;" scope="col" onclick="sortTable(1)">Nomor Buku <i class="fas fa-sort"></i></th>
                                    <th style="cursor: pointer;" scope="col" onclick="sortTable(2)">Judul <i class="fas fa-sort"></i></th>
                                    <th style="cursor: pointer;" scope="col" onclick="sortTable(3)">Penulis <i class="fas fa-sort"></i></th>
                                    <th style="cursor: pointer;" scope="col" onclick="sortTable(4)">Kategori <i class="fas fa-sort"></i></th>
                                    <th style="cursor: pointer;" scope="col" onclick="sortTable(5)">Tanggal Rilis <i class="fas fa-sort"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $buku->firstItem(); @endphp
                                @foreach ($buku as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->nomor_buku }}</td>
                                    <td>{{ $u->judul }}</td>
                                    <td>{{ $u->penulis }}</td>
                                    <td>{{ $u->kategori->nama }}</td>
                                    <td>{{ date('j F Y', strtotime($u->tanggal_rilis)) }}</td>
                                    <td class="d-none">{{ $u->jumlah }}</td>
                                    <td>
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <a href="{{ route('buku_detail', $u->nomor_buku) }}"
                                                class="btn btn-primary"><i class="fas fa-info"></i> Info</a>
                                            @can('petugas')
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <a class="dropdown-item c-pointer" data-bs-toggle="modal"
                                                        data-bs-target=".edit-buku" data-id="{{ $u->id }}"
                                                        data-penulis="{{ $u->penulis }}"
                                                        data-penerbit="{{ $u->penerbit }}"
                                                        data-tanggal_rilis="{{ $u->tanggal_rilis }}"
                                                        data-id_kategori="{{ $u->id_kategori }}"
                                                        data-judul="{{ $u->judul }}" data-jumlah="{{ $u->jumlah }}">
                                                        <i class="fas fa-pen"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('buku_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus buku ini?')"><i class="fas fa-trash"></i> Hapus </a>
                                                </ul>
                                            </div>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $buku->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('petugas')
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
                                    <input name="judul" type="text" class="form-control" placeholder="Masukkan Judul"
                                        value="{{ old('judul') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penulis</label>
                                <div class="col-sm-10">
                                    <input name="penulis" type="text" class="form-control"
                                        placeholder="Masukkan Penulis" value="{{ old('penulis') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penerbit</label>
                                <div class="col-sm-10">
                                    <input name="penerbit" type="text" class="form-control"
                                        placeholder="Masukkan Penerbit" value="{{ old('penerbit') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Rilis</label>
                                <div class="col-sm-10">
                                    <input name="tanggal_rilis" type="date" class="form-control"
                                        placeholder="Masukkan Tanggal" value="{{ old('tanggal_rilis') }}">
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
                                    <input name="jumlah" type="number" class="form-control"
                                        placeholder="Masukkan Jumlah" value="{{ old('jumlah') }}">
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
                                    <input id="inp_judul" name="judul" type="text" class="form-control"
                                        placeholder="Masukkan Judul" value="{{ old('judul') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penulis</label>
                                <div class="col-sm-10">
                                    <input id="inp_penulis" name="penulis" type="text" class="form-control"
                                        placeholder="Masukkan Penulis" value="{{ old('penulis') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penerbit</label>
                                <div class="col-sm-10">
                                    <input id="inp_penerbit" name="penerbit" type="text" class="form-control"
                                        placeholder="Masukkan Penerbit" value="{{ old('penerbit') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Rilis</label>
                                <div class="col-sm-10">
                                    <input id="inp_tanggal_rilis" name="tanggal_rilis" type="date" class="form-control"
                                        placeholder="Masukkan Tanggal" value="{{ old('tanggal_rilis') }}">
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
                                    <input id="inp_jumlah" name="jumlah" type="number" class="form-control"
                                        placeholder="Masukkan Jumlah" value="{{ old('jumlah') }}">
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
    @endcan
    <div class="modal fade modal-filter" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terapkan Filter</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('pinjaman_filter') }}" method="get">
                    <div class="modal-body">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Rilis Dari Tanggal</label>
                                <div class="col-sm-9">
                                    <input name="tanggal_rilis" type="date" class="form-control" value="{{ old('tanggal_rilis') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select name="id_kategori" class="form-select mr-sm-2">
                                        <option value="">Pilih kategori</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>
