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
    $updatequery = "UPDATE matiere SET titre = :title, description = :desc WHERE id_matiere = :id";
    $stmt = $conn->prepare($updatequery);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':desc', $desc);
    $stmt->bindValue(':id', $id);
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
$selectquery = "SELECT * FROM matiere WHERE id_matiere = :id";
$stmt = $conn->prepare($selectquery);
$stmt->bindValue(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$conn = null;
?>

<form class="m-2" action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <!-- Title input -->
    <div class="form-outline">
        <label class="form-label" for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo $row['titre']; ?>" class="form-control" />
    </div>
    <!-- Description input -->
    <div class="form-outline">
        <label class="form-label" for="desc">Description</label>
        <input type="text" id="desc" name="desc" value="<?php echo $row['description']; ?>" class="form-control" />
    </div>
    <!-- Submit button -->
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary bg-gradient btn-block" name="submit" onclick="CreateSubject(event)">Edit</button>
    </div>
    <div class="d-grid gap-2 mt-3">
        <a class="btn btn-primary bg-gradient btn-block" href="../teacherindex.php">Cancel</a>
    </div>
</form>
<?php
include("../../includes/footer.php");
?>
