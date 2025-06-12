<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Koneksi database (sesuaikan dengan konfigurasi Anda)
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";  // Ganti dengan password database Anda
$dbname = "neo_sync";    // Ganti dengan nama database Anda

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query untuk mengambil data job positions
    $stmt = $pdo->prepare("SELECT id, job_title FROM job_positions WHERE job_title IS NOT NULL AND job_title != '' ORDER BY job_title ASC");
    $stmt->execute();
    
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug: Log jumlah data yang ditemukan
    error_log("Found " . count($positions) . " positions");
    
    echo json_encode($positions);
    
} catch(PDOException $e) {
    // Log error untuk debugging
    error_log("Database error: " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>