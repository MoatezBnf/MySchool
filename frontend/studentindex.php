<?php
include("../includes/header.php");
include("../includes/navstudent.php");
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 2) {
    if ($_SESSION['user'] == 'admin') {
        header("location:../backend/adminindex.php");
    } else if ($_SESSION['role'] == 1) {
        header("location:studentindex.php");
    } else {
        header("location:../index.php");
    }
}
echo "<strong class='text-center'>Membre Connecté: " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</strong>";
require_once("../includes/connect.php");
$conn = connect();
$id = $_SESSION['id'];
$teacherquery = "SELECT * FROM etudiant_inscrit WHERE id_etudiant=:id";
$teacherstmt = $conn->prepare($teacherquery);
$teacherstmt->bindParam(':id', $id);
$teacherstmt->execute();
$teacherresult = $teacherstmt->fetchAll(PDO::FETCH_ASSOC);
if (count($teacherresult) > 0) {
    echo "<div class='container-fluid'>
    <h6>List of Grades:<h6>
    <table class='table table-primary table-striped table-bordered border-dark'>
        <thead>
            <tr>
                <th>Subject Title</th>
                <th>Teacher Name</th>
                <th>Note Examen</th>
                <th>Note Ds</th>
            </tr>
        </thead>
        <tbody>";
    foreach ($teacherresult as $row) {
        $id_matiere = $row['id_matiere'];
        $query = "SELECT titre FROM matiere WHERE id_matiere=:id_matiere";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_matiere', $id_matiere);
        $stmt->execute();
        $title = $stmt->fetch(PDO::FETCH_COLUMN);
        $id_prof = $row['id_prof'];
        $query2 = "SELECT nom, prenom FROM user WHERE id=:id_prof";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bindParam(':id_prof', $id_prof);
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $note_examen = $row['note_examen'];
        $note_ds = $row['note_ds'];
        echo "<tr>
                <td>$title</td>
                <td>" . $row2['nom'] . " " . $row2['prenom'] . "</td>
                <td>" . ($note_examen !== null ? $note_examen : "NO GRADE WAS GIVEN YET") . "</td>
                <td>" . ($note_ds !== null ? $note_ds : "NO GRADE WAS GIVEN YET") . "</td>
              </tr>";
    }
    echo "</tbody></table></div>";
} else {
    echo "<div class='container-fluid'>
    <h6>List of Grades:<h6>
    <strong class='text-center'>You are not registered in any subject!</strong></div>";
}
$conn = null;
include("../includes/footer.php");
?>
