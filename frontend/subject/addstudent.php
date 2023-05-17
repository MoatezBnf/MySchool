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
echo"<strong class='text-center'>Membre Connecté: Mr ".$_SESSION['nom']." ".$_SESSION['prenom']."</strong>";
require_once("../../includes/connect.php");
$conn = connect();
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $selectquery = "SELECT * FROM user WHERE email = :email AND role = 2 AND verification = 1";
    $stmt = $conn->prepare($selectquery);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $teacherid = $_SESSION['id'];
    if($row){
        $id_etudiant = $row['id'];
        $lastname = $row['nom'];
        $name = $row['prenom'];
        $insertquery = "INSERT INTO etudiant_inscrit(id_etudiant, nom, prenom, email, id_matiere, id_prof) VALUES (:id_etudiant, :lastname, :name, :email, :id, :teacherid)";
        $stmt = $conn->prepare($insertquery);
        $stmt->bindParam(':id_etudiant', $id_etudiant);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':teacherid', $teacherid);
        $stmt->execute();
        header("location:view.php?id=$id");
        die();
    } else {
        header("location:addstudenterror.php?id=$id");
        die();
    }
}
$id = $_GET['id'];
$conn = null;
?>
<form class="m-2" action="" method="post">  
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <div class="form-outline">
        <label class="form-label" for="email">Student's Email</label>
        <input type="email" id="email" name="email" class="form-control"/>
    </div>                          
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary bg-gradient btn-block" name="submit" onclick="AddStudent(event)">Add</button>
    </div>      
    <div class="d-grid gap-2 mt-3">
        <?php echo"<a class='btn btn-primary bg-gradient btn-block' href='view.php?id=$id'>Cancel</a>";?>
    </div>                   
</form>
<?php
include("../../includes/footer.php");
?>
