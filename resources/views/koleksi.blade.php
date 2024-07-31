<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Koleksi Buku</div>
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
                                    <th scope="col">Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($koleksi as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->buku->nomor_buku }}</td>
                                    <td><a href="{{ route('buku_detail', $u->buku->nomor_buku) }}">{{ $u->buku->judul }}</a></td>
                                    <td>{{ $u->buku->penulis }}</td>
                                    <td>{{ $u->buku->kategori->nama }}</td>
                                    <td>
                                        <a class="btn btn-danger" href="{{ route('koleksi_hapus', $u->id) }}" onclick="return confirm('Yakin ingin menghapus buku ini dari koleksi?')"><i class="fas fa-trash"></i> Hapus </a>
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
</x-admin>