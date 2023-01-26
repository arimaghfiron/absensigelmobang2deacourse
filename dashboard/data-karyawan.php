
<?php 
    if(!isset($_GET['submenu']) || 
       $_GET['submenu'] !== "edit-karyawan" &&
       $_GET['submenu'] !== "tambah-karyawan" && 
       $_GET['submenu'] !== "hapus-karyawan" ){
        echo '<div class="bform"><a href="?menu=data-karyawan&submenu=tambah-karyawan"><button name="tambah">Tambah Karyawan Baru</button></a></div>';         
    } else { include ($_GET['submenu'].".php"); }
    
    ?>
    
      <div class="table">

    <div class="table_header"> 
    <p>DATA KARYAWAN</p>
      <form action="" method="POST">
            <input placeholder=" Pencarian" name="NIK" type="text" class="login-input" value="<?php if(isset($_POST['NIK'])){echo $_POST['NIK'];} ?>">
    <button type="submit" name="cari">Cari</button>
    <button type="submit" name="semua">Semua</button>
    </form>
    </div>
    <div class="table_section">
<table>
  <thead>
      <tr class="tr">
        <th width="5%">No.</th>
        <th width="10%">NIK</th>
        <th width="25%">Nama</th>
        <th width="15%">Jabatan</th>
        <th width="15%">Tanggal Masuk</th>
        <th width="15%">Tanggal Keluar</th>
        <th width="15%">Action</th>
      </tr>
  </thead>
  <tbody>
      <?php
        
include("../connection.php");
$sql = "SELECT * FROM users";
if (isset($_POST['cari']) && $_POST['NIK'] != NULL) { 
        $NIK = $_POST['NIK'];
      $sql = $sql." WHERE users.user_id='$NIK' OR nama_lengkap LIKE '%$NIK%' OR role LIKE '%$NIK%' OR masuk_kerja LIKE '%$NIK%' OR keluar_kerja LIKE '%$NIK%'";
}
        $sql = $sql." ORDER BY user_id";
      $result = $db->query($sql);

      $no = 1;
      while ($data = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $data['user_id'] . "</td>";
        echo "<td>" . $data['nama_lengkap'] . "</td>";
        echo "<td>" . $data['role'] . "</td>";
        echo "<td>" . $data['masuk_kerja'] . "</td>";
        echo "<td>" . $data['keluar_kerja'] . "</td>";
        echo "<td><a href='index-admin.php?menu=data-karyawan&submenu=edit-karyawan&NIK-edit=".$data['user_id']."' class='bt1'><i class='icon' data-feather='edit'></i><a/>";
        if($data['keluar_kerja'] != NULL){ echo "<a href='index-admin.php?menu=data-karyawan&submenu=hapus-karyawan&NIK-hapus=".$data['user_id']."&keluar='" . $data['keluar_kerja'] . "'"; ?> onclick="return false" <?php echo " class='offbtn'><i class='icon' data-feather='log-out'></i><a/>"; }
        else{ echo "<a href='index-admin.php?menu=data-karyawan&submenu=hapus-karyawan&NIK-hapus=".$data['user_id']."&keluar='" . $data['keluar_kerja'] . "'"; ?> onclick="return confirm('Yakin Mengeluarkan Karyawan Dengan NIK : <?php echo $data['user_id'];?> ?')" <?php echo " class='bt2'><i class='icon' data-feather='log-out'></i><a/>"; }
        echo "</td></tr>";
      }      ?>
    </tbody>
    </table>
    </div>
    </div>