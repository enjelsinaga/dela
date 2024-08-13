<?php

require_once('../koneksi/config.php');

header('Content-Type: application/json');

// Query to get data per gelombang and year
$sql = "
    SELECT 
        YEAR(tcs.created_at) AS year,
        gp.nama AS gelombang,
        COUNT(*) AS count
    FROM `tabel-calon-siswa` tcs
    JOIN `gelombang_pendaftaran` gp ON tcs.id_gelombang_pendaftaran = gp.id
    GROUP BY YEAR(tcs.created_at), gp.nama
    ORDER BY YEAR(tcs.created_at), gp.nama
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $year = $row['year'];
    $gelombang = $row['gelombang'];
    $count = $row['count'];

    if (!isset($data[$year])) {
        $data[$year] = [];
    }

    $data[$year][$gelombang] = $count;
}

$conn->close();

// Prepare data for Chart.js
$output = [
    'labels' => array_keys($data),
    'datasets' => []
];

// Collect all unique gelombang names
$gelombangNames = [];
foreach ($data as $year => $gelombangs) {
    foreach ($gelombangs as $gelombang => $count) {
        if (!in_array($gelombang, $gelombangNames)) {
            $gelombangNames[] = $gelombang;
        }
    }
}

// Create datasets for each gelombang
foreach ($gelombangNames as $gelombang) {
    $dataset = [
        'label' => $gelombang,
        'data' => [],
        'backgroundColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.2)',
        'borderColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 1)',
        'borderWidth' => 1
    ];

    foreach ($data as $year => $gelombangs) {
        $dataset['data'][] = isset($gelombangs[$gelombang]) ? $gelombangs[$gelombang] : 0;
    }

    $output['datasets'][] = $dataset;
}

echo json_encode($output);
