<?php
// get_candidates.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Database connection - sesuaikan dengan konfigurasi database Anda
    $host = 'localhost';
    $dbname = 'neo_sync';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query untuk mengambil semua candidates, diurutkan berdasarkan tanggal pendaftaran terbaru
    $sql = "SELECT * FROM candidates ORDER BY application_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($candidates);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
