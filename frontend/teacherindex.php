<?php
include("../includes/header.php");
include("../includes/navteacher.php");
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 1) {
    if ($_SESSION['user'] == 'admin') {
        header("location:../backend/adminindex.php");
    } else if ($_SESSION['role'] == 2) {
        header("location:studentindex.php");
    } else {
        header("location:../index.php");
    }
}
echo "<strong class='text-center'>Membre Connecté: Mr " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</strong>";
require_once("../includes/connect.php");
$conn = connect();
$id = $_SESSION['id'];
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$matierequery = "SELECT * FROM matiere WHERE id_prof=:id AND (titre LIKE :search)";
$matierestmt = $conn->prepare($matierequery);
$matierestmt->bindValue(':id', $id, PDO::PARAM_INT);
$matierestmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$matierestmt->execute();
if ($matierestmt->rowCount() > 0) {
    echo "<div class='container-fluid'>
    <h6>List of Subjects:<h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='text' name='search' placeholder='Search by title'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='teacherindex.php' class='btn btn-primary bg-gradient'>Reset</a>
            <a href='subject/create.php?id=" . $_SESSION['id'] . "' class='btn btn-primary bg-gradient'>Create New Subject</a>
        </div>
    </form>
    <table class='table table-primary table-striped table-bordered border-dark'>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>";
    while ($row = $matierestmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
            <td>" . $row['titre'] . "</td>
            <td>" . $row['description'] . "</td>
            <td>
                <a class='btn btn-info m-1' href='subject/view.php?id=" . $row['id_matiere'] . "' role='button'><i class='fa-solid fa-eye'></i></a>
                <a class='btn btn-success m-1' href='subject/edit.php?id=" . $row['id_matiere'] . "' role='button'><i class='fas fa-edit'></i></a>
                <a class='btn btn-danger m-1' href='subject/delete.php?id=" . $row['id_matiere'] . "' role='button'><i class='far fa-trash-alt'></i></a>
            </td>
        </tr>";
    }
    echo "</tbody></table></div>";
} else {
    echo "<div class='container-fluid'>
    <h6>List of Teachers:<h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='text' name='search' placeholder='Search by title'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='teacherindex.php' class='btn btn-primary bg-gradient'>Reset</a>
            <a href='subject/create.php?id=" . $_SESSION['id'] . "' class='btn btn-primary bg-gradient'>Create New Subject</a>
        </div>
    </form>
    <strong class='text-center'>No data found in the subject table</strong></div>";
}
$conn = null;
include("../includes/footer.php");
?>
