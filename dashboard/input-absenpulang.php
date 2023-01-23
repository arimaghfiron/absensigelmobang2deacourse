<?php
    if(isset($_GET['NIK-absen'])){
        include("../connection.php");
        $NIK = $_GET['NIK-absen'];
        $tgl = $_GET['tgl-absen'];
        $jam_masuk = $_GET['jam-masuk'];
        $sql = "SELECT * from users as a,absensi as b where a.user_id=b.user_id AND b.user_id='$NIK' AND b.tgl='$tgl'";
        $result = $db->query($sql);
        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo '<div class="bform"><form action="action-admin.php" method="POST" class="form">
            <p>EDIT DATA ABSEN</p>
                    <div class="inputform"><span>NIK</span>
                    <input name="nik" placeholder="NIK" readonly type="number" class="login-input" value="'.$data["user_id"].'"/>
                  </div> <div class="inputform">  <span>Nama Lengkap</span>
                    <input name="nama_lengkap" placeholder="Nama Lengkap" readonly type="text" class="login-input" value="'.$data["nama_lengkap"].'"/>
</div> <div class="inputform"> <span>Jabatan </span>
                    <input name="jabatan" placeholder="Jabatan" readonly type="text" class="login-input" value="'.$data["role"].'"/>
</div> <div class="inputform"> <span>Tanggal </span>
                    <input name="tgl" type="text" readonly value='.$tgl.' class="login-input" />
</div> <div class="inputform"> <span>Absen Masuk</span>
                    <input name="jam-masuk" type="time" step=1 value='.$jam_masuk.' class="login-input" />
</div> <div class="inputform"> <span>Absen Pulang </span>
 <input name="jam-pulang" type="time" step=1 class="login-input" />
</div> <div class="btform"><button type="submit" name="edit-absen" class="button">SIMPAN</button>
                    <button type="submit" name="cancel-absen" class="button">BATAL</button></div>
                </form></div>';
        }
        else {
            echo "SERVER BERMASALAH, HUBUNGI IT SUPPORT !";
        }
        
    } else {
        header("location:index-admin.php?menu=data-absensi");
    }
?>