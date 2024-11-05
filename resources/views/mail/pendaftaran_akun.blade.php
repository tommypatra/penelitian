<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendaftaran Akun Permanen</title>
</head>
<body>
    <h3>Akun anda berhasil terdaftar di aplikasi kami</h3>

    <p>Bismillah,</p> 
    <p>hi, {{ $data['name'] }} terima kasih telah mendaftarkan email anda pada aplikasi permanen ini. anda sudah bisa login ke aplikasi permanen menggunakan user {{ $data['email'] }} dan password {{ $data['password'] }}</p>
   
    <p>Terimakasih</p>
</body>
</html>