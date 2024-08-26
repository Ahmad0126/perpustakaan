<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Koleksi Buku Saya</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th onclick="sortTable(0)" style="cursor: pointer;" scope="col">No <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(1)" style="cursor: pointer;" scope="col">Nomor Buku <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(2)" style="cursor: pointer;" scope="col">Judul <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(3)" style="cursor: pointer;" scope="col">Penulis <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(4)" style="cursor: pointer;" scope="col">Kategori <i class="fas fa-sort"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $koleksi->firstItem(); @endphp
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
                        {{ $koleksi->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin>