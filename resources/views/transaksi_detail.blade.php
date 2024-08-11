<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Informasi Peminjaman</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Peminjam</th>
                                    <th scope="col">Tanggal Dipinjam</th>
                                    @can('petugas')
                                    <th scope="col">Aksi</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $buku->member->user->nama }}</td>
                                    <td>{{ date('j F Y', strtotime($buku->tanggal_dipinjam)) }}</td>
                                    @can('petugas')
                                    <td>
                                        <form action="{{ route('transaksi_kembalikan') }}" method="post" style="display: inline-block">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $buku->id }}">
                                            <button class="btn btn-primary">Kembalikan</button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Buku yang dipinjam</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nomor Buku</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Penulis</th>
                                    <th scope="col">Tanggal Dipinjam</th>
                                    <th scope="col">Tanggal Kembali</th>
                                    <th scope="col">Status</th>
                                    @can('petugas')
                                    <th scope="col">Aksi</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($buku->detail as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->buku->nomor_buku }}</td>
                                    <td><a href="{{ route('buku_detail', $u->buku->nomor_buku) }}">{{ $u->buku->judul }}</a></td>
                                    <td>{{ $u->buku->penulis }}</td>
                                    <td>{{ date('j F Y', strtotime($u->pinjaman->tanggal_dipinjam)) }}</td>
                                    <td>{{ $u->tanggal_kembali != null ? date('j F Y', strtotime($u->tanggal_kembali)) : '-' }}</td>
                                    @php
                                        switch ($u->status) {
                                            case 'dipinjam': $badge = 'text-bg-warning'; break;
                                            case 'menunggu_dipinjam': $badge = 'text-bg-warning'; break;
                                            case 'ditolak': $badge = 'text-bg-danger'; break;
                                            default: $badge = 'text-bg-success'; break;
                                        }
                                    @endphp
                                    <td><span class="badge {{ $badge }}">{{ $u->status }}</span></td>
                                    @can('petugas')
                                    <td>
                                        @if ($u->status == 'dipinjam')
                                        <a class="btn btn-primary" href="{{ route('pinjaman_kembalikan').'?id='.$u->id }}">Kembalikan</a>
                                        @else
                                            -
                                        @endif
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
</x-admin>