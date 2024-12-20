<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class AuthController extends Controller
{
    public function index(AuthRequest $request)
    {

        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = User::with('identitas')->where('email', $request->email)->first();

            $daftarAkses = daftarAkses($user->id);
            // dd($daftarAkses);
            // die;
            $token = $user->createToken('api_token')->plainTextToken;
            // $token = $user->createToken('api-token', ['user_id' => $user->id, 'user_group' => $daftarAkses])->plainTextToken;
            $role_akses = $daftarAkses[0]->role;
            $user_role_id = $daftarAkses[0]->user_role_id;
            $respon_data = [
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'access_token' => $token,
                    'daftar_akses' => $daftarAkses,
                    'role_akses' => $role_akses,
                    'user_role_id' => $user_role_id,
                    'token_type' => 'Bearer',
                ]
            ];
            return response()->json($respon_data, 200);
        }
        return response()->json(['message' => 'user not found'], 404);
    }

    public function roleUser()
    {

        $daftarAkses = daftarAkses(Auth::user()->id);
        if (count($daftarAkses) < 1)
            return response()->json(['status' => false, 'message' => 'akses tidak ditemukan'], 404);

        $role_aksess = $daftarAkses[0]->role;
        $user_role_id = $daftarAkses[0]->user_role_id;
        $respon_data = [
            'status' => true,
            'message' => 'akses ditemukan',
            'data' => $daftarAkses,
        ];
        return response()->json($respon_data, 200);
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
            // Temukan atau buat pengguna berdasarkan email
            $user = User::with('identitas')->where('email', $email)->first();
            if (!$user)
                return redirect::to('login')->with('error', 'Login failed, user not found');

            // Login pengguna
            Auth::login($user);

            // Mengambil daftar akses pengguna
            $daftarAkses = daftarAkses($user->id);
            $token = $user->createToken('api_token')->plainTextToken;
            $role_akses = $daftarAkses[0]->role;
            $user_role_id = $daftarAkses[0]->user_role_id;

            $respon_data = [
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'access_token' => $token,
                    'daftar_akses' => $daftarAkses,
                    'role_akses' => $role_akses,
                    'user_role_id' => $user_role_id,
                    'token_type' => 'Bearer',
                ]
            ];
            // return Redirect::to('/dashboard');
            // Redirect ke halaman yang diinginkan dengan data pengguna dalam query string
            return redirect::to('login')->with('respon_google_login', $respon_data);

            // return response()->json($respon_data, 200);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Login failed, please try again.'], 500);
            return Redirect::to('login')->with('error', 'Login failed, please try again. ' . $e->getMessage());
        }
    }

    function tokenCek($grup_id)
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        if ($user_id) {
            // $token = auth()->user()->tokens->last();
            //mendapatkan user_group dari abilites
            // $daftar_akses = $token->abilities['user_group'];
            //mendapatkan user_group dari query 4 tabel kembali
            $daftar_akses = daftarAkses($user_id);
            $index = array_search($grup_id, array_column($daftar_akses, 'grup_id'));
            if ($index !== false) {
                return response()->json(['status' => true, 'message' => 'token valid'], 200);
            }
        }
        return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $user_id = $request->user() ? $request->user()->id : null;
        if ($user_id) {
            // $request->user()->tokens()->delete();
            $request->user()->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
