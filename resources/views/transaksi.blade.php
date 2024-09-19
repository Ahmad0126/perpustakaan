<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Menu Transaksi</h3>
            <h6 class="op-7 mb-2">Daftar Semua Transaksi Peminjaman Buku</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" data-bs-target=".modal-filter" data-bs-toggle="modal" class="btn btn-label-info btn-round me-2 filter-btn"  data-url="{{ route('transaksi_filter') }}"><i class="fas fa-filter"></i> Filter</a>
            @can('petugas')
            <a href="#" class="btn btn-primary btn-round filter-btn" data-bs-target=".modal-filter" data-bs-toggle="modal" data-url="{{ route('transaksi_laporan') }}">Cetak Laporan</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">
                            Daftar Transaksi Peminjaman Buku 
                        </div>
                        <div class="card-tools">
                            <a class="btn btn-primary me-0" href="{{ route('transaksi_tambah') }}">
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0" class="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(0)">No <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(1)">Peminjam <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(2)">Tanggal Peminjaman <i class="fas fa-sort"></i></th>
                                    <th scope="col" style="cursor: pointer;" onclick="sortTable(3)">Total Buku <i class="fas fa-sort"></i></th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $transaksi->firstItem(); @endphp
                                @foreach ($transaksi as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->member->user->nama }}</td>
                                    <td>{{ date('j F Y', strtotime($u->tanggal_dipinjam)) }}</td>
                                    <td>{{ $u->jumlah_buku($u->id) }}</td>
                                    <td><a href="{{ route('transaksi_detail', $u->id) }}" class="btn btn-primary">Lihat</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $transaksi->links('vendor.pagination.default') }}
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
                <form action="{{ route('transaksi_filter') }}" method="get">
                    <div class="modal-body">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dipinjam Dari Tanggal</label>
                                <div class="col-sm-9">
                                    <input name="tanggal_dipinjam" type="date" class="form-control" value="{{ old('tanggal_dipinjam') }}">
                                </div>
                            </div>
                            @can('petugas')
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
                            @endcan
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