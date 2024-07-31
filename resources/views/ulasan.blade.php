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
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nomor Buku</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Komentar</th>
                                    <th scope="col">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
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
                                    <td><i class="fas fa-star"></i> {{ $u->rating }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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