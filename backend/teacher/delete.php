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
$deletequery = "DELETE FROM user WHERE id = :id";
$deletematierequery = "DELETE FROM matiere WHERE id_prof = :id";
$deletestudentquery = "DELETE FROM etudiant_inscrit WHERE id_etudiant = :id OR id_prof = :id";
$deleteStmt = $conn->prepare($deletequery);
$deletematiereStmt = $conn->prepare($deletematierequery);
$deletestudentStmt = $conn->prepare($deletestudentquery);
$deleteStmt->bindValue(':id', $id, PDO::PARAM_INT);
$deletematiereStmt->bindValue(':id', $id, PDO::PARAM_INT);
$deletestudentStmt->bindValue(':id', $id, PDO::PARAM_INT);
$deleteStmt->execute();
$deletematiereStmt->execute();
$deletestudentStmt->execute();
header("location:../adminindex.php");
?>
