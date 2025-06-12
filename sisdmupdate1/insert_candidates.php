<?php
$host = 'localhost';
$user = 'root';
$password = ''; // sesuaikan
$db = 'neo_sync';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
$position = $_POST['candidate-position'];
$lastName = $_POST['candidate-lastname'];
$firstName = $_POST['candidate-firstname'];
$middleName = $_POST['candidate-middlename'];
$gender = $_POST['candidate-gender'];
$email = $_POST['candidate-email'];
$contact = $_POST['candidate-contact'];
$address = $_POST['candidate-address'];
$coverLetter = $_POST['candidate-coverletter'];
$status = $_POST['candidate-status'] ?? 'New';

// Simpan resume file (optional)
$resumePath = '';
if (isset($_FILES['candidate-resume']) && $_FILES['candidate-resume']['error'] === UPLOAD_ERR_OK) {
    $resumeTmp = $_FILES['candidate-resume']['tmp_name'];
    $resumeName = basename($_FILES['candidate-resume']['name']);
    $resumePath = 'uploads/' . time() . '_' . $resumeName;
    move_uploaded_file($resumeTmp, $resumePath);
}

$stmt = $conn->prepare("INSERT INTO candidates (position, last_name, first_name, middle_name, gender, email, contact, address, cover_letter, resume_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssss", $position, $lastName, $firstName, $middleName, $gender, $email, $contact, $address, $coverLetter, $resumePath, $status);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
