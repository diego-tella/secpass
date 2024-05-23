<?php
session_start();
if(!isset($_SESSION['key'])){
    header("location: index.php");
}
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<title>Lock passwords</title>
</head>
<body>

<?php
include "src/header.php";


?>
<center><br><br>
<p>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" >
    Create new Password <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
</svg>
  </button>
</p>
<div class="collapse" id="collapseExample">
    <!--collapse form starts here-->
<div style="text-align:left;" class="form-container">
<form method="POST" action="">
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Title</label>
    <input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
if(isset($_POST['title']) && isset($_POST['username']) && isset($_POST['password'])){
    

    $key = $_SESSION['key'];

    $title = $secpass->encrypt($_POST['title'], $key);
    $username = $secpass->encrypt($_POST['username'], $key);
    $password = $secpass->encrypt($_POST['password'], $key);

    $stmt = $secpass->db_connection->prepare('INSERT INTO passwords (user, passwordd, descriptionn) VALUES (:user, :passwordd, :descriptionn)');
    // Associa os valores aos placeholders
    $stmt->bindValue(':user', $username, SQLITE3_TEXT);
    $stmt->bindValue(':passwordd', $password, SQLITE3_TEXT);
    $stmt->bindValue(':descriptionn', $title, SQLITE3_TEXT);

    // Executa a query
    $result = $stmt->execute();

    if ($result) {
        echo "Password added";
    } else {
        echo "Error inserting record: " . $db_connection->lastErrorMsg();
    }

}

?>
</div>
<!--ends here-->
</div>
</center>

<?php
$key = $_SESSION['key'];
$cont = 1;
$result = $secpass->db_connection->query("select * from passwords;");
if (!$row = $result->fetchArray(SQLITE3_ASSOC)) {
    die("Error: database name invalid");
}else{
    echo '<div class="form-container">
    <ul class="list-group">';

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo '

  <li class="list-group-item d-flex justify-content-between align-items-center">
    <b>'.$secpass->decrypt($row['descriptionn'], $key).':</b> '.$secpass->decrypt($row['user'], $key).':'.$secpass->decrypt($row['passwordd'], $key).'
    <svg onclick="clica()"  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
    </svg>
  </li>';
}
  echo '
</ul>
</div>';
}

?>
</body>
<style>
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding-top: 20px; /* Adicionado um pouco de padding no topo */
        }
    </style>
<script>
    function clica(){
        document.getElementById
    }
</html>