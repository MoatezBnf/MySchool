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
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $insertquery = "INSERT INTO matiere (id_prof, titre, description) VALUES (:id, :title, :desc)";
    $stmt = $conn->prepare($insertquery);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':desc', $desc);
    $result = $stmt->execute();
    if ($result) {
        header("location:../teacherindex.php");
        die();
    } else {
        header("location:../teacherindex.php");
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
        <label class="form-label" for="title">Title</label>
        <input type="text" id="title" name="title" class="form-control" />
    </div>
    <!-- Description input -->
    <div class="form-outline">
        <label class="form-label" for="desc">Description</label>
        <input type="text" id="desc" name="desc" class="form-control" />
    </div>
    <!-- Submit button -->
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary bg-gradient btn-block" name="submit" onclick="CreateSubject(event)">Create</button>
    </div>
    <div class="d-grid gap-2 mt-3">
        <a class="btn btn-primary bg-gradient btn-block" href="../teacherindex.php">Cancel</a>
    </div>
</form>
<?php
include("../../includes/footer.php");
?>
