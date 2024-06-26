<?php
require_once "../db.php";
session_start();

$pdo = getConnection();


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  http_response_code(405); // Method Not Allowed
  echo json_encode(['message' => "Unsupported request method."]);
  exit;
}

$json_data = json_decode(file_get_contents('php://input'), true);

$email = $json_data['email'];
$password = $json_data['password'];

$stmt = $pdo->prepare(
  "
  SELECT *
  FROM users 
  WHERE email = :email
  "
);

$user_cred = [
  'email' => $email
];

$stmt->execute($user_cred);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$is_pass_verified = password_verify($password, $user['password']);

if (!$is_pass_verified) {
  http_response_code(500);
  echo json_encode(['message' => "Incorrect credentials."]);
  exit;
}

unset($user['password']);
http_response_code(200);

echo json_encode(['message' => "Successfully logged in.", 'data' => ['user' => $user]]);
?>
