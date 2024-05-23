<?php


include "secpass.php";
$secpass = new Secpass();

if($secpass->is_fileAlone("header.php")){
    die("Cannot access");
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img src="img/icon.png" width="35" height="35" class="d-inline-block align-top" alt="">
    SecPass
  </a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Login</a>
      </li>
      <?php
        if(isset($_SESSION['key'])){
            echo '<li class="nav-item"><a class="nav-link" href="src/logout.php">Logout</a></li>';
        }
      ?>
      
    </ul>
  </div>
</nav>