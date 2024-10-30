<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SuratPenugasan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuratPenugasanRequest;
use App\Http\Resources\SuratPenugasanResource;
use App\Http\Requests\PenomoranSuratPenugasanRequest;
use App\Http\Requests\PersetujuanSuratPenugasanRequest;

class SuratPenugasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataQuery = SuratPenugasan::with(['peneliti.userRole.user.identitas', 'peneliti.penelitian', 'userRole.user', 'ketuaLppmRole.user'])->orderBy('is_disetujui', 'desc')->orderBy('tanggal_surat', 'desc');

        //untuk dapat role id admin atau jfu yang sedang login
        // $daftar_role = daftarAkses(auth()->user()->id);
        // $is_admin = cekRole($daftar_role, "Admin");
        // $is_jfu = cekRole($daftar_role, "JFU");
        // if (!$is_admin || !$is_jfu) {
        //     return response()->json(['status' => false, 'message' => 'Akses ditolak'], 403);
        // }

        // Filter berdasarkan pencarian
        if ($request->filled('status')) {
            if ($request->status == 'proses')
                $dataQuery->whereNull('is_disetujui');
            elseif ($request->status == 'penomoran')
                $dataQuery->where('is_disetujui', true)
                    ->where(function ($subQuery) {
                        $subQuery->whereNull('nomor_surat')->orWhere('nomor_surat', "");
                    });
            // $dataQuery->where('is_disetujui', true)->where('nomor_surat', "");
            elseif ($request->status == 'selesai')
                $dataQuery->where('is_disetujui', false)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('is_disetujui', true)->where('nomor_surat', '!=', "");
                    });
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $dataQuery->where(function ($query) use ($request) {
                $query->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('role', function ($roleQuery) use ($request) {
                        $roleQuery->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $default_limit = env('DEFAULT_LIMIT', 30);
        $limit = $request->filled('limit') ? $request->limit : $default_limit;
        $data = $dataQuery->paginate($limit);
        $resourceCollection = $data->getCollection()->map(function ($item) {
            return new SuratPenugasanResource($item);
        });
        $data->setCollection($resourceCollection);

        $dataRespon = [
            'status' => true,
            'message' => 'Pengambilan data dilakukan',
            'data' => $data,
        ];
        return response()->json($dataRespon);
    }

    public function suratTugasDosen(Request $request)
    {
        $dataQuery = SuratPenugasan::with(['peneliti.userRole.user.identitas', 'peneliti.penelitian', 'userRole.user', 'ketuaLppmRole.user'])->orderBy('is_disetujui', 'desc')->orderBy('tanggal_surat', 'desc');

        $daftar_role = daftarAkses(auth()->user()->id);
        $is_dosen = cekRole($daftar_role, "Dosen");
        if (!$is_dosen) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak'], 403);
        }
        $dataQuery->where('is_disetujui', true)
            ->where(function ($query) use ($is_dosen) {
                $query->whereHas('peneliti', function ($userQuery) use ($is_dosen) {
                    $userQuery->where('user_role_id', $is_dosen);
                });
            });

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $dataQuery->where(function ($query) use ($request) {
                $query->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('role', function ($roleQuery) use ($request) {
                        $roleQuery->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $default_limit = env('DEFAULT_LIMIT', 30);
        $limit = $request->filled('limit') ? $request->limit : $default_limit;
        $data = $dataQuery->paginate($limit);
        $resourceCollection = $data->getCollection()->map(function ($item) {
            return new SuratPenugasanResource($item);
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
    public function store(SuratPenugasanRequest $request)
    {
        try {
            //untuk dapat role id admin atau jfu yang sedang login
            // $daftar_role = daftarAkses(auth()->user()->id);
            // $is_admin = cekRole($daftar_role, "Admin");
            // $is_jfu = cekRole($daftar_role, "JFU");
            // if (!$is_admin || !$is_jfu) {
            //     return response()->json(['status' => false, 'message' => 'Akses ditolak'], 403);
            // }

            DB::beginTransaction();
            $data = SuratPenugasan::create($request->validated());
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
            //untuk dapat role id admin atau jfu yang sedang login
            // $daftar_role = daftarAkses(auth()->user()->id);
            // $is_admin = cekRole($daftar_role, "Admin");
            // $is_jfu = cekRole($daftar_role, "JFU");
            // if (!$is_admin || !$is_jfu) {
            //     return response()->json(['status' => false, 'message' => 'Akses ditolak'], 403);
            // }

            $data = SuratPenugasan::with(['peneliti.penelitian', 'userRole.user'])->where('id', $id)->firstOrFail();

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => new SuratPenugasanResource($data)
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
    public function update(SuratPenugasanRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = SuratPenugasan::where('id', $id)->firstOrFail();
            $data->update($request->validated());
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
            $data = SuratPenugasan::where('id', $id)->firstOrFail();
            $data->delete();
            DB::commit();
            return response()->json(null, 204);
            // return response()->json(['status' => true, 'message' => 'hapus data berhasil dilakukan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat menghapus : ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    //persetujuan surat penugasan ketua lppm
    public function persetujuanSuratPenugasan(PersetujuanSuratPenugasanRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_ketua_lppm = cekRole($daftar_role, "Ketua");

            // if (!$is_admin && $is_ketua_lppm !== $validated['ketua_lppm_role_id']) {
            if ($is_ketua_lppm !== (int)$validated['ketua_lppm_role_id']) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $data = SuratPenugasan::where('id', $id)->firstOrFail();
            $data_save = $request->validated();
            $data_save['persetujuan_at'] = Carbon::now()->toIso8601String();;
            $data->updateQuietly($data_save);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'persetujuan penugasan berhasil dilakukan', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat persetujuan penugasan : ' . $e->getMessage(), 'data' => null], 500);
        }
    }


    //penomoran surat penugasan ketua lppm
    public function penomoranSuratPenugasan(PenomoranSuratPenugasanRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            //untuk dapat role id admin atau dosen yang sedang login
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_ketua_lppm = cekRole($daftar_role, "Ketua");

            if (!$is_admin && $is_ketua_lppm !== $validated['ketua_lppm_role_id']) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $data = SuratPenugasan::where('id', $id)->firstOrFail();
            $data->update($request->validated());
            DB::commit();
            return response()->json(['status' => true, 'message' => 'penomoran surat berhasil dilakukan', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat nomor_surat : ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
