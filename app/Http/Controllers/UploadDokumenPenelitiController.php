<?php

namespace App\Http\Controllers;

use App\Models\DokumenPeneliti;
use App\Models\Identitas;
use Illuminate\Http\Request;
use App\Http\Requests\UploadDokumenPenelitiRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UploadDokumenPenelitiResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UploadDokumenPenelitiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataQuery = DokumenPeneliti::with(['dokumen', 'userRole.user' . 'peneliti.penelitian'])->orderBy('id', 'asc');

        $daftar_role = daftarAkses(auth()->user()->id);
        $is_admin = cekRole($daftar_role, "Admin");
        $is_dosen = cekRole($daftar_role, "Dosen");

        if (!$is_admin)
            if ($is_dosen) {
                $dataQuery->whereHas('peneliti', function ($userQuery) use ($is_dosen) {
                    $userQuery->where('user_role_id', $is_dosen);
                });
            } else {
                return response()->json(['status' => false, 'message' => 'Akses ditolak'], 403);
            }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $dataQuery->where(function ($query) use ($request) {
                $query->whereHas('dokumen', function ($userQuery) use ($request) {
                    $userQuery->where('nama', 'like', '%' . $request->search . '%');
                })->orwhereHas('peneliti.user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('userRole.user', function ($roleQuery) use ($request) {
                    $roleQuery->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        $limit = $request->filled('limit') ? $request->limit : 0;
        if ($limit) {
            $data = $dataQuery->paginate($limit);
            $resourceCollection = $data->getCollection()->map(function ($item) {
                return new UploadDokumenPenelitiResource($item);
            });
            $data->setCollection($resourceCollection);

            $dataRespon = [
                'status' => true,
                'message' => 'Pengambilan data dilakukan',
                'data' => $data,
            ];
        } else {
            $dataRespon = [
                'status' => true,
                'message' => 'Pengambilan data dilakukan',
                'data' => UploadDokumenPenelitiResource::collection($dataQuery->get()),
            ];
        }
        return response()->json($dataRespon);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadDokumenPenelitiRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");

            //validasi untuk cek kepemilikian penelitian
            $peneliti = peneliti($validated['peneliti_id']);
            if (!$is_admin && $is_dosen !== $peneliti->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $dokumen_path = $request->file('dokumen')->store('uploads/dokumens/' . date('Ym'), 'public'); // Mengunggah dokumen  ke storage
            $data_dokumen_peneliti = [
                'dokumen_id' => $validated['dokumen_id'],
                'peneliti_id' => $validated['peneliti_id'],
                'path' => $dokumen_path,
                'keterangan' => isset($validated['keterangan']) ? $validated['keterangan'] : null,
            ];
            $data = DokumenPeneliti::create($data_dokumen_peneliti);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'data berhasil diupload', 'data' => $data], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat upload data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");

            $dataQuery = DokumenPeneliti::with(['dokumen', 'userRole.user' . 'peneliti.penelitian'])->where('id', $id)->firstOrFail();
            if (!$is_admin && $is_dosen !== $dataQuery->peneliti->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => new UploadDokumenPenelitiResource($dataQuery),
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
    public function update(UploadDokumenPenelitiRequest $request, string $id)
    {
        Log::info($request->all()); // Tambahkan ini untuk memeriksa data
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");

            $data = DokumenPeneliti::with('peneliti')->where('id', $id)->firstOrFail();
            if (!$is_admin && $is_dosen !== $data->peneliti->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $dokumen_path = $data->path; // Ambil dokumen lama
            if ($request->hasFile('dokumen')) {
                if (Storage::disk('public')->exists($dokumen_path)) {
                    Storage::disk('public')->delete($dokumen_path);
                }
                $dokumen_path = $request->file('dokumen')->store('uploads/dokumens/' . date('Ym'), 'public'); // Mengunggah dokumen ke storage
            }
            $data_dokumen_peneliti = [
                'dokumen_id' => $validated['dokumen_id'],
                'peneliti_id' => $validated['peneliti_id'],
                'path' => $dokumen_path,
                'keterangan' => isset($validated['keterangan']) ? $validated['keterangan'] : null,
            ];
            $data->update($data_dokumen_peneliti);

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
            $daftar_role = daftarAkses(auth()->user()->id);
            $is_admin = cekRole($daftar_role, "Admin");
            $is_dosen = cekRole($daftar_role, "Dosen");

            $data = DokumenPeneliti::with('peneliti')->where('id', $id)->firstOrFail();
            if (!$is_admin && $is_dosen !== $data->peneliti->user_role_id) {
                return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
            }
            $dokumen_path = $data->path; // Ambil dokumen lama
            // if (Storage::disk('public')->exists($dokumen_path)) {
            Storage::disk('public')->delete($dokumen_path);
            // }
            $data->delete();

            DB::commit();
            return response()->json(null, 204);
            // return response()->json(['status' => true, 'message' => 'hapus data berhasil dilakukan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat menghapus : ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
