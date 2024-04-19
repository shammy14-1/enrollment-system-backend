<?php
require_once "../db.php";

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
  exit;
}

$pdo = getConnection();

$id = $_GET['id'];

$stmt = $pdo->prepare(
  "
  SELECT id, first_name, middle_name, last_name, email, contact_number, role, created_at, updated_at
  FROM users
  WHERE id = :id
  "
);

$exec = $stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');

if (!$exec || !$user) {
  http_response_code(400);
  echo json_encode(['message' => "Failed to fetch user: " . $id]);
  exit;
}

http_response_code(201);

echo json_encode(['message' => "Successfully fetched user.", 'data' => ['user' => $user]]);
?>
