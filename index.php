<?php
session_start();

if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    if($_SESSION['role'] == "admin"){
        header("location:dashboard/index-admin.php");
    } else {
  header("location:dashboard/index.php?message=Selamat datang kembali...");
}}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="img/ryu.png">
  <title>ABSENSI PAGE</title>

</head>

<body>
  <div class="container">
    <div class="wrapper">
      <h3 class="login-title">Login System</h3>
	        <h5 class="logout-tittle"><?php
        if (isset($_GET['message2'])) {
          echo $_GET['message2'];
        }
        ?></h5>
      <form action="login.php" method="POST" class="login-form">
        <?php
        if (isset($_GET['message'])) {
          echo $_GET['message'];
        }
        ?>
        <input name="user_id" type="text" class="login-input" placeholder="NIK" />
        <input name="password" type="password" class="login-input" placeholder="Password"/>
        <button type="submit" name="login" class="login-button">MASUK</button>
      </form>
    </div>
  </div>
</body>

</html>