<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\Denda as ModelsDenda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Denda extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Denda | Perpustakaan';
        if(Gate::allows('petugas')){
            $data['denda'] = ModelsDenda::orderBy('id', 'DESC')->paginate(20);
            $data['member'] = Member::all();
        }else{
            $data['denda'] = ModelsDenda::where(['id_member' => Auth::user()->member->id])->orderBy('id', 'DESC')->paginate(20);
        }
        return view('denda', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'id_member' => 'required|exists:member,id',
            'nominal' => 'required|integer',
        ]);

        $denda = new ModelsDenda();
        $denda->id_member = $req->id_member;
        $denda->nominal = $req->nominal;
        $denda->tanggal = date('Y-m-d');
        $denda->status = 'belum dibayar';
        $denda->kode_verifikasi = fake()->regexify('[A-Z]{5}[0-9]{3}');
        $denda->save();

        return redirect(route('denda'))->with('alert', 'Berhasil Menambahkan Denda');
    }
    public function edit(Request $req){
        $req->validate([
            'id' => 'required|exists:denda,id',
            'nominal' => 'required|integer',
        ]);

        $denda = ModelsDenda::find($req->id);
        $denda->nominal = $req->nominal;
        $denda->save();

        return redirect(route('denda'))->with('alert', 'Berhasil Mengedit Denda');
    }
    public function hapus($id){
        ModelsDenda::destroy($id);
        return redirect(route('denda'))->with('alert', 'Berhasil Menghapus Denda');
    }
    public function bayar(Request $req){
        $req->validate([
            'id' => 'required|exists:denda,id',
            'kode_verifikasi' => 'required',
        ]);

        $denda = ModelsDenda::find($req->id);
        if($denda->kode_verifikasi != $req->kode_verifikasi){
            return redirect(route('denda'))->withErrors('Kode Verifikasi tidak valid');
        }

        $denda->tanggal_dibayar = date('Y-m-d');
        $denda->status = 'dibayar';
        $denda->save();

        return redirect(route('denda'))->with('alert', 'Berhasil Membayar Denda');
    }
    public function filter(Request $req){
        $data['title'] = 'Filter Denda | Perpustakaan';
        $data['member'] = Member::all();
        $where = [];

        $denda = ModelsDenda::where($where);

        if($req->id_member != null){
            $denda->where('id_member', $req->id_member);
        }
        if($req->tanggal_dipinjam != null){
            $denda->where('tanggal_dibuat', '>=', $req->tanggal_dibuat);
        }

        if($req->status != null){
            $denda->where('status', $req->status);
        }
        if($req->nominal != null){
            switch ($req->pembanding) {
                case 'lebih': $p = '>='; break;
                case 'kurang': $p = '<='; break;
                default: $p = '='; break;
            }
            $denda->where('nominal', $p, $req->nominal);
        }

        $data['denda'] = $denda->orderBy('id', 'DESC')->paginate(20);
        return view('denda', $data);
    }
    public function laporan(Request $req){
        $data['title'] = 'Laporan Denda Pengembalian Buku';
        $data['subtitle'] = 'Denda';
        $where = [];
        
        $denda = ModelsDenda::where($where);

        if($req->id_member != null){
            $denda->where('id_member', $req->id_member);
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang dibayar '.Member::find($req->id_member)->user->nama]);
        }
        if($req->tanggal_dibuat != null){
            $denda->where('tanggal_dibuat', '>=', $req->tanggal_dibuat);
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang dibuat dari tanggal '.date('j F Y', strtotime($req->tanggal_dibuat))]);
        }

        if($req->status != null){
            $denda->where('status', $req->status);
            $data['subtitle'] = implode(' ', [$data['subtitle'], 'yang '.$req->status]);
        }
        if($req->nominal != null){
            switch ($req->pembanding) {
                case 'lebih': $p = '>='; break;
                case 'kurang': $p = '<='; break;
                default: $p = '='; break;
            }
            $denda->where('nominal', $p, $req->nominal);
        }

        $data['denda'] = $denda->orderBy('id', 'DESC')->get();

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
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(8, 6, 'No', 1, 0);
        $pdf->Cell(45, 6, 'Member', 1, 0);
        $pdf->Cell(30, 6, 'Nominal', 1, 0);
        $pdf->Cell(30, 6, 'Tanggal Dibuat', 1, 0);
        $pdf->Cell(30, 6, 'Tanggal Dibayar', 1, 0);
        $pdf->Cell(20, 6, 'Status', 1, 0);
        $pdf->Cell(25, 6, 'Kode Verifikasi', 1, 1);

        $pdf->SetFont('Arial', '', 8);
        $no = 1;
        foreach($data['denda'] as $fer){
            $pdf->Cell(8, 6, $no++ , 1, 0);
            $pdf->Cell(45, 6, $fer->member->user->nama, 1, 0);
            $pdf->Cell(30, 6, 'Rp '.number_format($fer->nominal), 1, 0);
            $pdf->Cell(30, 6, date('j F Y', strtotime($fer->tanggal)), 1, 0);
            $pdf->Cell(30, 6, $fer->tanggal_dibayar != null ? date('j F Y', strtotime($fer->tanggal_dibayar)) : '-', 1, 0);
            $pdf->Cell(20, 6, $fer->status, 1, 0);
            $pdf->Cell(25, 6, $fer->kode_verifikasi, 1, 1);
        }
        $pdf->Output();
        exit;
    }
}
