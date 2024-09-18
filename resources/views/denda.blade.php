<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Menu Denda</h3>
            <h6 class="op-7 mb-2">Daftar Denda Pengembalian Buku</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" data-bs-target=".modal-filter" data-bs-toggle="modal" class="btn btn-label-info btn-round me-2 filter-btn"  data-url="{{ route('denda_filter') }}"><i class="fas fa-filter"></i> Filter</a>
            @can('petugas')
            <a href="#" class="btn btn-primary btn-round filter-btn" data-bs-target=".modal-filter" data-bs-toggle="modal" data-url="{{ route('denda_laporan') }}">Cetak Laporan</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">
                            Daftar Denda
                        </div>
                        @can('petugas')
                        <div class="card-tools">
                            <a class="btn btn-primary me-0" data-bs-toggle="modal" data-bs-target=".modal-tambah">
                                Tambah
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0" class="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(0)">No <i class="fas fa-sort"></i></th>
                                    @can('petugas')
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(1)">Member <i class="fas fa-sort"></i></th>
                                    @endcan
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(2)">Nominal <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(3)">Tanggal Ditambahkan <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(4)">Tanggal Dibayar <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(5)">Status <i class="fas fa-sort"></i></th>
                                    @can('petugas')
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(6)">Kode Verifikasi <i class="fas fa-sort"></i></th>
                                    @endcan
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $denda->firstItem(); @endphp
                                @foreach ($denda as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    @can('petugas')
                                    <td>{{ $u->member->user->nama }}</td>
                                    @endcan
                                    <td>Rp {{ number_format($u->nominal) }}</td>
                                    <td>{{ date('j F Y', strtotime($u->tanggal)) }}</td>
                                    <td>{{ $u->tanggal_dibayar != null ? date('j F Y', strtotime($u->tanggal_dibayar)) : '-' }}</td>
                                    <td><span class="badge @if($u->status != 'dibayar') text-bg-warning @else text-bg-success @endif">{{ $u->status }}</span></td>
                                    @can('petugas')
                                    <td>{{ $u->kode_verifikasi }}</td>
                                    @endcan
                                    <td>
                                        @can('petugas')
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-clean me-0" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item c-pointer" data-bs-toggle="modal" data-bs-target=".edit-denda" data-id="{{ $u->id }}" data-nominal="{{ $u->nominal }}">
                                                    <i class="fas fa-pen"></i> Edit 
                                                </a>
                                                <a class="dropdown-item" href="{{ route('denda_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus denda ini?')"><i class="fas fa-trash"></i> Hapus </a>
                                            </div>
                                        </div>
                                        @endcan
                                        @can('member')
                                            @if($u->status != 'dibayar')
                                                <a class="btn btn-primary me-0" data-bs-toggle="modal" data-bs-target=".modal-bayar" data-id="{{ $u->id }}">
                                                    Bayar
                                                </a>
                                            @else
                                                -
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $denda->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-filter" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terapkan Filter</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('denda_filter') }}" method="get">
                    <div class="modal-body">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dibuat Dari Tanggal</label>
                                <div class="col-sm-9">
                                    <input name="tanggal_dibuat" type="date" class="form-control" value="{{ old('tanggal_dibuat') }}">
                                </div>
                            </div>
                            @if (Gate::allows('member'))
                                <input type="hidden" name="id_member" value="{{ Auth::user()->member->id }}">
                            @else
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Member</label>
                                    <div class="col-sm-10">
                                        <select name="id_member" class="form-select mr-sm-2">
                                            <option value="">Pilih member</option>
                                            @foreach ($member as $k)
                                                <option value="{{ $k->id }}">{{ $k->user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-select mr-sm-2">
                                        <option value="">Pilih status</option>
                                        <option value="dibayar">dibayar</option>
                                        <option value="belum dibayar">belum dibayar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nominal</label>
                                <div class="col-sm-3">
                                    <select name="pembanding" class="form-select mr-sm-2">
                                        <option value="sama">sama dengan</option>
                                        <option value="lebih">lebih dari</option>
                                        <option value="kurang">kurang dari</option>
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    <input type="number" name="nominal" class="form-control">
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
    @can('petugas')
    <div class="modal fade modal-tambah" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambahkan Denda</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('denda_tambah') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Member</label>
                                <div class="col-sm-10">
                                    <select name="id_member" class="form-select" id="member">
                                        @foreach ($member as $m)
                                        <option value="{{ $m->id }}">{{ $m->user->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nominal</label>
                                <div class="col-sm-10">
                                    <input type="number" name="nominal" class="form-control">
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
    <div class="modal fade edit-denda" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Denda</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('denda_edit') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nominal</label>
                                <div class="col-sm-10">
                                    <input type="number" name="nominal" class="form-control">
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
    @can('member')
    <div class="modal fade modal-bayar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bayar Denda</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('denda_bayar') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kode Verifikasi</label>
                                <div class="col-sm-10">
                                    <input type="text" name="kode_verifikasi" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</x-admin>