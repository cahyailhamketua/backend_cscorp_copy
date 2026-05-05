<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pesan Baru dari Website CS Corp</title>
</head>
<body>
    <h2>Pesan Baru dari Website CS Corp</h2>
    <p><strong>Nama:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    @if(!empty($phone))
        <p><strong>Phone:</strong> {{ $phone }}</p>
    @endif
    <p><strong>Pesan:</strong></p>
    <p>{{ $content }}</p>
</body>
</html>

