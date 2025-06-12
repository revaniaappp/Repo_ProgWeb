<?php
// delete_candidate.php - untuk menghapus candidate
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['id']) || empty($input['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Candidate ID is required']);
        exit;
    }
    
    $candidateId = intval($input['id']);
    
    // Database connection
    $host = 'localhost';
    $dbname = 'neo_sync';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Ambil data candidate untuk menghapus file resume jika ada
    $sql = "SELECT resume_path FROM candidates WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $candidateId, PDO::PARAM_INT);
    $stmt->execute();
    $candidate = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$candidate) {
        http_response_code(404);
        echo json_encode(['error' => 'Candidate not found']);
        exit;
    }
    
    // Hapus file resume jika ada
    if (!empty($candidate['resume_path']) && file_exists($candidate['resume_path'])) {
        unlink($candidate['resume_path']);
    }
    
    // Hapus data dari database
    $sql = "DELETE FROM candidates WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $candidateId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Candidate deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete candidate']);
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
