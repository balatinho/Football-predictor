<?php
$host = "localhost";
$db   = "football_prediction";
$user = "root";
$pass = "";

try {
  $pdo = new PDO(
    "mysql:host=$host;dbname=$db;charset=UTF8",
    $user,
    $pass
  );
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database connection failed");
}