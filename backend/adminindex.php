<?php
include("../includes/header.php");
include("../includes/navadmin.php");
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    if ($_SESSION['role'] == 1) {
        header("location:../frontend/teacherindex.php");
    } else if ($_SESSION['role'] == 2) {
        header("location:../frontend/studentindex.php");
    } else {
        header("location:../index.php");
    }
}

echo "<strong class='text-center'>Membre Connecté: " . $_SESSION['user'] . "</strong>";
require_once("../includes/connect.php");
$conn = connect();
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$teacherquery = "SELECT * FROM user WHERE role = 1 AND (nom LIKE :search OR prenom LIKE :search)";
$teacherstmt = $conn->prepare($teacherquery);
$teacherstmt->bindValue(':search', '%' . $search . '%');
$teacherstmt->execute();
$teacherresult = $teacherstmt->fetchAll(PDO::FETCH_ASSOC);
if (count($teacherresult) > 0) {
    echo "<div class='container-fluid'>
    <h6>List of Teachers:<h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='text' name='search' placeholder='Search by name'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='adminindex.php' class='btn btn-primary bg-gradient'>Reset</a>
        </div>
    </form>
    <table class='table table-primary table-striped table-bordered border-dark'>
        <thead>
            <tr>
                <th>last name</th>
                <th>name</th>
                <th>email</th>
                <th>phone number</th>
                <th>address</th>
                <th>verified</th>
                <th>edit</th>
                <th>reset password</th>
            </tr>
        </thead>
        <tbody>";
    
    foreach ($teacherresult as $row) {
        $verification = $row['verification'];
        $icon = $verification ? "<i class='fas fa-check-circle text-success'></i>" : "<i class='fas fa-times-circle text-danger'></i>";
        
        echo "<tr>
                <td>" . $row['nom'] . "</td>
                <td>" . $row['prenom'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['telephone'] . "</td>
                <td>" . $row['addresse'] . "</td>
                <td>" . $icon . "</td>
                <td>
                    <a class='btn btn-info m-1' href='teacher/verify.php?id=" . $row['id'] . "' role='button'><i class='fas fa-" . ($verification ? "times" : "check") . "'></i></a>
                    <a class='btn btn-success m-1' href='teacher/edit.php?id=" . $row['id'] . "' role='button'><i class='fas fa-edit'></i></a>
                    <a class='btn btn-danger m-1' href='teacher/delete.php?id=" . $row['id'] . "' role='button'><i class='far fa-trash-alt'></i></a>
                </td>
                <td>
                    <a class='btn btn-primary m-1' href='teacher/resetpassword.php?id=" . $row['id'] . "' role='button'><i class='fas fa-key'></i> Reset Password</a>
                </td>
              </tr>";
    }

    echo "</tbody></table></div>";
} else {
    echo "<div class='container-fluid'>
    <h6>List of Teachers:<h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='text' name='search' placeholder='Search by name'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='adminindex.php' class='btn btn-primary bg-gradient'>Reset</a>
        </div>
    </form>
    <strong class='text-center'>No data found in teacher table</strong></div>";
}

$search = "";
if (isset($_GET['search2'])) {
    $search = $_GET['search2'];
}

$studentquery = "SELECT * FROM user WHERE role = 2 AND (nom LIKE :search OR prenom LIKE :search)";
$studentstmt = $conn->prepare($studentquery);
$studentstmt->bindValue(':search', '%' . $search . '%');
$studentstmt->execute();
$studentresult = $studentstmt->fetchAll(PDO::FETCH_ASSOC);

if (count($studentresult) > 0) {
    echo "<div class='container-fluid'>
    <h6>List of Students:<h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='text' name='search2' placeholder='Search by name'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='adminindex.php' class='btn btn-primary bg-gradient'>Reset</a>
        </div>
    </form>
    <table class='table table-primary table-striped table-bordered border-dark'>
        <thead>
            <tr>
                <th>last name</th>
                <th>name</th>
                <th>email</th>
                <th>phone number</th>
                <th>address</th>
                <th>verified</th>
                <th>edit</th>
                <th>reset password</th>
            </tr>
        </thead>
        <tbody>";
    
    foreach ($studentresult as $row) {
        $verification = $row['verification'];
        $icon = $verification ? "<i class='fas fa-check-circle text-success'></i>" : "<i class='fas fa-times-circle text-danger'></i>";
        
        echo "<tr>
                <td>" . $row['nom'] . "</td>
                <td>" . $row['prenom'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['telephone'] . "</td>
                <td>" . $row['addresse'] . "</td>
                <td>" . $icon . "</td>
                <td>
                    <a class='btn btn-info m-1' href='teacher/verify.php?id=" . $row['id'] . "' role='button'><i class='fas fa-" . ($verification ? "times" : "check") . "'></i></a>
                    <a class='btn btn-success m-1' href='teacher/edit.php?id=" . $row['id'] . "' role='button'><i class='fas fa-edit'></i></a>
                    <a class='btn btn-danger m-1' href='teacher/delete.php?id=" . $row['id'] . "' role='button'><i class='far fa-trash-alt'></i></a>
                </td>
                <td>
                    <a class='btn btn-primary m-1' href='teacher/resetpassword.php?id=" . $row['id'] . "' role='button'><i class='fas fa-key'></i> Reset Password</a>
                </td>
              </tr>";
    }

    echo "</tbody></table></div>";
} else {
    echo "<div class='container-fluid'>
    <h6>List of Students:<h6>
    <form method='GET' action=''>
        <div class='mb-3'>
            <input type='text' name='search2' placeholder='Search by name'>
            <button type='submit' class='btn btn-primary bg-gradient'><i class='fas fa-search'></i></button>
            <a href='adminindex.php' class='btn btn-primary bg-gradient'>Reset</a>
        </div>
    </form>
    <strong class='text-center'>No data found in student table</strong></div>";
}

$conn = null;
include("../includes/footer.php");
?>
