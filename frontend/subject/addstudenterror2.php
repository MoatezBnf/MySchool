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
$id=$_GET['id'];
echo"<strong class='text-center'>Membre Connecté: Mr ".$_SESSION['nom']." ".$_SESSION['prenom']."</strong>";
echo "<strong class='text-center'>Student Already Registered in Subject!</strong>";
                echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
                <a class='btn btn-primary bg-gradient' href='view.php?id=$id' role='button'>Return To Subject Page</a></div>";
?>
<?php
include("../../includes/footer.php");
?>