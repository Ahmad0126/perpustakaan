<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPinjaman;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Pinjaman as ModelsPinjaman;
use Codedge\Fpdf\Fpdf\Fpdf;

class Pinjaman extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Pinjaman | Perpustakaan';
        if(Gate::allows('member')){
            $data['pinjaman'] = ModelsPinjaman::where('id_member', Auth::user()->member->id)->orderBy('tanggal_dipinjam', 'DESC')->paginate(20);
        }else{
            $data['pinjaman'] = DetailPinjaman::orderBy('id', 'DESC')->paginate(20);
        }
        $data['member'] = Member::all();
        return view('pinjaman', $data);
    }
    public function filter(Request $req){
        $data['title'] = 'Filter Pinjaman | Perpustakaan';
        $data['member'] = Member::all();
        $where = [];

        $pinjaman = DetailPinjaman::where($where);

        if($req->id_member != null){
            $pinjaman->whereRelation('pinjaman', 'id_member', $req->id_member);
        }
        if($req->tanggal_dipinjam != null){
            $pinjaman->whereRelation('pinjaman', 'tanggal_dipinjam', '>=', $req->tanggal_dipinjam);
        }

        if($req->status != null){
            $pinjaman->where('status', $req->status);
        }
        if($req->terlambat == 'true'){
            $pinjaman->where('tanggal_kembali', '<', date('Y-m-d'));
            $pinjaman->where('status', 'dipinjam');
        }

        $data['pinjaman'] = $pinjaman->orderBy('id', 'DESC')->paginate(20);
        return view('pinjaman', $data);
    }
    public function laporan(Request $req){
        $data['title'] = 'Laporan Peminjaman Perpustakaan';
        $data['subtitle'] = 'Buku';
        $where = [];
        
        $pinjaman = DetailPinjaman::where($where);

        if($req->id_member != null){
            $pinjaman->whereRelation('pinjaman', 'id_member', $req->id_member);
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang dipinjam oleh '.Member::find($req->id_member)->user->nama]);
        }
        if($req->tanggal_dipinjam != null){
            $pinjaman->whereRelation('pinjaman', 'tanggal_dipinjam', '>=', $req->tanggal_dipinjam);
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'dari tanggal '.date('j F Y', strtotime($req->tanggal_dipinjam))]);
        }

        if($req->status != null){
            $pinjaman->where('status', $req->status);
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang '.$req->status]);
        }
        if($req->terlambat == 'true'){
            $pinjaman->where('tanggal_kembali', '<', date('Y-m-d'));
            $pinjaman->where('status', 'dipinjam');
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang terlambat dikembalikan']);
        }

        $data['pinjaman'] = $pinjaman->orderBy('id', 'DESC')->get();

        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 7, $data['title'], 0, 1, 'C');
        if($data['subtitle'] != 'Buku'){
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(190, 7, $data['subtitle'], 0, 1, 'C');
        }
        $pdf->Cell(190, 7, '', 0, 1);
        //title <th>
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(6, 5, 'No', 1, 0);
        $pdf->Cell(20, 5, 'Nomor Buku', 1, 0);
        $pdf->Cell(35, 5, 'Peminjam', 1, 0);
        $pdf->Cell(60, 5, 'Judul', 1, 0);
        $pdf->Cell(25, 5, 'Tanggal Dipinjam', 1, 0);
        $pdf->Cell(25, 5, 'Tanggal Kembali', 1, 0);
        $pdf->Cell(20, 5, 'Status', 1, 1);

        $pdf->SetFont('Arial', '', 7);
        $no = 1;
        foreach($data['pinjaman'] as $fer){
            $pdf->Cell(6, 5, $no++ , 1, 0);
            $pdf->Cell(20, 5, $fer->buku->nomor_buku, 1, 0);
            $pdf->Cell(35, 5, $fer->pinjaman->member->user->nama, 1, 0);
            $pdf->Cell(60, 5, $fer->buku->judul, 1, 0);
            $pdf->Cell(25, 5, date('j F Y', strtotime($fer->pinjaman->tanggal_dipinjam)), 1, 0);
            $pdf->Cell(25, 5, date('j F Y', strtotime($fer->tanggal_kembali)), 1, 0);
            $pdf->Cell(20, 5, $fer->status, 1, 1);
        }
        $pdf->Output();
        exit;
    }
    public function tambah(Request $req){
        $req->validate([
            'nomor_buku' => 'required|exists:buku,nomor_buku',
            'id_member' => 'required|integer',
        ]);

        $buku = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();

        $pinjaman = new ModelsPinjaman();
        $pinjaman->id_buku = $buku->id;
        $pinjaman->id_member = $req->id_member;
        $pinjaman->status = 'dipinjam';
        $pinjaman->tanggal_kembali = date('Y-m-d', strtotime('+7 day', time()));
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->save();

        $buku->jumlah = $buku->jumlah - 1;
        $buku->save();

        return redirect(route('pinjaman'))->with('alert', 'Berhasil Meminjam Buku');
    }
    public function pinjam(Request $req){
        $req->validate([
            'id' => 'required|exists:buku,id',
        ]);
        $pinjaman = new ModelsPinjaman();
        $pinjaman->id_buku = $req->id;
        $pinjaman->id_member = Auth::user()->member->id;
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->tanggal_kembali = date('Y-m-d', strtotime('+7 day', time()));
        $pinjaman->status = 'dipinjam';
        $pinjaman->save();

        $buku = Buku::find($req->id);
        $buku->jumlah = $buku->jumlah - 1;
        $buku->save();

        return back()->with('alert', 'Berhasil Meminjam Buku');
    }
    public function edit(Request $req){
        $req->validate([
            'nomor_buku' => 'required|exists:buku,nomor_buku',
            'id_member' => 'required|integer',
        ]);
        
        $buku = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();
        $pinjaman = ModelsPinjaman::where(['id_buku' => $buku->id, 'status' => 'dipinjam', 'id_member' => $req->id_member])->get()->first();
        if($pinjaman == null){
            return redirect(route('pinjaman'))->withErrors('Buku Sedang tidak Dipinjam');
        }

        $pinjaman->status = 'dikembalikan';
        $pinjaman->save();

        $buku->jumlah = $buku->jumlah + 1;
        $buku->save();

        return redirect(route('pinjaman'))->with('alert', 'Berhasil Mengembalikan Buku');
    }
    public function kembalikan(Request $req){
        if($req->nomor_buku != null){
            $req->validate([
                'nomor_buku' => 'required|exists:buku,nomor_buku',
                'id_member' => 'required|exists:pinjaman,id_member',
            ]);
            $b = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();
            $pinjaman = ModelsPinjaman::where(['id_member' => $req->id_member])->get()->last();
            $buku = DetailPinjaman::where(['id_buku' => $b->id, 'id_pinjaman' => $pinjaman->id, 'status' => 'dipinjam'])->get()->first();
        }else{
            $req->validate([
                'id' => 'required|exists:detail_pinjaman,id',
            ]);
            $buku = DetailPinjaman::find($req->id);
        }
        if($buku != null){
            $buku->status = 'dikembalikan';
            $buku->save();
        }else{
            return back()->withErrors('Buku sudah dikembalikan');
        }

        return back()->with('alert', 'Berhasil Mengembalikan Buku');
    }
    public function hapus($id){
        ModelsPinjaman::destroy($id);
        return redirect(route('pinjaman'))->with('alert', 'Berhasil Menghapus Pinjaman');
    }
}
