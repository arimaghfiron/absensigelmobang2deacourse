<div class="bform">
    <form action="action.php" method="POST" class="form">
        <p>PENGAJUAN CUTI</p>
        <div class="inputform"><span>Jenis Cuti</span>
        <!-- <div class="input-ajuan"> -->
            <select class='ajuan' name="jenis">
                <option value="Cuti Tahunan">Cuti Tahunan</option>
                <option value="Cuti Sakit">Cuti Sakit</option>
                <option value="Cuti Menikah">Cuti Menikah</option>
            </select>
        <!-- </div> -->
    </div>
        <div class="inputform"><span>Tanggal</span><input class='ajuan' name="tanggal" placeholder="Tanggal" type="date" class="login-input" /></div>
        <div class="inputform"><span>Keterenagan</span><textarea class='ajuan' style="margin-left: 1rem;" placeholder="Keterangan Cuti" name="keterangan"></textarea>
        </div>
        <div class="btform">
            <button type="submit" name="pengajuan" class="button" value="<?php
                                                                            echo $_SESSION['user_id'];
                                                                            ?>">AJUKAN</button>
            <button type="submit" name="cancel" class="button">BATAL</button>
        </div>
    </form>
</div>

<div class="table">
    <div class="table_header"> 
    <p>DATA ABSENSI</p>
    <form action="" method="POST">
            <input placeholder=" Pencarian" name="NIK" type="text" class="login-input" value="<?php if(isset($_POST['NIK'])){echo $_POST['NIK'];} ?>">
    <button type="submit" name="cari">Cari</button>
    <button type="submit" name="semua">Semua</button>
    </form>
    </div>
    <div class="table_section">
<table class="table">
  <thead>
  <tr class="tr">
    <th class="th">No.</th>
    <th class="th">Request ID</th>
    <th class="th">Tanggal</th>
    <th class="th">Jenis Cuti</th>
    <th class="th">Keterangan</th>
    <th class="th">Status</th>
  </tr>
</thead>
<tbody>
<?php
    include("../connection.php");

  $sql = "SELECT * FROM absensi as a, request as b WHERE a.req_id=b.req_id AND a.user_id='$user_id'";
  if (isset($_POST['cari']) && $_POST['NIK'] != NULL) { 
    $NIK = $_POST['NIK'];
  $sql = $sql." AND (a.req_id='$NIK' OR b.status LIKE '%$NIK%' OR b.jenis LIKE '%$NIK%' OR a.tgl LIKE '%$NIK%' OR b.keterangan LIKE '%$NIK%')";
}
$sql = $sql." order by a.tgl desc";
  $result = $db->query($sql);
     $no = 1;
  while ($data = $result->fetch_assoc()) {
    echo "<tr class='tr'>";
      
    echo "<td class='td'>" . $no++ . "</td>";
    echo "<td class='td'> " . $data['req_id'] . " </td>";
    echo "<td class='td'> " . $data['tgl'] . " </td>";
    echo "<td class='td'> " . $data['jenis'] . " </td>";
    echo "<td class='td'> " . $data['keterangan'] . " </td>";
    echo "<td class='td'> " . $data['status'] . " </td>";
    echo "</tr>";
  }
  ?>
  </tbody>
</table>
</div>
</div>

