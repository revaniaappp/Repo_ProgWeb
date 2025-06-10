<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "neo_sync");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$result = $conn->query("SELECT * FROM job_positions ORDER BY id DESC");

$jobs = [];
while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

echo json_encode($jobs);

$conn->close();
?>
