<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Member</div>
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
                                    <th scope="col">Nomor Member</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Tanggal Lahir</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Pendidikan</th>
                                    <th scope="col">Pekerjaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($member as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->nomor_member }}</td>
                                    <td id="nama">{{ $u->nama }}</td>
                                    <td>{{ date('j F Y', strtotime($u->tanggal_lahir)) }}</td>
                                    <td id="alamat">{{ $u->alamat }}</td>
                                    <td id="pendidikan">{{ $u->pendidikan }}</td>
                                    <td id="pekerjaan">{{ $u->pekerjaan }}</td>
                                    <td>
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".edit-member" data-id="{{ $u->id }}" data-tanggal_lahir="{{ $u->tanggal_lahir }}">
                                            Edit <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger" href="{{ route('member_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus member ini?')">Hapus <i class="fas fa-trash"></i></a>
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
                    <h5 class="modal-title">Tambahkan Member</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('member_tambah') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal lahir</label>
                                <div class="col-sm-10">
                                    <input name="tanggal_lahir" type="date" class="form-control" placeholder="Masukkan Tanggal" value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input name="alamat" type="text" class="form-control" placeholder="Masukkan Alamat" value="{{ old('alamat') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pendidikan</label>
                                <div class="col-sm-10">
                                    <select name="pendidikan" class="form-select mr-sm-2">
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pekerjaan</label>
                                <div class="col-sm-10">
                                    <select name="pekerjaan" class="form-select mr-sm-2">
                                        <option value="">Pilih</option>
                                        <option value="Pelajar">Pelajar</option>
                                        <option value="Pegawai Negeri">Pegawai Negeri</option>
                                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                                        <option value="Wirausaha">Wirausaha</option>
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
    <div class="modal fade edit-member" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Member</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('member_edit') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input id="inp_nama" name="nama" type="text" class="form-control" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal lahir</label>
                                <div class="col-sm-10">
                                    <input id="inp_tanggal_lahir" name="tanggal_lahir" type="date" class="form-control" placeholder="Masukkan Tanggal" value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input id="inp_alamat" name="alamat" type="text" class="form-control" placeholder="Masukkan Alamat" value="{{ old('alamat') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pendidikan</label>
                                <div class="col-sm-10">
                                    <select id="inp_pendidikan" name="pendidikan" class="form-select mr-sm-2">
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pekerjaan</label>
                                <div class="col-sm-10">
                                    <select id="inp_pekerjaan" name="pekerjaan" class="form-select mr-sm-2">
                                        <option value="">Pilih</option>
                                        <option value="Pelajar">Pelajar</option>
                                        <option value="Pegawai Negeri">Pegawai Negeri</option>
                                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                                        <option value="Wirausaha">Wirausaha</option>
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
</x-admin>