<?php
// TAMBAH KARYAWAN
if(isset($_POST['input']) && 
  $_POST['password'] != NULL &&
  $_POST['nama_lengkap'] != NULL &&
  $_POST['jabatan'] != NULL ){
    
    
   if($_POST['password'] !== $_POST['password2']){
       header("location:index-admin.php?menu=data-karyawan&submenu=tambah-karyawan&message=Password tidak sama");
   } else {
       include("../connection.php");
$sql="SELECT max(user_id) as max FROM users";
$result = $db->query($sql);
$data = $result->fetch_assoc();
$max_nik = 1+$data['max'];
$nama_lengkap = $_POST['nama_lengkap'];
$role = $_POST['jabatan'];
$password = $_POST['password'];
    
    $sql="INSERT INTO users (`id`, `user_id`, `password`, `nama_lengkap`, `role`) VALUES (NULL, '$max_nik', '$password','$nama_lengkap', '$role')";
    $result = $db->query($sql);
    if ($result === TRUE) {
    header("location:index-admin.php?menu=data-karyawan&message=Data Karyawan Baru Berhasil Ditambahkan dengan NIK : $max_nik");
  } else {
    header("location:index-admin.php?menu=data-karyawan&message=Maaf Data GAGAL Ditambahakan, Hubungi IT SUPPORT");
  }
    
   }
} 

// EDIT KARYAWAN
else if(isset($_POST['edit']) && 
  $_POST['nik'] !== NULL &&
  $_POST['nama_lengkap'] !== NULL &&
  $_POST['jabatan'] !== NULL ){
    
    include("../connection.php");
    $user_id = $_POST['nik'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $role = $_POST['jabatan'];
    
        $sql="SELECT * FROM users WHERE user_id='$user_id'";
        $result = $db->query($sql);
        $data = $result->fetch_assoc();
    
    $sql="UPDATE users SET nama_lengkap='$nama_lengkap',role='$role' WHERE user_id='$user_id'";
    
    if($_POST['password0'] != NULL &&
    $_POST['password1'] != NULL &&
    $_POST['password2'] != NULL
      ){
        if($_POST['password0'] != $data['password']){
            header("location:index-admin.php?menu=data-karyawan&submenu=edit-karyawan&NIK-edit=$user_id&message=Password Lama Salah");
            die();
        } else if($_POST['password1'] !== $_POST['password2']){
       header("location:index-admin.php?menu=data-karyawan&submenu=edit-karyawan&NIK-edit=$user_id&message=Password Baru Tidak Sama");
            die();
   } else {
            $newPass = $_POST['password1'];
            $sql="UPDATE users SET nama_lengkap='$nama_lengkap',role='$role',password='$newPass' WHERE user_id='$user_id'";
        }
    }
    
    if($nama_lengkap==$data['nama_lengkap'] && $role==$data['role']){
        header("location:index-admin.php?menu=data-karyawan&submenu=edit-karyawan&NIK-edit=$user_id&message=Tidak Ada Yang Diperbarui");
            die();
        die();
    }
   
    $result = $db->query($sql);
    if ($result === TRUE) {
    header("location:index-admin.php?menu=data-karyawan&message=Data Karyawan dengan NIK : $user_id, BERHASIL DIPERBARUI !");
  } else {
    header("location:index-admin.php?menu=data-karyawan&message=Maaf Data GAGAL Diperbarui, Hubungi IT SUPPORT");
  }
    
   
//    ABSEN
} else if(isset($_POST['edit-absen']) && 
  $_POST['jam-masuk'] != NULL &&
  $_POST['jam-pulang'] != NULL) {
    
    $user_id = $_POST['nik'];
    
    include("../connection.php");
    $tgl = $_POST['tgl'];
    $jam_masuk = $_POST['jam-masuk'];
    $jam_pulang = $_POST['jam-pulang'];
    
    $sql="UPDATE absensi SET jam_masuk='$jam_masuk',jam_keluar='$jam_pulang' WHERE user_id='$user_id' AND tgl='$tgl'";

  $result = $db->query($sql);

  if ($result === TRUE) {
    header("location:index-admin.php?menu=data-absensi&message=Data Absensi Karyawan dengan NIK $user_id pada Tanggal $tgl, TELAH DIPERBARUI");
  } else {
    header("location:index-admin.php?menu=data-absensi&message= Maaf Data Absensi Karyawan dengan NIK $user_id pada Tanggal $tgl, GAGAL DIPERBARUI. HUBUNGI IT SUPPORT !");
      
  }
    
}

else if(isset($_POST['accept'])) {
    
    $req_id = $_POST['accept'];
    
    include("../connection.php");
    
    $sql="UPDATE request SET status='Accept' WHERE req_id='$req_id'";

  $result = $db->query($sql);

  if ($result === TRUE) {
    header("location:index-admin.php?menu=approval&message=Pengajuan Cuti dengan Request ID :  $req_id, TELAH DISETUJUI");
  } else {
    header("location:index-admin.php?menu=approval&message=Pengajuan Cuti dengan Request ID :  $req_id, GAGAL DIPERBARUI. HUBUNGI IT SUPPORT !");
      
  }
    
}

else if(isset($_POST['reject'])) {
    
  $req_id = $_POST['reject'];
  
  include("../connection.php");
  
  $sql="UPDATE request SET status='Reject' WHERE req_id='$req_id'";

$result = $db->query($sql);

if ($result === TRUE) {
  header("location:index-admin.php?menu=approval&message=Pengajuan Cuti dengan Request ID :  $req_id, TELAH DITOLAK");
} else {
  header("location:index-admin.php?menu=approval&message=Pengajuan Cuti dengan Request ID :  $req_id, GAGAL DIPERBARUI. HUBUNGI IT SUPPORT !");
    
}
  
}




else{
    if(isset($_POST['input'])){
    header("location:index-admin.php?menu=data-karyawan&submenu=tambah-karyawan");
} else if(isset($_POST['edit'])){
    header("location:index-admin.php?menu=data-karyawan");
}else if(isset($_POST['edit-absen'])){
    header("location:index-admin.php?menu=data-absensi");
}
else if(isset($_POST['cancel'])){
  header("location:index-admin.php?menu=data-karyawan");
}
else if(isset($_POST['cancel-absen'])){
  header("location:index-admin.php?menu=data-absensi");
}
       }




?>