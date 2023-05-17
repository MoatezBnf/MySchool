<?php
include("../../includes/header.php");
include("../../includes/navteacher.php");
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
echo "<strong class='text-center'>Membre Connecté: Mr " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</strong>";
require_once("../../includes/connect.php");
$conn = connect();
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$id = $_GET['id'];
$titlequery = "SELECT titre FROM matiere WHERE id_matiere = :id";
$titleresult = $conn->prepare($titlequery);
$titleresult->bindParam(':id', $id, PDO::PARAM_INT);
$titleresult->execute();
$title = $titleresult->fetchColumn();
$registeredstudent = "SELECT * FROM etudiant_inscrit WHERE id_matiere = :id AND (nom LIKE :search OR prenom LIKE :search)";
$registeredstudentquery = $conn->prepare($registeredstudent);
$registeredstudentquery->bindParam(':id', $id, PDO::PARAM_INT);
$likeSearch = '%' . $search . '%';
$registeredstudentquery->bindParam(':search', $likeSearch, PDO::PARAM_STR);
$registeredstudentquery->execute();
if ($registeredstudentquery->rowCount() > 0) {
    echo "<div class='container-fluid'>
    <h5>Subject Title: $title<h5>
    <h6>List of Students Registered :</h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='hidden' name='id' value='$id'>
            <input type='text' name='search' placeholder='Search by name'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='view.php?id=$id' class='btn btn-primary bg-gradient'>Reset</a>
            <a href='addstudent.php?id=$id' class='btn btn-primary bg-gradient'>Add Student</a>
        </div>
    </form>
    <table class='table table-primary table-striped table-bordered border-dark'>
        <thead>
            <tr>
                <th>Last Name</th>
                <th>Name</th>
                <th>Note Examen</th>
                <th>Note DS</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>";
    while ($row = $registeredstudentquery->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . $row['nom'] . "</td>
                <td>" . $row['prenom'] . "</td>
                <td>" . ($row['note_examen'] !== null ? $row['note_examen'] : "NO GRADE IS GIVEN YET") . "</td>
                <td>" . ($row['note_ds'] !== null ? $row['note_ds'] : "NO GRADE IS GIVEN YET") . "</td>
                <td>
                    <a class='btn btn-success m-1' href='editnote.php?id=" . $row['id'] . "' role='button'><i class='fas fa-edit'></i></a>
                    <a class='btn btn-danger m-1' href='deletestudent.php?id=" . $row['id'] . "' role='button'><i class='far fa-trash-alt'></i></a>
                </td>
              </tr>";
    }
    echo "</tbody></table></div>";
} else {
    echo "<div class='container-fluid'>
    <h5>Subject Title: $title<h5>
    <h6>List of Teachers:</h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='hidden' name='id' value='$id'>
            <input type='text' name='search' placeholder='Search by name'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='view.php?id=$id' class='btn btn-primary bg-gradient'>Reset</a>
            <a href='addstudent.php?id=$id' class='btn btn-primary bg-gradient'>Add Student</a>
        </div>
    </form>
    <strong class='text-center'>No Student is registered to this subject</strong></div>";
}
echo "<a class='btn btn-primary bg-gradient' href='../teacherindex.php' role='button'>Return To Main Page</a>";
$conn = null;
include("../../includes/footer.php");
?>