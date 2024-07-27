<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Pinjaman Buku</div>
                        <div class="card-tools">
                            <button class="btn btn-primary me-0" type="button" data-bs-toggle="modal" data-bs-target=".edit-pinjaman">
                                Kembalikan
                            </button>
                            <button class="btn btn-primary me-0" type="button" data-bs-toggle="modal" data-bs-target=".modal-tambah">
                                Tambah
                            </button>
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
                                    <th scope="col">Nomor Member</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Buku</th>
                                    <th scope="col">Tanggal Dipinjam</th>
                                    <th scope="col">Tanggal Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($pinjaman as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->member->nomor_member }}</td>
                                    <td id="nama">{{ $u->member->nama }}</td>
                                    <td id="nama">{{ $u->buku->judul }}</td>
                                    <td>{{ date('j F Y', strtotime($u->tanggal_dipinjam)) }}</td>
                                    <td>{{ $u->tanggal_kembali != null ? date('j F Y', strtotime($u->tanggal_kembali)) : '-' }}</td>
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
                    <h5 class="modal-title">Tambahkan Pinjaman</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('pinjaman_tambah') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nomor Buku</label>
                                <div class="col-sm-10">
                                    <input name="nomor_buku" type="text" class="form-control" placeholder="Masukkan Nomor" value="{{ old('nomor_buku') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Member</label>
                                <div class="col-sm-10">
                                    <select name="id_member" class="form-select mr-sm-2">
                                        @foreach ($member as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
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
    <div class="modal fade edit-pinjaman" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pinjaman</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('pinjaman_edit') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nomor Buku</label>
                                <div class="col-sm-10">
                                    <input name="nomor_buku" type="text" class="form-control" placeholder="Masukkan Nomor" value="{{ old('nomor_buku') }}">
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