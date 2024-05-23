<?php

if($secpass->is_fileAlone("formConfig.php")){
    die("Cannot access");
}

?>
<div>

<form  class="form-container" method="POST" action="">
<h1>Setup SecPass</h1>

  <div class="form-group">
    <label for="exampleInputEmail1">Your name</label>
    <input name="name" type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
    <small id="emailHelp" class="form-text text-muted">Your name to you identify</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    <small id="emailHelp" class="form-text text-muted">Your new super password. Make sure it is strong</small>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <?php
    if(isset($_POST['name']) && isset($_POST['password'])){
        //blacklist to block some characters
        $secpass = new Secpass();
        $name = $_POST['name'];
        $password = $secpass->encrypt($_POST['password'], $_POST['password']);
        $checksum = $secpass->encrypt("batata", $_POST['password']);

        $stmt = $secpass->db_connection->prepare('INSERT INTO codeLog (code, name, checksum) VALUES (:code, :name, :checksum)');
        echo "teste";
        // Associa os valores aos placeholders
        $stmt->bindValue(':code', $password, SQLITE3_TEXT);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':checksum', $checksum, SQLITE3_TEXT);

        // Executa a query
        $result = $stmt->execute();

        if ($result) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $db_connection->lastErrorMsg();
        }

    }else{
        echo "<small id=''mailHelp' class='form-text text-muted'>Username or password invalid</small>";
    }
  ?>
</form>
</div>

<style>
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding-top: 20px; /* Adicionado um pouco de padding no topo */
        }
    </style>