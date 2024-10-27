<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRoleRequest;
use App\Http\Resources\UserRoleResource;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataQuery = UserRole::with(['user', 'role'])->orderBy('id', 'asc');

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
        // Filter berdasarkan pencarian
        if ($request->filled('user_id')) {
            $dataQuery->where(function ($query) use ($request) {
                $query->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('user_id', $request->user_id);
                });
            });
        }


        $default_limit = env('DEFAULT_LIMIT', 30);
        $limit = $request->filled('limit') ? $request->limit : $default_limit;
        $data = $dataQuery->paginate($limit);
        $resourceCollection = $data->getCollection()->map(function ($item) {
            return new UserRoleResource($item);
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
    public function store(UserRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = UserRole::create($request->validated());
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
            $dataQuery = UserRole::with(['user.identitas', 'role'])->where('id', $id)->firstOrFail();
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => new UserRoleResource($dataQuery)
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
     * Display the specified resource.
     */
    public function getUserRole($user_id)
    {
        try {
            $roles = Role::all(); // Mengambil semua role
            $user = User::where('id', $user_id)->firstOrFail();
            $user_role = UserRole::where("user_id", $user_id)->get(); // Mengambil user_role berdasarkan user_id
            $akses = [];
            foreach ($roles as $index_roles => $data_role) {
                $akses[$index_roles] = $data_role;
                $akses[$index_roles]['role_user'] = null;
                foreach ($user_role as $index_user_role => $data_user_role) {
                    if ($data_role->id === $data_user_role->role_id) {
                        $akses[$index_roles]['role_user'] = $data_user_role;
                    }
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'user' => $user,
                    'user_role' => $akses,
                ]
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
    public function update(UserRoleRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = UserRole::where('id', $id)->firstOrFail();
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
            $data = UserRole::where('id', $id)->firstOrFail();
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
