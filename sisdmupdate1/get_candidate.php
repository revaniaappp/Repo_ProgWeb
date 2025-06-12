<?php
// get_candidate.php - untuk mendapatkan satu candidate berdasarkan ID
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

try {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Candidate ID is required']);
        exit;
    }
    
    $candidateId = intval($_GET['id']);
    
    // Database connection
    $host = 'localhost';
    $dbname = 'neo_sync';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query untuk mengambil candidate berdasarkan ID
    $sql = "SELECT * FROM candidates WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $candidateId, PDO::PARAM_INT);
    $stmt->execute();
    
    $candidate = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$candidate) {
        http_response_code(404);
        echo json_encode(['error' => 'Candidate not found']);
        exit;
    }
    
    echo json_encode($candidate);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
