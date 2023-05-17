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
echo "<strong class='text-center'>Membre Connecté: Mr ".$_SESSION['nom']." ".$_SESSION['prenom']."</strong>";
require_once("../../includes/connect.php");
$conn = connect();
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $id_matiere = $_POST['id_matiere'];
    $ex = $_POST['ex'];
    $ds = $_POST['ds'];
    $updatequery = "UPDATE etudiant_inscrit SET note_examen = :ex, note_ds = :ds WHERE id = :id";
    $stmt = $conn->prepare($updatequery);
    $stmt->bindValue(':ex', $ex);
    $stmt->bindValue(':ds', $ds);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();
    if ($result) {
        header("location:view.php?id=$id_matiere");
        die();
    } else {
        header("location:view.php?id=$id_matiere");
        die();
    }
}
$id = $_GET['id'];
$selectquery = "SELECT * FROM etudiant_inscrit WHERE id = :id";
$stmt = $conn->prepare($selectquery);
$stmt->bindValue(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$conn = null;
?>
<form class="m-2" action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="id_matiere" value="<?php echo $row['id_matiere']; ?>">
    <?php echo "<strong class='text-center'>Please Type 'NULL' if you do not wish to give a grade yet!</strong>"; ?>
    <!-- Note Examen input -->
    <div class="form-outline">
        <label class="form-label" for="ex">Note Examen</label>
        <input type="text" id="ex" name="ex" value="<?php echo $row['note_examen']; ?>" class="form-control"/>
    </div>
    <!-- Note DS input -->
    <div class="form-outline">
        <label class="form-label" for="ds">Note DS</label>
        <input type="text" id="ds" name="ds" value="<?php echo $row['note_ds']; ?>" class="form-control"/>
    </div>
    <!-- Submit button -->
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary bg-gradient btn-block" name="submit" onclick="EditNote(event)">Modify</button>
    </div>
    <div class="d-grid gap-2 mt-3">
        <a class="btn btn-primary bg-gradient btn-block" href="view.php?id=<?php echo $row['id_matiere']; ?>">Cancel</a>
    </div>
</form>
<?php
include("../../includes/footer.php");
?>
