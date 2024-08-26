<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Menu Pinjaman</h3>
            <h6 class="op-7 mb-2">Daftar Buku yang Pernah Dipinjam</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" data-bs-target=".modal-filter" data-bs-toggle="modal" class="btn btn-label-info btn-round me-2 filter-btn"  data-url="{{ route('pinjaman_filter') }}"><i class="fas fa-filter"></i> Filter</a>
            @can('petugas')
            <a href="#" class="btn btn-primary btn-round filter-btn" data-bs-target=".modal-filter" data-bs-toggle="modal" data-url="{{ route('pinjaman_laporan') }}">Cetak Laporan</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">
                            Daftar Pinjaman Buku
                        </div>
                        <div class="card-tools">
                            @can('petugas')
                            <button class="btn btn-secondary me-0" type="button" data-bs-toggle="modal" data-bs-target=".edit-pinjaman">
                                Kembalikan
                            </button>
                            @endcan
                            <a class="btn btn-primary me-0" href="{{ route('transaksi_tambah') }}">
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(0)">No <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(1)">Nomor Buku <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(2)">Peminjam <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(3)">Judul <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(4)">Tanggal Dipinjam <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(5)">Tanggal Kembali <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer" onclick="sortTable(6)">Status <i class="fas fa-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @can('petugas')
                                    @php $no = $pinjaman->firstItem(); @endphp
                                    @foreach ($pinjaman as $u)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->buku->nomor_buku }}</td>
                                        <td>{{ $u->pinjaman->member->user->nama }}</td>
                                        <td><a href="{{ route('buku_detail', $u->buku->nomor_buku) }}">{{ $u->buku->judul }}</a></td>
                                        <td>
                                            <a href="{{ route('transaksi_detail', $u->pinjaman->id) }}"> {{ date('j F Y', strtotime($u->pinjaman->tanggal_dipinjam)) }}</a>
                                        </td>
                                        <td>{{ $u->tanggal_kembali != null ? date('j F Y', strtotime($u->tanggal_kembali)) : '-' }}</td>
                                        <td><span class="badge @if($u->status == 'dipinjam') text-bg-warning @else text-bg-success @endif">{{ $u->status }}</span></td>
                                    </tr>
                                    @endforeach
                                @endcan
                                @can('member')
                                    @php $no = 1; @endphp
                                    @foreach($pinjaman as $p)
                                        @foreach ($p->detail as $u)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $u->buku->nomor_buku }}</td>
                                            <td>{{ $u->pinjaman->member->user->nama }}</td>
                                            <td><a href="{{ route('buku_detail', $u->buku->nomor_buku) }}">{{ $u->buku->judul }}</a></td>
                                            <td>
                                                <a href="{{ route('transaksi_detail', $u->pinjaman->id) }}"> {{ date('j F Y', strtotime($u->pinjaman->tanggal_dipinjam)) }}</a>
                                            </td>
                                            <td>{{ $u->tanggal_kembali != null ? date('j F Y', strtotime($u->tanggal_kembali)) : '-' }}</td>
                                            <td><span class="badge @if($u->status == 'dipinjam') text-bg-warning @else text-bg-success @endif">{{ $u->status }}</span></td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                @endcan
                            </tbody>
                        </table>
                        @can('petugas')
                        {{ $pinjaman->links('vendor.pagination.default') }}
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('petugas')
    <div class="modal fade edit-pinjaman" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kembalikan Buku</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form action="{{ route('pinjaman_kembalikan') }}" method="get">
                    <div class="modal-body">
                        <input type="hidden" name="id">
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
                                            <option value="{{ $k->id }}">{{ $k->user->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kembalikan</button>
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
                                <label class="col-sm-3 col-form-label">Dipinjam Dari Tanggal</label>
                                <div class="col-sm-9">
                                    <input name="tanggal_dipinjam" type="date" class="form-control" value="{{ old('tanggal_dipinjam') }}">
                                </div>
                            </div>
                            @if (Gate::allows('member'))
                                <input type="hidden" name="id_member" value="{{ Auth::user()->member->id }}">
                            @else
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Peminjam</label>
                                    <div class="col-sm-10">
                                        <select name="id_member" class="form-select mr-sm-2">
                                            <option value="">Pilih peminjam</option>
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
                                        <option value="dipinjam">Dipinjam</option>
                                        <option value="dikembalikan">Dikembalikan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="terlambat">Terlambat</label>
                                <input type="checkbox" name="terlambat" id="terlambat" value="true">
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
