<?php
session_start();
if (!isset($_SESSION['user']) == 'admin') {
    if ($_SESSION['role'] == 1) {
        header("location:../../frontend/teacherindex.php");
    } else if ($_SESSION['role'] == 2) {
        header("location:../../frontend/studentindex.php");
    } else {
        header("location:../../index.php");
    }
}
require_once("../../includes/connect.php");
$conn = connect();
$id = $_GET['id'];
$verifyQuery = "SELECT verification FROM user WHERE id = :id";
$stmt = $conn->prepare($verifyQuery);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$value = $stmt->fetchColumn();
if ($value == 0) {
    $verifyQuery = "UPDATE user SET verification = 1 WHERE id = :id";
    $stmt = $conn->prepare($verifyQuery);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $unverifyQuery = "UPDATE user SET verification = 0 WHERE id = :id";
    $stmt = $conn->prepare($unverifyQuery);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
header("location:../adminindex.php");
?>
