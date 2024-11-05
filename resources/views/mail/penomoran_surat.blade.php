<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penomoran Surat</title>
</head>
<body>
    <h3>Penomoran Surat</h3>
    <p>Bismillah,</p> 
    <p>Peneliti {{ $data['name'] }} pada {{ $data['penelitian'] }} tahun {{ $data['tahun'] }} dengan judul {{ $data['judul'] }} telah diberikan nomor oleh JFU LPPM</p>
    {!! $data['konten'] !!}
    <p>Terimakasih</p>
</body>
</html>