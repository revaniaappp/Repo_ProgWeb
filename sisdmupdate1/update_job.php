<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

include 'config.php';

$id = $data['job_id'];
$title = $data['job_title'];
$desc = $data['job_description'];
$req = $data['job_requirement'];
$count = $data['needed_count'];

$sql = "UPDATE job_positions SET 
          job_title = '$title',
          job_description = '$desc',
          job_requirement = '$req',
          needed_count = $count 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['error' => $conn->error]);
}
?>
