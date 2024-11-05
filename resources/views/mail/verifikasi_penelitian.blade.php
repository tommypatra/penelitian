<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Dokumen Penelitian</title>
</head>
<body>
    <h3>Verifikasi Dokumen Penelitian</h3>
    <p>Bismillah,</p> 
    <p>Peneliti {{ $data['name'] }} pada {{ $data['penelitian'] }} tahun {{ $data['tahun'] }} dengan judul {{ $data['judul'] }} telah diverifikasi oleh Admin/JFU LPPM IAIN Kendari</p>
    {!! $data['konten'] !!}
    <p>Terimakasih</p>
</body>
</html>