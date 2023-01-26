<?php
    if(isset($_GET['NIK-hapus'])){
        include("../connection.php");
        $NIK = $_GET['NIK-hapus'];
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date('Y-m-d');
        $sql = "UPDATE users SET keluar_kerja='$tgl' WHERE user_id='$NIK'";
        $result = $db->query($sql);
        if($result == true){
            header("location:index-admin.php?menu=data-karyawan&message=KARYAWAN DENGAN NIK : $NIK, TELAH BERHASIL DIKELUARKAN");
        }
        else {
            header("location:index-admin.php?menu=data-karyawan&message=MENGELUARKAN KARYAWAN DENGAN NIK : $NIK, GAGAL ! HUBUNGI IT SUPPORT");
        }
    }
    else {
            header("location:index-admin.php?menu=data-karyawan");
    }
?>