<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Identitas;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataQuery = User::with(['identitas.unitKerja', 'identitas.pangkat', 'userRole.role'])->orderBy('name', 'asc');

        if ($request->filled('search')) {
            $dataQuery->where('name', 'like', '%' . $request->search . '%');
        }

        $default_limit = env('DEFAULT_LIMIT', 30);
        $limit = $request->filled('limit') ? $request->limit : $default_limit;
        $data = $dataQuery->paginate($limit);
        $resourceCollection = $data->getCollection()->map(function ($item) {
            return new UserResource($item);
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
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            // untuk tabel user
            $data_user = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']), // Mengenkripsi password
            ];
            $data['user'] = User::create($data_user);

            // untuk tabel identitas
            $fotoPath = 'images/user-avatar.png'; // default foto path
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('uploads/fotos', 'public'); // Mengunggah foto ke storage
            }
            $data_identitas = [
                'user_id' => $data['user']->id,
                'unit_kerja_id' => $validated['unit_kerja_id'],
                'pangkat_id' => $validated['pangkat_id'],
                'jabatan' => $validated['jabatan'],
                'foto' => $fotoPath,
                'gelar_depan' => isset($validated['gelar_depan']) ? $validated['gelar_depan'] : null,
                'gelar_belakang' => isset($validated['gelar_belakang']) ? $validated['gelar_belakang'] : null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp' => isset($validated['no_hp']) ? $validated['no_hp'] : null,
                'nip' => isset($validated['nip']) ? $validated['nip'] : null,
                'nidn' => isset($validated['nidn']) ? $validated['nidn'] : null,
            ];
            $data['identitas'] = Identitas::create($data_identitas);


            //simpan default user dosen
            $role_id_dosen = Role::where('nama', 'DOSEN')->firstOrFail();
            $data_user_role = [
                'user_id' => $data['user']->id,
                'role_id' => $role_id_dosen->id,
            ];
            $data['user_role'] = UserRole::create($data_user_role);


            DB::commit();
            return response()->json(['status' => true, 'message' => 'data baru berhasil dibuat', 'data' => $data], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat membuat data baru: ' . $e->getMessage()], 500);
        }
    }

    public function dataProfil()
    {
        return $this->show(auth()->user()->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $dataQuery = User::with(['identitas.unitKerja', 'identitas.pangkat', 'userRole.role'])->where('id', $id)->firstOrFail();
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => new UserResource($dataQuery)
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
    public function update(UserRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            // untuk tabel user
            $user = User::where('id', $id)->firstOrFail();
            $data_user = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];
            if (!empty($validated['password'])) {
                $data_user['password'] = bcrypt($validated['password']);
            }
            $user->update($data_user);

            // untuk tabel identitas
            $identitas = Identitas::where('user_id', $id)->firstOrFail();
            $fotoPath = $identitas->foto; // Ambil foto lama
            if ($request->hasFile('foto')) {
                //kalau bukan foto default maka hapus saja
                if ($fotoPath !== 'images/user-avatar.png') {
                    Storage::disk('public')->delete($fotoPath);
                }
                $fotoPath = $request->file('foto')->store('uploads/fotos', 'public'); // Mengunggah foto ke storage
            }
            $data_identitas = [
                'unit_kerja_id' => $validated['unit_kerja_id'],
                'pangkat_id' => $validated['pangkat_id'],
                'foto' => $fotoPath,
                'jabatan' => $validated['jabatan'],
                'gelar_depan' => isset($validated['gelar_depan']) ? $validated['gelar_depan'] : null,
                'gelar_belakang' => isset($validated['gelar_belakang']) ? $validated['gelar_belakang'] : null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp' => isset($validated['no_hp']) ? $validated['no_hp'] : null,
                'nip' => isset($validated['nip']) ? $validated['nip'] : null,
                'nidn' => isset($validated['nidn']) ? $validated['nidn'] : null,
            ];
            $identitas->update($data_identitas);

            // Simpan dalam variabel untuk response
            $data = [
                'user' => $user,
                'identitas' => $identitas,
            ];

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

            $identitas = Identitas::where('user_id', $id)->firstOrFail();
            $fotoPath = $identitas->foto; // Ambil foto lama
            if ($fotoPath !== 'images/user-avatar.png') {
                Storage::disk('public')->delete($fotoPath);
            }
            $identitas->delete();

            $user = User::where('id', $id)->firstOrFail();
            $user->delete();

            DB::commit();
            return response()->json(null, 204);
            // return response()->json(['status' => true, 'message' => 'hapus data berhasil dilakukan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'terjadi kesalahan saat menghapus : ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
