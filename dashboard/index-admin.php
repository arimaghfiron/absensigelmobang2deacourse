<?php
session_start();
$id_admin = $_SESSION['user_id'];
$nama_admin = $_SESSION['nama_lengkap'];
$role = $_SESSION['role'];
$status = $_SESSION['status'];

if ($status != "login") {
  header("location:../index.php?message=Silahkan login terlebih dahulu!");
}
if ($role != "admin") {
  header("location:index.php?message=Maaf Anda Bukan Admin!");
}    
if (isset($_GET['logout'])) {
  session_destroy();
  header("location:../index.php?message2=Terimakasih sudah berkunjung");
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="dashboard.css" />
  <title>ADMIN</title>
</head>

<body>
    <nav class="navbar">
      <div class="navbar-extra" id="hamburger">
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
        <a href="index-admin.php" class="navbar-logo">DASHBOARD <span>ADMIN</span></a>
        
        <div class='navbar-nav'>
        <a href="index-admin.php?menu=data-karyawan">Data Karyawan</a>
        <a href="index-admin.php?menu=data-absensi">Absensi Karyawan</a>
        <a href="index-admin.php?menu=approval">Approval</a>
        <a href="index.php?message=Selamat Datang di Menu Absen Sederhana">Dashboard Absen</a>
        </div>
        
        <div class="navbar-extra">
        <a href="#" id="nama"><?=$nama_admin?></a>
        <a href="index-admin.php?logout=true" id="logout"><i data-feather="log-out"></i></a>
        </div>
        </nav>
       
        
        <section class="hero" id="home">
          <main class="content">
  
      <?php 
      if (isset($_GET['message'])) {
      $message = $_GET['message'];
      echo "<div class='bform' style='width: 100vw;'><H1 style='text-align:center'>$message</h1></div>";

    }
    if(!isset($_GET['menu']) || 
       $_GET['menu'] !== "data-karyawan" && 
       $_GET['menu'] !== "data-absensi" 
      && $_GET['menu'] !== "approval"
      ){
        date_default_timezone_set("Asia/Jakarta");
        $time = date('H');
        if($time <= 10 && $time >=3) {
          $waktu = "Pagi. Awali pagimu dengan senyuman 😊";
        } else if ($time >=11 && $time <= 14) {
          $waktu = "Siang. Tetap semangat ya, meskipun lumayan lelah ✊";
        
        } else if ($time >=15 && $time <= 17) {
          $waktu = "Sore. Semangat yuk, Sebentar lagi selesai 💪";
        } else {
          $waktu = "Malam. Wah hebat sudah malam masih bekerja 🔥";
        }
        echo "<div class='bform' style='width: 100vw;'><H1 style='text-align:center'>Hi, Admin $nama_admin, Selamat $waktu</H1></div>";
    } else {
          include ($_GET['menu'].".php");
    
        ?>
      
  <div style="display: flex; justify-content:center;align-items:center; margin-top: 20px;">
    <button style="text-align:center" onclick="window.print()">CETAK LAPORAN</button>
  </div>
  <?php } ?>
  </main>
  </section>
    <script>
      feather.replace()
    </script>
    <script src="sidebar.js"></script>
    <div></body>
</html>
