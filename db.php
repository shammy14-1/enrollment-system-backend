<?php
function getConnection(): PDO {
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "enrollment";

  try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
  } catch (PDOException $e) {
    echo "Error creating database connection: " . $e->getMessage();
    exit; // Terminate script on connection error
  }
}
// hello 
?>
