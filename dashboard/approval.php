    <div class="table">

    <div class="table_header"> 

<p>DATA PANGAJUAN CUTI KARYAWAN</p>
      <form action="" method="POST">
            <input placeholder=" Pencarian" name="NIK" type="text" class="login-input" value="<?php if(isset($_POST['NIK'])){echo $_POST['NIK'];} ?>" >
    <button type="submit" name="cari">Cari</button>
    <button type="submit" name="semua">Semua</button>
    </form>
    </div>
    <div class="table_section">
<table class="table">
  <thead>
      <tr class="tr">
        <th width="5%">No.</th>
        <th width="5%">NIK</th>
        <th width="15%">Nama</th>
        <th width="10%">Jabatan</th>
        <th width="10%">Request ID</th>
        <th width="10%">Tanggal</th>
        <th width="10%">Jenis Cuti</th>
        <th width="15%">Keterangan</th>
        <th width="10%">Status</th>
        <th width="10%">Action</th>
      </tr>
</thead>
<tbody>
      <?php
        
include("../connection.php");
$sql = "SELECT * FROM `users` as a,`absensi` as b, request as c WHERE a.user_id=b.user_id AND b.req_id=c.req_id";
if (isset($_POST['cari']) && $_POST['NIK'] != NULL) { 
        $NIK = $_POST['NIK'];
    $sql = $sql." AND (a.user_id='$NIK' OR b.req_id='$NIK' OR c.status LIKE '%$NIK%' OR c.jenis LIKE '%$NIK%' OR b.tgl LIKE '%$NIK%' OR c.keterangan LIKE '%$NIK%' OR a.nama_lengkap LIKE '%$NIK%' OR a.role LIKE '%$NIK%')";
}
    $sql = $sql." ORDER BY c.req_id desc";
      $result = $db->query($sql);

      $no = 1;
      while ($data = $result->fetch_assoc()) {
        $req_id = $data['req_id'];
        echo "<tr class='tr'>";
        echo "<td class='td'>" . $no++ . "</td>";
        echo "<td class='td'>" . $data['user_id'] . "</td>";
        echo "<td class='td'>" . $data['nama_lengkap'] . "</td>";
        echo "<td class='td'>" . $data['role'] . "</td>";
        echo "<td class='td'>" . $data['req_id'] . "</td>";
        echo "<td class='td'>" . $data['tgl'] . "</td>";
        echo "<td class='td'>" . $data['jenis'] . "</td>";
        echo "<td class='td'>" . $data['keterangan'] . "</td>";
        echo "<td class='td'>" . $data['status'] . "</td>";
        echo "<td class='td'>";
        if($data['status']=="Pending"){
            echo "<form class='form' action='action-admin.php' method='POST'><button class='bt1' name='accept' value='$req_id'>Setuju</button><button  class='bt2' name='reject' value='$req_id'>Tolak</button></form>";
        }else {
            echo "Clear";
        }
        echo "</td></tr>";
      }      ?>
      </tbody>
    </table>
    </div>
    </div>