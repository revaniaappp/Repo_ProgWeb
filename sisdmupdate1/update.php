<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

$conn = new mysqli("localhost", "root", "", "neo_sync");

if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "DB connection failed"]);
  exit;
}

$stmt = $conn->prepare("UPDATE job_positions SET job_title=?, job_description=?, job_requirement=?, needed_count=? WHERE id=?");
$stmt->bind_param("sssii", $data['job_title'], $data['job_description'], $data['job_requirement'], $data['needed_count'], $data['id']);

if ($stmt->execute()) {
  echo json_encode(["success" => true]);
} else {
  http_response_code(500);
  echo json_encode(["error" => "Update failed"]);
}

$stmt->close();
$conn->close();
?>
