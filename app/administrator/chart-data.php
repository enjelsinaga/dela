<?php

require_once('../koneksi/config.php');

header('Content-Type: application/json');

// Query to get data
$sql = "
    SELECT 
        YEAR(created_at) AS year,
        jenis_kelamin,
        COUNT(*) AS count
    FROM `tabel-siswa`
    GROUP BY YEAR(created_at), jenis_kelamin
    ORDER BY YEAR(created_at), jenis_kelamin
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $year = $row['year'];
    $gender = $row['jenis_kelamin'];
    $count = $row['count'];

    if (!isset($data[$year])) {
        $data[$year] = ['laki-laki' => 0, 'perempuan' => 0];
    }

    $data[$year][$gender] = $count;
}

$conn->close();

// Prepare data for Chart.js
$output = [
    'labels' => array_keys($data),
    'datasets' => [
        [
            'label' => 'Laki-laki',
            'data' => array_column(array_values($data), 'laki-laki'),
            'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
            'borderColor' => 'rgba(54, 162, 235, 1)',
            'borderWidth' => 1
        ],
        [
            'label' => 'Perempuan',
            'data' => array_column(array_values($data), 'perempuan'),
            'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
            'borderWidth' => 1
        ]
    ]
];

echo json_encode($output);
