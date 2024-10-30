<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function cekAkses($grup)
    {
        try {
            $daftar_role = daftarAkses(auth()->user()->id);
            $user_role_id = cekRole($daftar_role, $grup);
            if ($user_role_id) {
                return response()->json([
                    'status' => true,
                    'message' => 'Akses diterima',
                    'data' => ['user_role_id' => $user_role_id],
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak : ' . $e->getMessage()], 403);
        }
    }

    public function setSession(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Kombinasi email dan password tidak valid',
            ], 404);
        }
        $user = Auth::user();
        Auth::login($user);
        $respon_data = [
            'message' => 'Proses login selesai dilakukan',
        ];
        return response()->json($respon_data, 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function session()
    {
        dd(auth()->user());
    }

    public function login()
    {
        return view('login');
    }

    public function dashboard()
    {
        return view('akun.dashboard');
    }

    public function unitKerja()
    {
        return view('akun.unit_kerja');
    }

    public function pangkat()
    {
        return view('akun.pangkat');
    }

    public function role()
    {
        return view('akun.role');
    }

    public function jenisPenelitian()
    {
        return view('akun.jenis_penelitian');
    }

    public function user()
    {
        return view('akun.user');
    }

    public function jadwalPenelitian()
    {
        return view('akun.jadwal_penelitian');
    }

    public function dokumenPenelitian()
    {
        return view('akun.dokumen_penelitian');
    }

    public function daftarPenelitian()
    {
        return view('akun.daftar_penelitian');
    }

    public function timelinePenelitan($peneliti_id)
    {
        return view('akun.timeline', ['peneliti_id' => $peneliti_id]);
    }

    public function verifikasi()
    {
        return view('akun.verifikasi');
    }

    public function pengelolaSuratPenugasan()
    {
        return view('akun.pengelola_surat_penugasan');
    }

    public function dosenSuratPenugasan()
    {
        return view('akun.dosen_surat_penugasan');
    }
}
