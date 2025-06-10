<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Ambil JSON body dari fetch
$data = json_decode(file_get_contents('php://input'), true);

// Validasi data
if (!$data || !isset($data['job_title']) || !isset($data['job_description']) || !isset($data['job_requirement']) || !isset($data['needed_count'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "neo_sync");

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Siapkan statement sesuai struktur tabel
$stmt = $conn->prepare("INSERT INTO job_positions (job_title, job_description, job_requirement, needed_count) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $data['job_title'], $data['job_description'], $data['job_requirement'], $data['needed_count']);

if ($stmt->execute()) {
    $data['id'] = $stmt->insert_id;
    echo json_encode($data);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Insert failed']);
}

$stmt->close();
$conn->close();
?>
