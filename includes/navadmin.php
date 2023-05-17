<?php $root_url = 'http://'.$_SERVER['HTTP_HOST'];?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient">
  <div class="container-fluid">
    <?php echo"<a class='navbar-brand' href='".$root_url."/backend/adminindex.php'>MySchool</a>";?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
        <?php echo"<a class='nav-link active' aria-current='page' href='".$root_url."/backend/logout.php'>Log out</a>";?>
      </div>
    </div>
  </div>
</nav>