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
$selectquery = "SELECT id_matiere FROM etudiant_inscrit WHERE id = :id";
$stmt1 = $conn->prepare($selectquery);
$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
$stmt1->execute();
$idmatiere = $stmt1->fetch(PDO::FETCH_COLUMN);
$deletequery = "DELETE FROM etudiant_inscrit WHERE id = :id";
$stmt2 = $conn->prepare($deletequery);
$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
$stmt2->execute();
header("location:view.php?id=$idmatiere");
?>
