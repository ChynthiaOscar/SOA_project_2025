<?php
// File diagnosa untuk membantu memeriksa masalah HTML

// Ini akan menampilkan HTML langsung
echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Diagnosis HTML</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Diagnosis HTML</h1>
        <div class='card'>
            <h2>Informasi Server</h2>
            <p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>
            <p>PHP Version: " . PHP_VERSION . "</p>
            <p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>
            <p>Content Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'Tidak ditentukan') . "</p>
            <p>Accept Header: " . ($_SERVER['HTTP_ACCEPT'] ?? 'Tidak ditentukan') . "</p>
        </div>
        <div class='card'>
            <h2>Test HTML Output</h2>
            <p>Jika Anda melihat ini, maka server dapat menampilkan HTML dengan benar.</p>
        </div>
    </div>
</body>
</html>";

// Pastikan tidak ada output lebih lanjut
exit;
