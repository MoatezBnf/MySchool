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
    $role = $_POST['role'];
    $lastname = $_POST['registerlastName'];
    $name = $_POST['registerName'];
    $user = $_POST['registerUsername'];
    $pass = $_POST['registerPassword'];
    $email = $_POST['registerEmail'];
    $tel = $_POST['tel'];
    $add = $_POST['add'];
    require_once("../includes/connect.php");
    $conn = connect();
    $user_check_query = "select * from user where user=:user limit 1";
    $user_stmt = $conn->prepare($user_check_query);
    $user_stmt->bindParam(':user', $user);
    $user_stmt->execute();
    $user_result = $user_stmt->fetch(PDO::FETCH_ASSOC);
    if ($user_result) {
        include("../includes/header.php");
        include("../includes/navstat.php");
        echo "<strong class='text-center'>Username Already Exists!</strong>";
        echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
        <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
        include("../includes/footer.php");
        die();
    }
    $email_check_query = "select * from user where email=:email limit 1";
    $email_stmt = $conn->prepare($email_check_query);
    $email_stmt->bindParam(':email', $email);
    $email_stmt->execute();
    $email_result = $email_stmt->fetch(PDO::FETCH_ASSOC);
    if ($email_result) {
        include("../includes/header.php");
        include("../includes/navstat.php");
        echo "<strong class='text-center'>Email Already Exists!</strong>";
        echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
        <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
        include("../includes/footer.php");
        die();
    }
    $phone_check_query = "select * from user where telephone=:tel limit 1";
    $phone_stmt = $conn->prepare($phone_check_query);
    $phone_stmt->bindParam(':tel', $tel);
    $phone_stmt->execute();
    $phone_result = $phone_stmt->fetch(PDO::FETCH_ASSOC);
    if ($phone_result) {
        include("../includes/header.php");
        include("../includes/navstat.php");
        echo "<strong class='text-center'>Phone number already exists!</strong>";
        echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
        <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
        include("../includes/footer.php");
        die();
    }
    $password_hash = password_hash($pass, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO user(user, pass, nom, prenom, email, telephone, addresse, role)
    VALUES(:user, :pass, :lastname, :name, :email, :tel, :add, :role)";
   $insert_stmt = $conn->prepare($insert_query);
   $insert_stmt->bindParam(':user', $user);
   $insert_stmt->bindParam(':pass', $password_hash);
   $insert_stmt->bindParam(':lastname', $lastname);
   $insert_stmt->bindParam(':name', $name);
   $insert_stmt->bindParam(':email', $email);
   $insert_stmt->bindParam(':tel', $tel);
   $insert_stmt->bindParam(':add', $add);
   $insert_stmt->bindParam(':role', $role);
   if ($insert_stmt->execute()) {
       include("../includes/header.php");
       include("../includes/navstat.php");
       echo "<strong class='text-center'>Account Created Successfully!</strong>";
       echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
       <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
       include("../includes/footer.php");
       die();
   } else {
       include("../includes/header.php");
       include("../includes/navstat.php");
       echo "<strong class='text-center'>Error Creating Account</strong>";
       echo "<div class='text-center'>Error Message: " . $insert_stmt->errorInfo()[2] . "</div>";
       echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
       <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
       include("../includes/footer.php");
       die();
   }
} catch (PDOException $e) {
   include("../includes/header.php");
   include("../includes/navstat.php");
   $msg = $e->getMessage();
   echo "<strong class='text-center'>Connexion Problem.</strong>";
   echo "<p class='text-center'>$msg</p>";
   echo "<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
   <a class='btn btn-primary bg-gradient' href='../index.php' role='button'>Return To Main Page</a></div>";
   include("../includes/footer.php");
   die();
}
?>
