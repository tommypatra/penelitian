<?php

namespace App\Http\Controllers;

use App\Models\Peneliti;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use App\Models\DokumenPeneliti;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiRequest;
use App\Http\Resources\VerifikasiResource;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $id)
    {
        $dataQuery = Peneliti::with(['penelitian', 'userRole.user.identitas', 'adminRole.user.identitas'])->orderBy('judul', 'asc')->where('id', $id);

        if ($request->filled('search')) {
            $dataQuery->where(function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhereHas('userRole.user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('adminRole.user', function ($adminQuery) use ($request) {
                        $adminQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $limit = $request->filled('limit') ? $request->limit : 0;
        if ($limit) {
            $data = $dataQuery->paginate($limit);
            $resourceCollection = $data->getCollection()->map(function ($item) {
                return new VerifikasiResource($item);
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
                'data' => VerifikasiResource::collection($dataQuery->get()),
            ];
        }
        return response()->json($dataRespon);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $dataQuery = Peneliti::with(['penelitian', 'userRole.user.identitas', 'adminRole.user.identitas'])->orderBy('judul', 'asc')::where('id', $id)->firstOrFail();
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => new VerifikasiResource($dataQuery)
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
     * Store a newly created resource in storage.
     */
    public function simpanVerifikasiPeneliti(VerifikasiRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = Peneliti::where('id', $id)->firstOrFail();
            $data->update($request->validated());
            DB::commit();
            return response()->json(['status' => true, 'message' => 'berhasil diperbaharui', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat memperbarui : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function simpanVerifikasiBerkas(VerifikasiRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = DokumenPeneliti::where('id', $id)->firstOrFail();
            $data->update($request->validated());
            DB::commit();
            return response()->json(['status' => true, 'message' => 'berhasil diperbaharui', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat memperbarui : ' . $e->getMessage()], 500);
        }
    }
}
