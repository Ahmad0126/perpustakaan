<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <form action="{{ route('transaksi_masukkan') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">
                                Transaksi Pinjaman Buku
                            </div>
                            <div class="card-tools">
                                <button class="btn btn-primary me-0" type="submit">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="nomor_buku" id="" class="form-control" placeholder="Masukkan Nomor Buku">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">
                            Antrean Peminjaman
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <form action="{{ route('transaksi_proses') }}" method="post">
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
                                    @foreach ($buku as $u)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->nomor_buku }}</td>
                                        <td><a href="{{ route('buku_detail', $u->nomor_buku) }}">{{ $u->judul }}</a></td>
                                        <td>{{ $u->penulis }}</td>
                                        <td><a href="{{ route('keranjang_hapus', $u->id) }}" class="btn btn-warning">Batalkan</a></td>
                                        <input type="hidden" name="id_buku[]" value="{{ $u->id }}">
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    @can('petugas')
                                                        <span class="input-group-text">Pilih Member </span>
                                                        <select name="id_member" class="form-select" id="member">
                                                            @foreach ($member as $m)
                                                            <option value="{{ $m->id }}">{{ $m->user->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endcan
                                                    @can('member')
                                                        <input type="hidden" name="id_member" id="member" value="{{ Auth::user()->member->id }}">
                                                    @endcan
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-success">Pinjam</button>
                                                    </div>
                                                </div>
                                            </div>
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
</x-admin>