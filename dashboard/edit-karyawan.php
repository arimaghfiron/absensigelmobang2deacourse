<?php
    if(isset($_GET['NIK-edit'])){
        include("../connection.php");
        $NIK = $_GET['NIK-edit'];
        $sql = "SELECT * from users where user_id='$NIK'";
        $result = $db->query($sql);
        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo '<div class="bform"><form action="action-admin.php" method="POST" class="form">
            <p>EDIT DATA KARYAWAN</p>
                    <div class="inputform"><span>NIK</span>
                    <input name="nik" placeholder="NIK" readonly type="number" class="login-input" value="'.$data["user_id"].'"/></div>
                    <div class="inputform"><span>Nama Lengkap</span>
                    <input name="nama_lengkap" placeholder="Nama Lengkap" type="text" class="login-input" value="'.$data["nama_lengkap"].'"/></div>

                    <div class="inputform">
                    <span>Jabatan</span>
                    <input name="jabatan" placeholder="Jabatan" type="text" class="login-input" value="'.$data["role"].'"/>
</div>
<div class="inputform">
                    <span>Masuk Kerja</span>
                    <input name="masuk-kerja" type="date" class="login-input" value="'.$data["masuk_kerja"].'"/>
</div>
<div class="inputform">
                    <span>Keluar Kerja</span>
                    <input name="keluar-kerja" type="date" class="login-input" value="'.$data["keluar_kerja"].'"/>
</div>
                    <div class="inputform"><span>Password Lama</span>
                    <input name="password0" placeholder="Old Password" type="password" class="login-input" />
</div>
                    <div class="inputform"><span>Password Baru</span>           <input name="password1" placeholder="New Password" type="password" class="login-input" />
</div>
                    <div class="inputform"><span>Konfirmasi Password Baru</span>
                    <input name="password2" placeholder="Confirm New Password" type="password" class="login-input" />
</div>
                    <div class="btform"><button type="submit" name="edit" class="button">SIMPAN</button><button type="submit" name="cancel" class="button">BATAL</button></div>
                </form></div>';
        }
        else {
            echo "SERVER BERMASALAH, HUBUNGI IT SUPPORT !";
        }
        
    } else {
        header("location:index-admin.php?menu=data-karyawan");
    }
?>

