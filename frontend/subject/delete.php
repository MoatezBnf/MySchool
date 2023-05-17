<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 1) {
    if ($_SESSION['user'] == 'admin') {
        header("location:../../backend/adminindex.php");
    } else if ($_SESSION['role'] == 2) {
        header("location:../studentindex.php");
    } else {
        header("location:../../index.php");
    }
}
require_once("../../includes/connect.php");
$conn = connect();
$id = $_GET['id'];
$deletequery = "DELETE FROM matiere WHERE id_matiere = :id";
$deletestudent = "DELETE FROM etudiant_inscrit WHERE id_matiere = :id";
$stmt1 = $conn->prepare($deletequery);
$stmt2 = $conn->prepare($deletestudent);
$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
$stmt1->execute();
$stmt2->execute();
header("location:../teacherindex.php");
?>
