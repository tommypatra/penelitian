<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Peneliti;
use App\Models\RoleUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

if (!function_exists('daftarAkses')) {
    function daftarAkses($user_id)
    {
        $listAkses = [];
        $getUser = User::with(['userRole.role'])->where('id', $user_id)->first();
        if (is_null($getUser)) {
            return [];
        }

        foreach ($getUser->userRole as $i => $dt) {
            $listAkses[] = ['user_role_id' => $dt->id, 'user_id' => $dt->user_id, 'role' => $dt->role->nama, 'role_id' => $dt->role_id];
        }
        return json_decode(json_encode($listAkses));
    }
}


if (!function_exists('getEmailsByRoles')) {
    function getEmailsByRoles(array $roleNames)
    {
        return User::with(['userRole.role'])
            ->whereHas('userRole.role', function ($query) use ($roleNames) {
                $query->whereIn('nama', $roleNames);
            })
            ->distinct()
            ->pluck('email');
    }
}


if (!function_exists('dataPeneliti')) {
    function dataPeneliti($user_role_id, $penelitian_id)
    {
        $data = Peneliti::with(['penelitian', 'userRole.user'])
            ->where('user_role_id', $user_role_id)
            ->where('penelitian_id', $penelitian_id)
            ->first();

        return $data;
    }
}


if (!function_exists('cekRole')) {

    function cekRole($daftar_role, $role_name)
    {
        $aksesArray = json_decode(json_encode($daftar_role), true);
        foreach ($aksesArray as $aksesItem) {
            if ($aksesItem['role'] === $role_name) {
                return $aksesItem['user_role_id'];
            }
        }
        return false;
    }
}

if (!function_exists('peneliti')) {

    function peneliti($id)
    {
        $list = [];
        $data = Peneliti::with(['userRole'])->where('id', $id)->first();
        if (is_null($data)) {
            return [];
        }

        return json_decode(json_encode($data));
    }
}

if (!function_exists('anchor')) {
    function anchor($url, $text)
    {
        return '<a href="' . $url . '">' . $text . '</a>';
    }
}

if (!function_exists('dbDateTimeFormat')) {
    function dbDateTimeFormat($waktuDb, $format = 'Y-m-d H:i:s')
    {
        return Carbon::parse($waktuDb)->timezone('Asia/Makassar')->format($format);
    }
}

if (!function_exists('generateUniqueFileName')) {
    function generateUniqueFileName()
    {
        return $randomString = time() . Str::random(22);
    }
}

if (!function_exists('generateSlug')) {
    function generateSlug($judul, $waktu)
    {
        $disallowed_chars = array(
            '!',
            '@',
            '#',
            '$',
            '%',
            '^',
            '&',
            '*',
            '(',
            ')',
            '+',
            '=',
            '{',
            '}',
            '[',
            ']',
            '|',
            '\\',
            ';',
            ':',
            '"',
            '<',
            '>',
            ',',
            '.',
            '/',
            '?',
            ' ',
            "'",
            ' '
        );
        $judul = str_replace(' ', '-', $judul);
        $judul = str_replace($disallowed_chars, ' ', $judul);
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $judul));

        $timestamp = strtotime($waktu);

        $tgl = date('y', $timestamp) + date('j', $timestamp) + date('n', $timestamp) + date('w', $timestamp);
        $waktu = date('H', $timestamp) + date('i', $timestamp);
        // $tanggal = date('ymd', strtotime($waktu));
        // $waktu = date('his', strtotime($waktu));
        // $tanggal = date('ymd', strtotime($waktu));
        // $waktu = date('his', strtotime($waktu));

        $generateWaktu = ($tgl + $waktu + rand(1, 999)) . '-' . date('s', $timestamp);
        // $finalSlug = date('ymd', $timestamp) . '-' . $slug . '-' . $generateWaktu;
        $finalSlug = $slug . '-' . $generateWaktu;
        return $finalSlug;
    }
}

if (!function_exists('ukuranFile')) {
    function ukuranFile($size)
    {
        $satuan = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $size >= 1024 && $i < 4; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . ' ' . $satuan[$i];
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($request, $reqFileName = 'file', $storagePath = null, $fileName = null)
    {
        try {
            $uploadedFile = $request->file($reqFileName);
            if (!$uploadedFile->isValid()) {
                return false;
            }

            $originalFileName = $uploadedFile->getClientOriginalName();
            $ukuranFile = $uploadedFile->getSize();
            $tipeFile = $uploadedFile->getMimeType();
            $ext = $uploadedFile->getClientOriginalExtension();
            if (!$storagePath)
                $storagePath = 'uploads/' . date('Y') . '/' . date('m');

            if (!File::isDirectory(public_path($storagePath))) {
                File::makeDirectory(public_path($storagePath), 0755, true);
            }

            if (!$fileName)
                $fileName = generateUniqueFileName();
            $fileName .= '.' . $ext;

            $uploadedFile->move(public_path($storagePath), $fileName);
            $fileFullPath = public_path($storagePath . '/' . $fileName);
            chmod($fileFullPath, 0755);
            $path = $storagePath . '/' . $fileName;
            return [
                'path' => $path,
                'jenis' => $tipeFile,
                'ukuran' => ($ukuranFile / 1024),
            ];
        } catch (\Exception $e) {
            return 'Gagal mengunggah file. ' . $e->getMessage();
        }
    }
}

if (!function_exists('updateTokenUsed')) {
    function updateTokenUsed()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $token = $user->tokens->last();
            if ($token) {
                $token->forceFill([
                    'created_at' => now(),
                    'last_used_at' => now(),
                ])->save();
            }
        }
    }
}

if (!function_exists('ambilKata')) {
    function ambilKata($text, $limit = 25)
    {
        $text = strip_tags($text);
        $words = preg_split("/[\s,]+/", $text);
        $shortenedText = implode(' ', array_slice($words, 0, $limit));
        if (str_word_count($text) > $limit) {
            $shortenedText .= '...';
        }
        return $shortenedText;
    }
}

if (!function_exists('enkrip')) {
    function enkrip($text)
    {
        $key = Carbon::now()->format('Y-m-d');
        $enc = Crypt::encryptString($text, $key);

        return $enc;
    }
}

if (!function_exists('dekrip')) {
    function dekrip($dectext)
    {
        $key = Carbon::now()->format('Y-m-d');
        $dec = Crypt::decryptString($dectext, $key);
        return $dec;
    }
}
