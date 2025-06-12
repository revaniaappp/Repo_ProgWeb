<?php
header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Koneksi database - SESUAIKAN DENGAN KONFIGURASI ANDA
$servername = "localhost";
$username = "root";        // Ganti dengan username database Anda
$password = "";            // Ganti dengan password database Anda  
$dbname = "neo_sync"; // Ganti dengan nama database Anda

try {
    // Buat koneksi PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Validasi method POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Only POST method allowed');
    }
    
    // Ambil data dari form
    $position = isset($_POST['candidate-position']) ? trim($_POST['candidate-position']) : '';
    $lastName = isset($_POST['candidate-lastname']) ? trim($_POST['candidate-lastname']) : '';
    $firstName = isset($_POST['candidate-firstname']) ? trim($_POST['candidate-firstname']) : '';
    $middleName = isset($_POST['candidate-middlename']) ? trim($_POST['candidate-middlename']) : '';
    $gender = isset($_POST['candidate-gender']) ? trim($_POST['candidate-gender']) : '';
    $email = isset($_POST['candidate-email']) ? trim($_POST['candidate-email']) : '';
    $contact = isset($_POST['candidate-contact']) ? trim($_POST['candidate-contact']) : '';
    $address = isset($_POST['candidate-address']) ? trim($_POST['candidate-address']) : '';
    $coverLetter = isset($_POST['candidate-coverletter']) ? trim($_POST['candidate-coverletter']) : '';
    $status = isset($_POST['candidate-status']) ? trim($_POST['candidate-status']) : 'New';
    
    // Validasi field wajib
    $errors = [];
    
    if (empty($position)) {
        $errors[] = 'Position is required';
    }
    
    if (empty($lastName)) {
        $errors[] = 'Last Name is required';
    }
    
    if (empty($firstName)) {
        $errors[] = 'First Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($contact)) {
        $errors[] = 'Contact number is required';
    }
    
    if (empty($address)) {
        $errors[] = 'Address is required';
    }
    
    if (!empty($errors)) {
        throw new Exception('Validation errors: ' . implode(', ', $errors));
    }
    
    // Handle file upload (resume)
    $resumeFileName = null;
    $resumePath = null;
    
    if (isset($_FILES['candidate-resume']) && $_FILES['candidate-resume']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/resumes/';
        
        // Buat folder jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['candidate-resume']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'doc', 'docx'];
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception('Invalid file type. Only PDF, DOC, and DOCX files are allowed.');
        }
        
        // Generate unique filename
        $resumeFileName = 'resume_' . uniqid() . '_' . time() . '.' . $fileExtension;
        $resumePath = $uploadDir . $resumeFileName;
        
        if (!move_uploaded_file($_FILES['candidate-resume']['tmp_name'], $resumePath)) {
            throw new Exception('Failed to upload resume file');
        }
    }
    
    // Cek apakah email sudah ada
    $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM candidates WHERE email = ?");
    $checkEmailStmt->execute([$email]);
    
    if ($candidateId) {
    // Mode Edit - cek apakah email sudah dipakai kandidat lain
    $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM candidates WHERE email = ? AND id != ?");
    $checkEmailStmt->execute([$email, $candidateId]);
    if ($checkEmailStmt->fetchColumn() > 0) {
        throw new Exception('Email already exists in our database');
    }

    // Update kandidat
    $sql = "UPDATE candidates SET 
        position = ?, 
        last_name = ?, 
        first_name = ?, 
        middle_name = ?, 
        gender = ?, 
        email = ?, 
        contact = ?, 
        address = ?, 
        cover_letter = ?, 
        status = ?" . 
        ($resumeFileName ? ", resume_filename = ?, resume_path = ?" : "") .
        " WHERE id = ?";

    $params = [
        $position, $lastName, $firstName, $middleName, $gender,
        $email, $contact, $address, $coverLetter, $status
    ];

    if ($resumeFileName) {
        $params[] = $resumeFileName;
        $params[] = $resumePath;
    }

    $params[] = $candidateId;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo "success: Candidate data updated successfully!";
} else {
    // Mode Insert (seperti sebelumnya)
    $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM candidates WHERE email = ?");
    $checkEmailStmt->execute([$email]);

    if ($checkEmailStmt->fetchColumn() > 0) {
        if ($resumePath && file_exists($resumePath)) {
            unlink($resumePath);
        }
        throw new Exception('Email already exists in our database');
    }

    // Insert data baru
    $sql = "INSERT INTO candidates (
        position, last_name, first_name, middle_name, gender, email, contact, address, cover_letter, resume_filename, resume_path, status, application_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $position, $lastName, $firstName, $middleName, $gender,
        $email, $contact, $address, $coverLetter, $resumeFileName,
        $resumePath, $status
    ]);

    echo "success: Application submitted successfully! Candidate ID: " . $pdo->lastInsertId();
}

    
    // Insert data ke database
    $sql = "INSERT INTO candidates (
        position, 
        last_name, 
        first_name, 
        middle_name, 
        gender, 
        email, 
        contact, 
        address, 
        cover_letter, 
        resume_filename, 
        resume_path, 
        status,
        application_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $position,
        $lastName,
        $firstName,
        $middleName,
        $gender,
        $email,
        $contact,
        $address,
        $coverLetter,
        $resumeFileName,
        $resumePath,
        $status
    ]);
    
    // Response sukses
    echo "success: Application submitted successfully! Candidate ID: " . $pdo->lastInsertId();
    
} catch(PDOException $e) {
    // Database error
    error_log("Database error in insert_candidate.php: " . $e->getMessage());
    echo "error: Database error - " . $e->getMessage();
    
} catch(Exception $e) {
    // General error
    error_log("Error in insert_candidate.php: " . $e->getMessage());
    echo "error: " . $e->getMessage();
}
?>