<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Member</div>
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
                        <table class="table align-items-center mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th onclick="sortTable(0)" style="cursor: pointer;" scope="col">No <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(1)" style="cursor: pointer;" scope="col">Nomor Member <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(2)" style="cursor: pointer;" scope="col">Nama <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(3)" style="cursor: pointer;" scope="col">Email <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(4)" style="cursor: pointer;" scope="col">Tanggal Lahir <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(5)" style="cursor: pointer;" scope="col">Alamat <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(6)" style="cursor: pointer;" scope="col">Pendidikan <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(7)" style="cursor: pointer;" scope="col">Pekerjaan <i class="fas fa-sort"></i></th>
                                    @can('admin')
                                        <th>Aksi</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $member->firstItem(); @endphp
                                @foreach ($member as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->nomor_member }}</td>
                                    <td>{{ $u->user->nama }}</td>
                                    <td>{{ $u->user->username }}</td>
                                    <td>{{ date('j F Y', strtotime($u->tanggal_lahir)) }}</td>
                                    <td>{{ $u->alamat }}</td>
                                    <td>{{ $u->pendidikan }}</td>
                                    <td>{{ $u->pekerjaan }}</td>
                                    @can('admin')
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-icon btn-clean me-0" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item c-pointer" data-bs-toggle="modal" data-bs-target=".edit-member" data-id="{{ $u->id }}" data-pendidikan="{{ $u->pendidikan }}" data-alamat="{{ $u->alamat }}" data-nama="{{ $u->user->nama }}" data-tanggal_lahir="{{ $u->tanggal_lahir }}">
                                                        <i class="fas fa-pen"></i> Edit 
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('member_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus member ini?')"><i class="fas fa-trash"></i> Hapus </a>
                                                </div>
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $member->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('admin')
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
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input name="email" type="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input name="password" type="password" class="form-control" placeholder="Buat Password">
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
    @endcan
    <div class="modal fade modal-filter" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terapkan Filter</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="" method="get">
                    <div class="modal-body">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal lahir</label>
                                <div class="col-sm-10">
                                    <input name="tanggal_lahir" type="date" class="form-control" placeholder="Masukkan Tanggal" value="{{ old('tanggal_lahir') }}">
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
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>