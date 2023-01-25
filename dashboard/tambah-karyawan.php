<?php
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d'); 
?>
<div class="bform"><form action="action-admin.php" method="POST" class="form">            <p>TAMBAH DATA KARYAWAN</p><div class="inputform"><span>Nama Lengkap</span>
    <input name="nama_lengkap" placeholder="Nama Lengkap" type="text" class="login-input" /></div>
  <div class="inputform"><span>Jabatan</span><input name="jabatan" placeholder="Jabatan" type="text" class="login-input" /></div>
  <div class="inputform"><span>Tanggal Masuk</span><input name="masuk-kerja" type="date" class="login-input" value="<?=$tgl?>" /></div>
<div class="inputform"><span>Password</span> <input name="password" placeholder="Password" type="password" class="login-input" /></div>
<div class="inputform"><span>Konfirmasi Password</span><input name="password2" placeholder="Confirm Password" type="password" class="login-input" /></div>
    <div class="btform">
    <button type="submit" name="input" class="button">TAMBAH</button>
    <button type="submit" name="cancel" class="button">BATAL</button>
    </div>
</form></div>