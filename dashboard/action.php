<?php
if (isset($_POST['absen'])) {
  include("../connection.php");
  session_start();

  date_default_timezone_set("Asia/Jakarta");

  $user_id = $_SESSION['user_id'];
  $tgl = date('Y-m-d');
  $time = date('H:i:s');

  $check_absen = "SELECT * FROM absensi WHERE user_id='$user_id' AND tgl='$tgl'";
  $check = $db->query($check_absen);

  if ($check->num_rows > 0) {
    // jika user sudah pernah absen di hari ini 👇
    header("location:index.php");
  } else {
    // jika user belum absen maka dia bisa absen hari ini 👇
    $sql = "INSERT INTO absensi (`id`, `user_id`, `tgl`, `jam_masuk`, `jam_keluar`) VALUES (NULL, '$user_id', '$tgl', '$time', NULL)";

    $result = $db->query($sql);

    if ($result === TRUE) {
      header("location:index.php");
    } else {
      header("location:index.php?message=Maaf Absen Masuk Gagal, Hubungi Admin !");
    }
  }
} else if (
  isset($_POST['ganti-pw']) &&
  $_POST['password0'] != NULL &&
  $_POST['password1'] != NULL &&
  $_POST['password2'] != NULL
) {
  include("../connection.php");
  $user_id = $_POST['ganti-pw'];

  $sql = "SELECT * FROM users WHERE user_id='$user_id'";
  $result = $db->query($sql);
  $data = $result->fetch_assoc();

  if ($_POST['password0'] != $data['password']) {
    header("location:index.php?menu=ganti-password&message=Password Lama Salah");
    die();
  } else if ($_POST['password1'] !== $_POST['password2']) {
    header("location:index.php?menu=ganti-password&message=Password Baru Tidak Sama");
    die();
  } else {
    $newPass = $_POST['password1'];
    $sql = "UPDATE users SET password='$newPass' WHERE user_id='$user_id'";
    $result = $db->query($sql);
    if ($result === TRUE) {
      header("location:index.php?message=Password Anda, BERHASIL DIPERBARUI !");
    } else {
      header("location:index.php?menu=ganti-password&message=Maaf Password Anda GAGAL Diperbarui, Hubungi Admin / IT SUPPORT");
    }
  }
}
else if (
  isset($_POST['pengajuan']) &&
  $_POST['jenis'] != NULL &&
  $_POST['tanggal'] != NULL &&
  $_POST['keterangan'] != NULL
) {
  include("../connection.php");
  $user_id = $_POST['pengajuan'];
  $jenis = $_POST['jenis'];
  $tgl = $_POST['tanggal'];
  $keter = $_POST['keterangan'];

  $sql = "SELECT max(req_id) as reqid FROM request";
  $result = $db->query($sql);
  $data = $result->fetch_assoc();
  $req_id = 1+$data['reqid'];

  $sql = "SELECT * FROM absensi WHERE user_id='$user_id' AND tgl ='$tgl'";
  $result = $db->query($sql);
  if($result->num_rows > 0){
    $data = $result->fetch_assoc();
    header("location:index.php?menu=pengajuan&message=Data anda di tanggal $tgl sudah ada, silahkan cek kembali. Jika terjadi kendala Hubungi Admin");
    die();
  } 
  else {
    $sql = "INSERT INTO request (`id`, `req_id`, `jenis`, `keterangan`, `status`) VALUES (NULL, '$req_id', '$jenis', '$keter', 'Pending')";
    $result = $db->query($sql);
    if($result === true){
      $sql = "INSERT INTO absensi (`id`, `user_id`, `tgl`, `jam_masuk`, `jam_keluar`,`req_id`) VALUES (NULL, '$user_id', '$tgl', '--:--:--','--:--:--', '$req_id')";
      $result = $db->query($sql);
      if($result === true){
        header("location:index.php?menu=pengajuan&message=Pengajuan Cuti Berhasil, Menunggu Persetujuan dari Atasan. Request ID = $req_id");
    die();  
      }
      else {
        $sql = "DELETE FROM request WHERE req_id='$req_id'";
        $result = $db->query($sql);
        if($result === true){
          header("location:index.php?menu=pengajuan&message=Pengajuan Cuti Gagal saat Sinkronisasi dengan Data Absensi. Silahkan Hubungi Admin");
    die();
        } else {
          header("location:index.php?menu=pengajuan&message=FATAL ERROR, MOHON HUBUNGI ADMIN / IT SUPPORT SEGERA !!");
    die();
        }
      }
    } else {
      header("location:index.php?menu=pengajuan&message=Pengajuan Cuti Gagal, Silahkan Hubungi Admin");
    die();
    }
  }
}
else {
  header("location:index.php");
  die();
}
