<?php
    if(isset($_GET['NIK-hapus'])){
        include("../connection.php");
        $NIK = $_GET['NIK-hapus'];
        $sql = "DELETE from absensi where user_id='$NIK'";
        $result = $db->query($sql);
        $sql = "DELETE from users where user_id='$NIK'";
        $result = $db->query($sql);
        if($result == true){
            echo "KARYAWAN DENGAN NIK : $NIK, TELAH BERHASIL DIHAPUS";
        }
        else {
            echo "HAPUS KARYAWAN DENGAN NIK : $NIK, GAGAL ! HUBUNGI IT SUPPORT";
        }
        
    } else {
        header("location:index-admin.php?menu=data-karyawan");
    }
?>