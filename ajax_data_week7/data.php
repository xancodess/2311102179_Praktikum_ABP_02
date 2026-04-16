<?php
// Set header agar browser tahu ini adalah JSON
header('Content-Type: application/json');

// "Database" sederhana berupa array
$profil = [
    'nama'      => 'Axandio',
    'pekerjaan' => 'Video Editor',
    'lokasi'    => 'Jakarta'
];

// Ubah array ke format JSON dan tampilkan
echo json_encode($profil);
?>
