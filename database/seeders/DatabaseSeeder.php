<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Dokumen;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pangkat;
use App\Models\Peneliti;
use App\Models\UserRole;
use App\Models\Identitas;
use App\Models\UnitKerja;
use App\Models\Penelitian;
use App\Models\JenisPenelitian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $dtdef = [
            ['nama' => 'Admin'],
            ['nama' => 'Ketua'],
            ['nama' => 'JFU'],
            ['nama' => 'Dosen'],
        ];

        foreach ($dtdef as $dt) {
            Role::create([
                'nama' => $dt['nama'],
            ]);
        }

        $dtdef = [
            ['name' => 'Muhammad Shaleh Assingkily', 'email' => 'muhammadshalehassingkily@iainkendari.ac.id'],
            ['name' => 'Abdul Kadir', 'email' => 'abdir_edu@iainkendari.ac.id'],
            ['name' => 'Sumardona', 'email' => 'sumardona@iainkendari.ac.id'],
            ['name' => 'Arif Tarawe', 'email' => 'arif@iainkendari.ac.id'],
            ['name' => 'Fahmi Gunawan', 'email' => 'fgunawan@iainkendari.ac.id'],
        ];

        foreach ($dtdef as $dt) {
            User::create([
                'name' => $dt['name'],
                'email' => $dt['email'],
                'password' => Hash::make('00000000'),
            ]);
        }


        //role user
        $dtdef = [
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 1, 'role_id' => 2],
            ['user_id' => 1, 'role_id' => 3],
            ['user_id' => 1, 'role_id' => 4], //4
            ['user_id' => 2, 'role_id' => 2],
            ['user_id' => 3, 'role_id' => 3],
            ['user_id' => 4, 'role_id' => 4], //7
        ];
        foreach ($dtdef as $dt) {
            UserRole::create([
                'user_id' => $dt['user_id'],
                'role_id' => $dt['role_id'],
            ]);
        }

        //pangkat
        $dtdef = [
            ['gol' => 'Non', 'nama' => 'Non PNS', 'urut' => 0],
            ['gol' => 'II/a', 'nama' => 'Pengatur Muda', 'urut' => 1],
            ['gol' => 'II/b', 'nama' => 'Pengatur Muda Tk. I', 'urut' => 2],
            ['gol' => 'II/c', 'nama' => 'Pengatur', 'urut' => 3],
            ['gol' => 'II/d', 'nama' => 'Pengatur Tk. I', 'urut' => 4],
            ['gol' => 'III/a', 'nama' => 'Penata Muda', 'urut' => 5],
            ['gol' => 'III/b', 'nama' => 'Penata Muda Tk. I', 'urut' => 6],
            ['gol' => 'III/c', 'nama' => 'Penata', 'urut' => 7],
            ['gol' => 'III/d', 'nama' => 'Penata Tk. I', 'urut' => 8],
            ['gol' => 'IV/a', 'nama' => 'Pembina', 'urut' => 9],
            ['gol' => 'IV/b', 'nama' => 'Pembina Tk. I', 'urut' => 10],
            ['gol' => 'IV/c', 'nama' => 'Pembina Utama Muda', 'urut' => 11],
            ['gol' => 'IV/d', 'nama' => 'Pembina Utama Madya', 'urut' => 12],
            ['gol' => 'IV/e', 'nama' => 'Pembina Utama', 'urut' => 13],
        ];
        foreach ($dtdef as $dt) {
            Pangkat::create([
                'gol' => $dt['gol'],
                'nama' => $dt['nama'],
                'urut' => $dt['urut'],
            ]);
        }

        //jenis penelitian
        $dtdef = [
            ['nama' => 'Litabdimas'],
            ['nama' => 'Non Litabdimas'],
        ];
        foreach ($dtdef as $dt) {
            JenisPenelitian::create([
                'nama' => $dt['nama'],
            ]);
        }

        //unit kerja
        $dtdef = [
            ['nama' => 'Rektorat', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'FATIK', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'FAKSYAR', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'FUAD', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'PASCA', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'LPPM', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'LPM', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'SPI', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'UPT TIPD', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'UPT PERPUSTAKAAN', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'UPT BAHASA', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'UPT MAHAD', 'parent_id' => null, 'is_pilihan' => 0],
            ['nama' => 'Prodi. PAI (S1)', 'parent_id' => 2], //13
            ['nama' => 'Prodi. PBA (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. MPI (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. PGMI (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. PIAUD (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. TBI (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. TIPA (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. TBLG (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. TFSK (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. TMTK (S1)', 'parent_id' => 2],
            ['nama' => 'Prodi. HKI (S1)', 'parent_id' => 3],
            ['nama' => 'Prodi. HES (S1)', 'parent_id' => 3],
            ['nama' => 'Prodi. HTN (S1)', 'parent_id' => 3],
            ['nama' => 'Prodi. KPI (S1)', 'parent_id' => 4],
            ['nama' => 'Prodi. BPI (S1)', 'parent_id' => 4],
            ['nama' => 'Prodi. MD (S1)', 'parent_id' => 4],
            ['nama' => 'Prodi. IQT/IAT (S1)', 'parent_id' => 4],
            ['nama' => 'Prodi. MPI (S2)', 'parent_id' => 5],
            ['nama' => 'Prodi. PAI (S2)', 'parent_id' => 5],
            ['nama' => 'Prodi. HI (S2)', 'parent_id' => 5],
            ['nama' => 'Prodi. ESY (S2)', 'parent_id' => 5],
            ['nama' => 'Prodi. PBA (S2)', 'parent_id' => 5],
            ['nama' => 'Prodi. ESY (S1)', 'parent_id' => 6],
            ['nama' => 'Prodi. PBS (S1)', 'parent_id' => 6],
            ['nama' => 'Prodi. MBS (S1)', 'parent_id' => 6],
        ];
        foreach ($dtdef as $dt) {
            UnitKerja::create([
                'nama' => $dt['nama'],
                'parent_id' => $dt['parent_id'],
            ]);
        }

        //identitas user
        $dtdef = [
            ['user_id' => 1, 'jabatan' => null, 'gelar_depan' => null, 'gelar_belakang' => null, 'jenis_kelamin' => 'L', 'no_hp' => '0852091720987', 'foto' => null, 'nidn' => '0091876309', 'nip' => '198510212009011008', 'unit_kerja_id' => 1, 'pangkat_id' => null],
            ['user_id' => 2, 'jabatan' => 'Lektor Kepala/ Ketua LPPM', 'gelar_depan' => 'Dr', 'gelar_belakang' => 'M.Pd', 'jenis_kelamin' => 'L', 'no_hp' => '085201987632', 'foto' => null, 'nidn' => '7164538290', 'nip' => '196810212001011001', 'unit_kerja_id' => 6, 'pangkat_id' => 9],
            ['user_id' => 3, 'jabatan' => null, 'gelar_depan' => null, 'gelar_belakang' => 'SH', 'jenis_kelamin' => 'L', 'no_hp' => '085231245455', 'foto' => null, 'nidn' => '0098667810', 'nip' => '197810212004011002', 'unit_kerja_id' => 6, 'pangkat_id' => 6],
            ['user_id' => 4, 'jabatan' => 'Lektor Kepala/ Kapus Pengabdian', 'gelar_depan' => 'Dr', 'gelar_belakang' => 'S.Si., M.Hum', 'jenis_kelamin' => 'L', 'no_hp' => '085342537654', 'foto' => null, 'nidn' => '0098090098', 'nip' => '198210212005011007', 'unit_kerja_id' => 14, 'pangkat_id' => 7],
        ];

        foreach ($dtdef as $dt) {
            Identitas::create([
                'user_id' => $dt['user_id'],
                'gelar_depan' => $dt['gelar_depan'],
                'gelar_belakang' => $dt['gelar_belakang'],
                'jenis_kelamin' => $dt['jenis_kelamin'],
                'no_hp' => $dt['no_hp'],
                'jabatan' => $dt['jabatan'],
                'nidn' => $dt['nidn'],
                'nip' => $dt['nip'],
                'unit_kerja_id' => $dt['unit_kerja_id'],
                'pangkat_id' => $dt['pangkat_id'],
            ]);
        }


        //Penelitian
        $dtdef = [
            ['nama' => 'Penelitan Litabdimas Periode 1', 'jenis_penelitian_id' => 1, 'tahun' => date('Y'), 'daftar_mulai' => date('Y-m-d'), 'daftar_selesai' => date('Y-m-30'), 'user_role_id' => 1],
            ['nama' => 'Penelitan Mandiri Semester 1', 'jenis_penelitian_id' => 2, 'tahun' => date('Y'), 'daftar_mulai' => date('Y-m-d'), 'daftar_selesai' => date('Y-m-30'), 'user_role_id' => 1],
        ];

        foreach ($dtdef as $dt) {
            Penelitian::create([
                'nama' => $dt['nama'],
                'jenis_penelitian_id' => $dt['jenis_penelitian_id'],
                'tahun' => $dt['tahun'],
                'daftar_mulai' => $dt['daftar_mulai'],
                'daftar_selesai' => $dt['daftar_selesai'],
                'user_role_id' => $dt['user_role_id'],
            ]);
        }

        //Dokumen
        $dtdef = [
            ['penelitian_id' => 1, 'nama' => 'Abstrak', 'jenis' => 'syarat', 'tipe_file' => 'pdf', 'is_wajib' => 1, 'keterangan' => 'lampirkan abstrak dengan 2 bahasa indonesia dan inggris'],
            ['penelitian_id' => 1, 'nama' => 'Screenshoot Litabdimas', 'jenis' => 'syarat', 'tipe_file' => 'gambar', 'is_wajib' => 1, 'keterangan' => 'silakan screenshoot bukti kelulusan dari laman litabdimas'],
            ['penelitian_id' => 1, 'nama' => 'Naskah Jurnal', 'jenis' => 'output', 'tipe_file' => 'pdf', 'is_wajib' => 1, 'keterangan' => 'silakan upload naskah jurnal yang telah terpublikasi yang di download dari jurnal penerbit'],
            ['penelitian_id' => 2, 'nama' => 'Abstrak', 'jenis' => 'syarat', 'tipe_file' => 'pdf', 'is_wajib' => 1, 'keterangan' => 'lampirkan abstrak minimal bahasa indonesia'],
            ['penelitian_id' => 2, 'nama' => 'Naskah Jurnal', 'jenis' => 'output', 'tipe_file' => 'pdf', 'is_wajib' => 1, 'keterangan' => 'silakan upload naskah jurnal yang telah akan dipublikasi'],
        ];

        foreach ($dtdef as $dt) {
            Dokumen::create([
                'nama' => $dt['nama'],
                'jenis' => $dt['jenis'],
                'tipe_file' => $dt['tipe_file'],
                'is_wajib' => $dt['is_wajib'],
                'penelitian_id' => $dt['penelitian_id'],
                'keterangan' => $dt['keterangan'],
            ]);
        }

        //peneliti
        $dtdef = [
            ['penelitian_id' => 1, 'user_role_id' => 4, 'judul' => 'Teknik Menggunakan AI dengan Bijak'],
            ['penelitian_id' => 2, 'user_role_id' => 4, 'judul' => 'Membuat komponen mobil dengan baik dan benar'],
            ['penelitian_id' => 1, 'user_role_id' => 7, 'judul' => 'Pengaruh Bahasa Pada Kondisi Psikologi'],
            ['penelitian_id' => 2, 'user_role_id' => 7, 'judul' => 'Bahasa Daerah Mulai Terancam Punah'],
        ];

        foreach ($dtdef as $dt) {
            Peneliti::create([
                'penelitian_id' => $dt['penelitian_id'],
                'user_role_id' => $dt['user_role_id'],
                'judul' => $dt['judul'],
            ]);
        }
    }
}
