<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <title>SecPass</title>
</head>
<body>
<?php
session_start();
include "src/header.php"; //declare $secpass class here

$secpass = new Secpass();
if($secpass->is_firtTime()){
    if($secpass->firstTimeConfig()){
      include "src/formConfig.php";
    }
}
elseif(isset($_POST['name']) && isset($_POST['password'])){
        //blacklist to block some characters in pass
        $blacklist = array("'", ";", '"', "=");
        

        $secpass = new Secpass();
        $name = $_POST['name'];
        $password = $secpass->encrypt($_POST['password'], $_POST['password']);
        $checksum = $secpass->encrypt("batata", $_POST['password']);

        $stmt = $secpass->db_connection->prepare('INSERT INTO codeLog (code, namee, checksumm) VALUES (:code, :namee, :checksumm)');
        // Associa os valores aos placeholders
        $stmt->bindValue(':code', $password, SQLITE3_TEXT);
        $stmt->bindValue(':namee', $name, SQLITE3_TEXT);
        $stmt->bindValue(':checksumm', $checksum, SQLITE3_TEXT);

        // Executa a query
        $result = $stmt->execute();

        if ($result) {
            include "src/formLogin.php";
        } else {
            echo "Error inserting record: " . $db_connection->lastErrorMsg();
        }

}
elseif(isset($_POST['passLogin'])){
  $password = $_POST['passLogin'];
  $query = 'SELECT checksumm FROM codeLog';

  $result = $secpass->db_connection->query($query);
  if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    // Pega o valor da coluna 'name'
    $code = $row['checksumm'];
    if($secpass->isPasswordCorrect($code, $password)){
      $_SESSION["name"]=$secpass->getName();
      $_SESSION["key"]=$password;
      header("location: lock.php");
    }else{
      include "src/formLogin.php";
      echo "<center>senha invalida</center>";

    }
} else {
    echo "No record found.";
}

}else{
  include "src/formLogin.php";
}
  ?>
</body>
</html>