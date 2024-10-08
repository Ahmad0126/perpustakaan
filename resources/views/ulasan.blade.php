<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Daftar Ulasan Anda</div>
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
                                    <th scope="col">Komentar</th>
                                    <th onclick="sortTable(4)" style="cursor: pointer;" scope="col">Rating <i class="fas fa-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $ulasan->firstItem(); @endphp
                                @foreach ($ulasan as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->buku->nomor_buku }}</td>
                                    <td><a href="{{ route('buku_detail', $u->buku->nomor_buku) }}">{{ $u->buku->judul }}</a></td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#komentar" data-ulasan="{{ $u->ulasan }}">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                    <td>
                                        @for($i=1; $i <= $u->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $ulasan->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="komentar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Komentar Anda</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="ulasan"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</x-admin>