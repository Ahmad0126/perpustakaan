<x-admin>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col-xl-6 col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <div class="card-title">Detail Buku</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-center align-items-center">
                                    <i class="fas fa-book fa-10x"></i>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col">
                                            <h1>
                                                <strong>{{ $buku->judul }}</strong>
                                            </h1>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col">
                                            <h4>By <strong>{{ $buku->penulis }} </strong></h4>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <strong>Penerbit </strong>
                                        </div>
                                        <div class="col-7">
                                            {{ $buku->penerbit }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <strong>Tanggal Rilis</strong>
                                        </div>
                                        <div class="col-7">
                                            {{ date('j F Y', strtotime($buku->tanggal_rilis)) }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <strong>Nomor Buku</strong>
                                        </div>
                                        <div class="col-7">
                                            {{ $buku->nomor_buku }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <strong>Kategori</strong>
                                        </div>
                                        <div class="col-7">
                                            {{ $buku->kategori->nama }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <strong>Jumlah</strong>
                                        </div>
                                        <div class="col-7">
                                            {{ $buku->jumlah }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <strong>Dipinjam</strong>
                                        </div>
                                        <div class="col-7">
                                            {{ $buku->dipinjam($buku->id) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            @can('member')
                            <form class="d-inline-block" action="{{ route('buku_pinjam') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $buku->id }}">
                                <button type="submit" class="btn btn-secondary"><i class="fas fa-download"></i> Pinjam</button>
                            </form>
                            @endcan
                            <form class="d-inline-block" action="{{ route('koleksi_add') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $buku->id }}">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-bookmark"></i> Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Ulas Buku Ini</h1>
                        </div>
                        <form action="{{ route('ulas') }}" method="post">
                            @csrf
                            <input type="hidden" name="id_buku" value="{{ $buku->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                          <input type="radio" name="rating" value="1" class="selectgroup-input" checked="">
                                          <span class="selectgroup-button">1</span>
                                        </label>
                                        <label class="selectgroup-item">
                                          <input type="radio" name="rating" value="2" class="selectgroup-input">
                                          <span class="selectgroup-button">2</span>
                                        </label>
                                        <label class="selectgroup-item">
                                          <input type="radio" name="rating" value="3" class="selectgroup-input">
                                          <span class="selectgroup-button">3</span>
                                        </label>
                                        <label class="selectgroup-item">
                                          <input type="radio" name="rating" value="4" class="selectgroup-input">
                                          <span class="selectgroup-button">4</span>
                                        </label>
                                        <label class="selectgroup-item">
                                          <input type="radio" name="rating" value="5" class="selectgroup-input">
                                          <span class="selectgroup-button">5</span>
                                        </label>
                                      </div>
                                </div>
                                <div class="form-group row">
                                    <textarea name="ulasan" id="" class="form-control" placeholder="Komentar"></textarea>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Ulasan</div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table align-items-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Ulasan</th>
                                <th scope="col">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku->ulasan as $u)
                            <tr>
                                <td>
                                    <div class="row text-small">{{ $u->user->nama }}</div>
                                    <div class="row">{{ $u->ulasan }}</div>
                                </td>
                                <td>
                                    <i class="fas fa-star"></i> {{ $u->rating }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin>