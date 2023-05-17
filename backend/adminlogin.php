<?php
$pass=$_POST['adminpass'];
if($pass=='123456789'){
    session_start();
    $_SESSION['user']='admin';
    header("location:adminindex.php");
}else
{
    include("../includes/header.php");
    include("../includes/navstat.php");
    echo "<strong class='text-center'>Physical Password that you typed is wrong!</strong>";
    echo"<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
    <a class='btn btn-primary bg-gradient'
    href='verifadmin.php' role='button'>Have a second attempt!</a>
    <a class='btn btn-primary bg-gradient'
    href='../index.php' role='button'>Return To Main Page</a></div>";
    include("../includes/footer.php");
    die();
}
?>