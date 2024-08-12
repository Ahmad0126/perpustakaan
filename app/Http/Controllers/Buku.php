<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\Buku as ModelsBuku;

class Buku extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Buku | Perpustakaan';
        $data['buku'] = ModelsBuku::orderBy('tanggal_rilis', 'DESC')->paginate(20);
        $data['kategori'] = Kategori::all();
        return view('buku', $data);
    }
    public function filter(Request $req){
        $data['title'] = 'Filter Buku | Perpustakaan';
        $data['kategori'] = Kategori::all();
        $where = [];
        if($req->id_kategori != null){
            $where['id_kategori'] = $req->id_kategori;
        }

        $buku = ModelsBuku::where($where);

        if($req->tanggal_rilis != null){
            $buku->where('tanggal_rilis', '>=', $req->tanggal_rilis);
        }

        $data['buku'] = $buku->paginate(20);
        return view('buku', $data);
    }
    public function laporan(Request $req){
        $data['title'] = 'Laporan Buku Perpustakaan';
        $data['subtitle'] = 'Daftar Buku';
        $where = [];
        if($req->id_kategori != null){
            $where['id_kategori'] = $req->id_kategori;
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang termasuk '.Kategori::find($req->id_kategori)->nama]);
        }

        $buku = ModelsBuku::where($where);

        if($req->tanggal_rilis != null){
            $buku->where('tanggal_rilis', '>=', $req->tanggal_rilis);
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang rilis dari tanggal '.date('j F Y', strtotime($req->tanggal_rilis))]);
        }

        $data['buku'] = $buku->get();

        $pdf = new Fpdf('L');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(280, 7, $data['title'], 0, 1, 'C');
        if($data['subtitle'] != 'Buku'){
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(280, 7, $data['subtitle'], 0, 1, 'C');
        }
        $pdf->Cell(190, 7, '', 0, 1);
        //title <th>
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(10, 5, 'No', 1, 0);
        $pdf->Cell(20, 5, 'Nomor Buku', 1, 0);
        $pdf->Cell(75, 5, 'Judul', 1, 0);
        $pdf->Cell(55, 5, 'Penulis', 1, 0);
        $pdf->Cell(55, 5, 'Penerbit', 1, 0);
        $pdf->Cell(35, 5, 'Tanggal Rilis', 1, 0);
        $pdf->Cell(15, 5, 'Kategori', 1, 0);
        $pdf->Cell(11, 5, 'Jumlah', 1, 1);

        $pdf->SetFont('Arial', '', 7);
        $no = 1;
        foreach($data['buku'] as $fer){
            $pdf->Cell(10, 5, $no++ , 1, 0);
            $pdf->Cell(20, 5, $fer->nomor_buku, 1, 0);
            $pdf->Cell(75, 5, $fer->judul, 1, 0);
            $pdf->Cell(55, 5, $fer->penulis, 1, 0);
            $pdf->Cell(55, 5, $fer->penerbit, 1, 0);
            $pdf->Cell(35, 5, date('j F Y', strtotime($fer->tanggal_rilis)), 1, 0);
            $pdf->Cell(15, 5, $fer->kategori->nama, 1, 0);
            $pdf->Cell(11, 5, $fer->jumlah, 1, 1);
        }
        $pdf->Output();
        exit;
    }
    public function tambah(Request $req){
        $req->validate([
            'judul' => 'required|max:128|unique:buku,judul',
            'penulis' => 'required|max:60',
            'penerbit' => 'required|max:60',
            'id_kategori' => 'required|integer',
            'jumlah' => 'required|integer',
            'tanggal_rilis' => 'required|date',
        ]);

        $kategori = Kategori::find($req->id_kategori);
        $k = count($kategori->buku) + 1;

        $buku = new ModelsBuku();
        $buku->penulis = $req->penulis;
        $buku->judul = $req->judul;
        $buku->penerbit = $req->penerbit;
        $buku->id_kategori = $req->id_kategori;
        $buku->jumlah = $req->jumlah;
        $buku->tanggal_rilis = $req->tanggal_rilis;
        $buku->nomor_buku = $kategori->nomor_rak.'-'.fake()->randomNumber(4, true);
        $buku->save();

        return redirect(route('buku'))->with('alert', 'Berhasil Menambahkan Buku');
    }
    public function detail($nomor){
        $data['buku'] = ModelsBuku::where('nomor_buku', $nomor)->get()->first();
        $data['title'] = 'Detail Buku | Perpustakaan';
        return view('datail_buku', $data);
    }
    public function edit(Request $req){
        $req->validate([
            'judul' => 'required|max:128|unique:buku,judul,'.$req->id.',id',
            'penulis' => 'required|max:60',
            'penerbit' => 'required|max:60',
            'id_kategori' => 'required|integer',
            'jumlah' => 'required|integer',
            'tanggal_rilis' => 'required|date',
        ]);

        $kategori = Kategori::find($req->id_kategori);
        $k = count($kategori->buku) + 1;

        $buku = ModelsBuku::find($req->id);
        $buku->penulis = $req->penulis;
        $buku->judul = $req->judul;
        $buku->penerbit = $req->penerbit;
        $buku->id_kategori = $req->id_kategori;
        $buku->jumlah = $req->jumlah;
        $buku->tanggal_rilis = $req->tanggal_rilis;
        $buku->nomor_buku = $kategori->nomor_rak.'-'.str_pad($k, 4, 0, STR_PAD_LEFT);
        $buku->save();

        return redirect(route('buku'))->with('alert', 'Berhasil Mengedit Buku');
    }
    public function hapus($id){
        ModelsBuku::destroy($id);
        return redirect(route('buku'))->with('alert', 'Berhasil Menghapus Buku');
    }
}
