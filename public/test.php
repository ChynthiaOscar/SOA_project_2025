<?php
// File test.php: Untuk mengecek apakah Laravel dapat menampilkan HTML atau tidak

// Tampilkan informasi rute
echo "<h1>Laravel Route Test</h1>";
echo "<p>Halaman ini berhasil ditampilkan, artinya server bisa menampilkan HTML!</p>";
echo "<p>Untuk melihat halaman reviews, kunjungi: <a href='/reviews'>/reviews</a></p>";
echo "<hr>";

// Tampilkan semua rute yang terdaftar
echo "<h2>Daftar Route</h2>";
echo "<pre>";
$routes = app('router')->getRoutes();
foreach ($routes as $route) {
    echo $route->uri() . " - Methods: " . implode(', ', $route->methods()) . "\n";
}
echo "</pre>";
