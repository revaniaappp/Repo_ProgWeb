<?php
// update_candidate.php - untuk mengupdate data candidate
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }
    
    if (!isset($_POST['candidate_id']) || empty($_POST['candidate_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Candidate ID is required']);
        exit;
    }
    
    $candidateId = intval($_POST['candidate_id']);
    
    // Database connection
    $host = 'localhost';
    $dbname = 'neo_sync';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Validasi input
    $position = trim($_POST['candidate-position'] ?? '');
    $lastName = trim($_POST['candidate-lastname'] ?? '');
    $firstName = trim($_POST['candidate-firstname'] ?? '');
    $middleName = trim($_POST['candidate-middlename'] ?? '');
    $gender = trim($_POST['candidate-gender'] ?? '');
    $email = trim($_POST['candidate-email'] ?? '');
    $contact = trim($_POST['candidate-contact'] ?? '');
    $address = trim($_POST['candidate-address'] ?? '');
    $coverLetter = trim($_POST['candidate-coverletter'] ?? '');
    $status = trim($_POST['candidate-status'] ?? 'New');
    
    // Validasi field wajib
    if (empty($position) || empty($lastName) || empty($firstName) || empty($email) || empty($contact) || empty($address)) {
        http_response_code(400);
        echo json_encode(['error' => 'Required fields are missing']);
        exit;
    }
    
    // Handle file upload jika ada
    $resumePath = null;
    if (isset($_FILES['candidate-resume']) && $_FILES['candidate-resume']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/resumes/';
        
        // Buat directory jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['candidate-resume']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'doc', 'docx'];
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid file type. Only PDF, DOC, and DOCX files are allowed.']);
            exit;
        }
        
        $fileName = 'resume_' . $candidateId . '_' . time() . '.' . $fileExtension;
        $resumePath = $uploadDir . $fileName;
        
        if (!move_uploaded_file($_FILES['candidate-resume']['tmp_name'], $resumePath)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to upload resume file']);
            exit;
        }
    }
    
    // Prepare SQL update
    if ($resumePath) {
        $sql = "UPDATE candidates SET 
                position = :position,
                last_name = :last_name,
                first_name = :first_name,
                middle_name = :middle_name,
                gender = :gender,
                email = :email,
                contact = :contact,
                address = :address,
                cover_letter = :cover_letter,
                resume_path = :resume_path,
                status = :status,
                updated_at = NOW()
                WHERE id = :id";
    } else {
        $sql = "UPDATE candidates SET 
                position = :position,
                last_name = :last_name,
                first_name = :first_name,
                middle_name = :middle_name,
                gender = :gender,
                email = :email,
                contact = :contact,
                address = :address,
                cover_letter = :cover_letter,
                status = :status,
                updated_at = NOW()
                WHERE id = :id";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':middle_name', $middleName);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':cover_letter', $coverLetter);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $candidateId, PDO::PARAM_INT);
    
    if ($resumePath) {
        $stmt->bindParam(':resume_path', $resumePath);
    }
    
    if ($stmt->execute()) {
        echo "Candidate updated successfully";
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update candidate']);
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>