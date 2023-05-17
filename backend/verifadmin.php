<?php
include("../includes/header.php");
include("../includes/navstat.php");
session_start();
if(isset($_SESSION['user'])){
  header("location:adminindex.php");
}else if(isset($_SESSION['role'])==1){
  header("location:../frontend/teacherindex.php");
}else if(isset($_SESSION['role'])==2){
  header("location:../frontend/studentindex.php");
}
?>
<form action="/backend/adminlogin.php" method="post">
    <!-- Password input -->
    <div class="form-outline mb-4 gap-2 mt-3 col-8 mx-auto text-center">
        <label class="form-label" for="adminpass">Physical Password</label>
        <input type="password" id="adminpass" name="adminpass" class="form-control" placeholder="This password is only available in physical form in the administration."/>
    </div>
    <!-- Submit button -->
    <div class="d-grid gap-2 mt-3 col-6 mx-auto">
        <button type="submit" class="btn btn-primary bg-gradient btn-block" onclick="AdminSignInControl(event)">Log in</button>
    </div>
</form>
<?php
include("../includes/footer.php");
?>