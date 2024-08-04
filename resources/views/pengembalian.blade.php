<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    @can('member')
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Kembalikan Buku</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('buku_kembalikan') }}" method="post">
                        @csrf
                        <div class="form-group d-flex gap-3">
                            <div class="w-100">
                                <input name="nomor_buku" type="text" class="form-control" placeholder="Masukkan Nomor Buku" value="{{ old('nomor_buku') }}">
                                <input name="id_member" type="hidden" class="form-control" value="{{ Auth::user()->member->id }}">
                            </div>
                            <div class="">
                                <button class="btn btn-primary me-0" type="submit">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                    <h4 class="card-title mx-3 mb-3">Menunggu Diproses</h4>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <form action="{{ route('pengembalian_proses') }}" method="post">
                            @csrf
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nomor Buku</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Penulis</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($keranjang as $u)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->nomor_buku }}</td>
                                        <td><a href="{{ route('buku_detail', $u->nomor_buku) }}">{{ $u->judul }}</a></td>
                                        <td>{{ $u->penulis }}</td>
                                        <td><a href="{{ route('kembali_hapus', $u->id) }}" class="btn btn-warning">Batalkan</a></td>
                                        <input type="hidden" name="id_buku[]" value="{{ $u->id }}">
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                            <button type="submit" class="btn btn-success">Proses</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('petugas')
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Pengembalian Buku</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Peminjam</th>
                                    <th scope="col">Tanggal Peminjaman</th>
                                    <th scope="col">Total Buku</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($diproses as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->member->user->nama }}</td>
                                    <td>{{ date('j F Y', strtotime($u->tanggal_dipinjam)) }}</td>
                                    <td>{{ $u->jumlah_buku() }}</td>
                                    <td><a href="{{ route('pengembalian_detail', $u->id) }}" class="btn btn-primary">Lihat</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</x-admin>