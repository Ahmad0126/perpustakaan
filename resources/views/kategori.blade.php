<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Kategori</div>
                        @can('petugas')
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
                        <table class="table align-items-center mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th onclick="sortTable(0)" style="cursor: pointer;" scope="col">No <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(1)" style="cursor: pointer;" scope="col">Kategori <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(2)" style="cursor: pointer;" scope="col">Nomor Rak <i class="fas fa-sort"></i></th>
                                    @can('petugas')
                                        <th>Aksi</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($kategori as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->nama }}</td>
                                    <td>{{ $u->nomor_rak }}</td>
                                    @can('petugas')
                                        <td>
                                            <div class="d-none d-xl-block">
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".edit-kategori" data-id="{{ $u->id }}" data-nama="{{ $u->nama }}" data-nomor_rak="{{ $u->nomor_rak }}"><i class="fas fa-pen"></i> Edit </a>
                                                <a class="btn btn-danger" href="{{ route('kategori_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus kategori ini?')"><i class="fas fa-trash"></i> Hapus </a>
                                            </div>
                                            <div class="dropdown d-block d-xl-none">
                                                <button class="btn btn-icon btn-clean me-0" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".edit-kategori" data-id="{{ $u->id }}" data-nama="{{ $u->nama }}" data-nomor_rak="{{ $u->nomor_rak }}"><i class="fas fa-pen"></i> Edit </a>
                                                    <a class="dropdown-item" href="{{ route('kategori_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus kategori ini?')"><i class="fas fa-trash"> Hapus </i></a>
                                                </div>
                                            </div>
                                        </td>
                                    @endcan
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
                    <h5 class="modal-title">Tambahkan Kategori</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('kategori_tambah') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama Kategori" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nomor Rak</label>
                                <div class="col-sm-10">
                                    <input type="number" name="nomor_rak" class="form-control" value="{{ old('nomor_rak') }}">
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
    <div class="modal fade edit-kategori" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('kategori_edit') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama Kategori" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nomor Rak</label>
                                <div class="col-sm-10">
                                    <input type="number" name="nomor_rak" class="form-control" value="{{ old('nomor_rak') }}">
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
</x-admin>