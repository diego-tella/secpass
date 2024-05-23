<?php
$secpass = new Secpass();

if($secpass->is_fileAlone("database.php")){
    die("Cannot access");
}

?>

<form  class="form-container" method="POST" action="">
<h1>Login</h1>

  <div class="form-group">
    <label for="exampleInputEmail1">Your password</label>
    <input name="passLogin" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter password">
    <small id="emailHelp" class="form-text text-muted">Your master password</small>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  
</form>
</div>

<style>
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding-top: 20px; /* Adicionado um pouco de padding no topo */
        }
    </style>