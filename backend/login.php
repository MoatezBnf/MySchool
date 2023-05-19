<?php
session_start();
if(isset($_SESSION['user'])){
  header("location:adminindex.php");
}else if(isset($_SESSION['role'])==1){
  header("location:../frontend/teacherindex.php");
}else if(isset($_SESSION['role'])==2){
  header("location:../frontend/studentindex.php");
}
try {
    $user = $_POST['loginUsername'];
    $pass = $_POST['loginPassword'];
    require_once("../includes/connect.php");
    $conn = connect();
    $query = "select * from user where user = :user";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($ligne) {
        if ($ligne['user'] == "admin" && $pass == "myschooladmin") {
            header("location:verifadmin.php");
        } else if (password_verify($pass, $ligne['pass'])) {
            if ($ligne['verification'] == 0) {
                include("../includes/header.php");
                include("../includes/navstat.php");
                echo "<strong class='text-center'>Account not verified. Please wait until the administration verifies it!</strong>";
                echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
                <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
                include("../includes/footer.php");
                die();
            } else if ($ligne['verification'] == 1) {
                if ($ligne['role'] == 1) {
                    session_start();
                    $_SESSION['id'] = $ligne['id'];
                    $_SESSION['nom'] = $ligne['nom'];
                    $_SESSION['prenom'] = $ligne['prenom'];
                    $_SESSION['role'] = $ligne['role'];
                    header("location:../frontend/teacherindex.php");
                } else if ($ligne['role'] == 2) {
                    session_start();
                    $_SESSION['id'] = $ligne['id'];
                    $_SESSION['nom'] = $ligne['nom'];
                    $_SESSION['prenom'] = $ligne['prenom'];
                    $_SESSION['role'] = $ligne['role'];
                    header("location:../frontend/studentindex.php");
                }
            }
        } else {
            include("../includes/header.php");
            include("../includes/navstat.php");
            echo "<strong class='text-center'>Username is wrong or account non-existent!</strong>";
            echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
            <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
            include("../includes/footer.php");
            die();
        }
    } else {
        include("../includes/header.php");
        include("../includes/navstat.php");
        echo "<strong class='text-center'>Username is wrong or account non-existent!</strong>";
        echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
        <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
        include("../includes/footer.php");
        die();
    }
    $conn = null;
} catch (PDOException $e) {
    echo "Error Logging In: " . $e->getMessage();
}
?>
