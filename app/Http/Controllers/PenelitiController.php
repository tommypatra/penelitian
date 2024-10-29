<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peneliti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PenelitiRequest;
use App\Http\Requests\VerifikasiRequest;
use App\Http\Resources\PenelitiResource;

class PenelitiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataQuery = Peneliti::with(['penelitian.dokumen.dokumenPeneliti', 'adminRole.user', 'userRole.user.identitas', 'suratPenugasan'])->orderBy('judul', 'asc');

        //untuk dapat role id admin atau dosen yang sedang login
        $daftar_role = daftarAkses(auth()->user()->id);
        $is_admin = cekRole($daftar_role, "Admin");
        $is_dosen = cekRole($daftar_role, "Dosen");

        if (!$is_admin)
            if ($is_dosen) {
                $dataQuery->where('user_role_id', $is_dosen);
            } else {
                return response()->json(['status' => false, 'message' => 'Akses ditolak'], 403);
            }

        // Filter berdasarkan pencarian
        if ($request->filled('is_selesai')) {
            $dataQuery->where('is_selesai', true);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('id')) {
            $dataQuery->where('id', $request->id);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $dataQuery->where(function ($query) use ($request) {
                $query->whereHas('penelitian', function ($penelitianQuery) use ($request) {
                    $penelitianQuery->where('nama', 'like', '%' . $request->search . '%');
                })
                    ->orwhereHas('adminRole.user', function ($adminQuery) use ($request) {
                        $adminQuery->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('userRole.user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        } elseif ($request->filled('tahap')) {
            if ($request->tahap == "verifikasi") {
                // $dataQuery->where('is_selesai', true)->whereNull('is_valid');
                $dataQuery->where('is_selesai', true)->where(function ($query) {
                    $query->where('is_valid', false)
                        ->orWhereNull('is_valid');
                });
            }
        }


        $default_limit = env('DEFAULT_LIMIT', 30);
        $limit = $request->filled('limit') ? $request->limit : $default_limit;
        $data = $dataQuery->paginate($limit);
        $resourceCollection = $data->getCollection()->map(function ($item) {
            return new PenelitiResource($item);
        });
        $data->setCollection($resourceCollection);

        $dataRespon = [
            'status' => true,
            'message' => 'Pengambilan data dilakukan',
            'data' => $data,
        ];
        return response()->json($dataRespon);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenelitiRequest $request)
    {
        try {
            DB::beginTransaction();
            $data_save = $request->validated();
            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");
            if (!$is_admin && $is_dosen !== $data_save['user_role_id']) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }
            $data = Peneliti::create($data_save);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'data baru berhasil dibuat', 'data' => $data], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat membuat data baru: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Peneliti::with(['penelitian.dokumen.dokumenPeneliti', 'adminRole.user', 'userRole.user.identitas', 'suratPenugasan']);
            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");

            $dataQuery = $data->where('id', $id)->firstOrFail();
            if (!$is_admin && $is_dosen !== $dataQuery->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => new PenelitiResource($dataQuery),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenelitiRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data_save = $request->validated();

            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");
            $data = Peneliti::where('id', $id)->firstOrFail();
            if (!$is_admin && $is_dosen !== $data->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Anda tidak memiliki izin untuk memperbarui penelitian ini.'], 403);
            }

            $data->update($data_save);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'berhasil diperbarui', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat memperbarui : ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");

            $data = Peneliti::where('id', $id)->firstOrFail();
            if (!$is_admin && $is_dosen !== $data->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $data->delete();
            DB::commit();
            return response()->json(null, 204);
            // return response()->json(['status' => true, 'message' => 'hapus data berhasil dilakukan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat menghapus : ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function finalisasiPeneliti(string $id)
    {
        try {
            DB::beginTransaction();
            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");
            $data = Peneliti::where('id', $id)->firstOrFail();
            if (!$is_admin && $is_dosen !== $data->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $data_save['is_selesai'] = true;
            if ($data->is_selesai)
                $data_save['is_selesai'] = false;

            $data->update($data_save);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'finalisasi penelitian berhasil diperbarui', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat memperbarui finalisasi penelitian : ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function verifikasiPeneliti(VerifikasiRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data_save = $request->validated();

            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_jfu = cekRole($daftar_role, "JFU");
            if (!$is_admin && $is_jfu) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $data_save['admin_role_id'] = $is_jfu;
            $data_save['validated_at'] = Carbon::now()->toIso8601String();
            //jika tidak valid maka is_selesai akan terbuka
            if (!$data_save['is_valid']) {
                $data_save['is_selesai'] = false;
            }

            $data = Peneliti::where('id', $id)->firstOrFail();
            if (!$data->is_selesai) {
                return response()->json(['status' => false, 'message' => 'penelitian ini belum selesai'], 422);
            }

            $data->updateQuietly($data_save);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'verifikasi penelitian berhasil dilakukan', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat verifikasi penelitian : ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
