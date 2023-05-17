<?php
include("../../includes/header.php");
include("../../includes/navadmin.php");
session_start();
if (!isset($_SESSION['user']) == 'admin') {
    if ($_SESSION['role'] == 1) {
        header("location:../../frontend/teacherindex.php");
    } else if ($_SESSION['role'] == 2) {
        header("location:../../frontend/studentindex.php");
    } else {
        header("location:../../index.php");
    }
}
require_once("../../includes/connect.php");
$conn = connect();
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $pass = $_POST['pass'];
    $password_hash = password_hash($pass, PASSWORD_DEFAULT);
    $selectquery = "SELECT * FROM user WHERE id = :id";
    $stmt = $conn->prepare($selectquery);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $insertquery = "UPDATE user SET pass = :password_hash WHERE id = :id";
        $stmt = $conn->prepare($insertquery);
        $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("location:../adminindex.php");
        die();
    } else {
        header("location:../adminindex.php");
        die();
    }
}
$id = $_GET['id'];
$conn = null;
?>
<form class="m-2" action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <!-- Title input -->
    <div class="form-outline">
        <label class="form-label" for="pass">New Password</label>
        <input type="password" id="pass" name="pass" class="form-control" />
    </div>
    <!-- Submit button -->
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary bg-gradient btn-block" name="submit" onclick="NewPassword(event)">Reset</button>
    </div>
    <div class="d-grid gap-2 mt-3">
        <?php echo "<a class='btn btn-primary bg-gradient btn-block' href='../adminindex.php'>Cancel</a>"; ?>
    </div>
</form>
<?php
include("../../includes/footer.php");
?>
