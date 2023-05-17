<?php
include("../../includes/header.php");
include("../../includes/navadmin.php");
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin')
{
    if($_SESSION['role'] == 1){
        header("location:../../frontend/teacherindex.php");
    } else if($_SESSION['role'] == 2){
        header("location:../../frontend/studentindex.php");
    } else {
        header("location:../../index.php");
    }
}
require_once("../../includes/connect.php");
$conn = connect();
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $lastname = $_POST['lastname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $add = $_POST['add'];
    $email_check_query = "SELECT * FROM user WHERE email = :email AND id != :id";
    $phone_check_query = "SELECT * FROM user WHERE telephone = :tel AND id != :id";
    $email_result = $conn->prepare($email_check_query);
    $email_result->execute(array(':email' => $email, ':id' => $id));
    $phone_result = $conn->prepare($phone_check_query);
    $phone_result->execute(array(':tel' => $tel, ':id' => $id));
    $email_row = $email_result->fetch(PDO::FETCH_ASSOC);
    if ($email_row) {
        echo "<strong class='text-center'>Email Already Exists!</strong>";
        echo"<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
            <a class='btn btn-primary bg-gradient'
            href='../adminindex.php' role='button'>Return To Main Page</a></div>";
        die();
    }
    $phone_row = $phone_result->fetch(PDO::FETCH_ASSOC);
    if ($phone_row) {
        echo "<strong class='text-center'>Phone number already exists!</strong>";
        echo"<div class='d-grid mt-5 gap-2 col-6 mx-auto'>
            <a class='btn btn-primary bg-gradient'
            href='../adminindex.php' role='button'>Return To Main Page</a></div>";
        die();
    }
    $updatequery = "UPDATE user SET nom = :lastname, prenom = :name, email = :email, telephone = :tel, addresse = :add WHERE id = :id";
    $stmt = $conn->prepare($updatequery);
    $stmt->execute(array(':lastname' => $lastname, ':name' => $name, ':email' => $email, ':tel' => $tel, ':add' => $add, ':id' => $id));

    if($stmt->rowCount() > 0){
        header("location:../adminindex.php");
        die();
    } else {
        header("location:../adminindex.php");
        die();
    }
}
$id = $_GET['id'];
$selectquery = "SELECT * FROM user WHERE id = :id";
$stmt = $conn->prepare($selectquery);
$stmt->execute(array(':id' => $id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$conn = null;
?>
<form class="m-2" action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <div class="form-outline">
        <label class="form-label" for="lastname">Modify Last Name</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $row['nom'];?>" class="form-control"/>
    </div>
    <div class="form-outline">
        <label class="form-label" for="name">Modify Name</label>
        <input type="text" id="name" name="name" value="<?php echo $row['prenom'];?>" class="form-control"/>
    </div>
    <div class="form-outline">
        <label class="form-label" for="email">Modify Email</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email'];?>" class="form-control"/>
    </div>
    <div class="form-outline">
        <label class="form-label" for="tel">Modify Phone Number</label>
        <input type="tel" id="tel" name="tel" value="<?php echo $row['telephone'];?>" class="form-control" pattern="[0-9]{8}" required>
    </div>
    <div class="form-outline">
        <label class="form-label" for="add">Modify Address</label>
        <input type="text" id="add" name="add" value="<?php echo $row['addresse'];?>" class="form-control">
    </div>
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary bg-gradient btn-block" name="submit" onclick="ModifyTeacherControl(event)">Modify</button>
    </div>
    <div class="d-grid gap-2 mt-3">
        <a class="btn btn-primary bg-gradient btn-block" href="../adminindex.php">Cancel</a>
    </div>
</form>
<?php
include("../../includes/footer.php");
?>
