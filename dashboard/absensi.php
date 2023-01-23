<div class="bform">
  <?php
  include("../connection.php");
  date_default_timezone_set("Asia/Jakarta");
  $user_id = $_SESSION['user_id'];
  $tgl = date('Y-m-d');
  $time = date('H:i:s');

  if (isset($_POST['clockout'])) {
    $sql = "UPDATE absensi SET jam_keluar='$time' WHERE user_id='$user_id' AND tgl='$tgl'";
    $clockout = $db->query($sql);
    if ($clockout === TRUE) {
    } else {
      echo "<p>Maaf terjadi kesalahan</p>";
    }
  }
  $sql = "SELECT * FROM absensi WHERE user_id='$user_id' AND tgl='$tgl'";
  $result = $db->query($sql);
  if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    if (!empty($data['jam_keluar'])) {
      echo "<p>Absen Pulang Berhasil, Terimakasih telah bekerja hari ini</p>";
    } else {
      echo "
<form action='' method='POST' class='form'>
<span>Absen Masuk Berhasil, Selamat Bekerja</span>
        <button name='clockout' type='submit'>Absen Pulang</button>
      </form>";
    }
  } else {
    echo '<form action="action.php" method="POST">
  <button name="absen" type="submit">ABSEN MASUK</button>

</form>';
  }
  ?>

</div>
<div class="table">
  <div class="table_header">
    <p>DATA ABSENSI</p>
  </div>
  <div class="table_section">
    <table class="table">
      <thead>
        <tr class="tr">
          <th class="th">No.</th>
          <th class="th">Tanggal</th>
          <th class="th">Absen Masuk</th>
          <th class="th">Absen Pulang</th>
          <th class="th">Performa</th>
        </tr>
      </thead>
      <tbody>
        <?php


        $sql = "SELECT * FROM absensi as a LEFT JOIN request as b ON a.req_id=b.req_id WHERE a.user_id='$user_id' order by tgl desc";
        $result = $db->query($sql);
        $no = 1;
        while ($data = $result->fetch_assoc()) {
          if ($data['status'] != "Pending" && $data['status'] != "Reject") {
            echo "<tr class='tr'>";
            echo "<td class='td'>" . $no++ . "</td>";
            echo "<td class='td'> " . $data['tgl'] . " </td>";
            echo "<td class='td'> " . $data['jam_masuk'] . " </td>";
            if (empty($data['jam_keluar']) && !empty($data['jam_masuk'])) {
              echo "<td class='td'>Belum Absen Pulang</td>";
            } else {
              echo "<td class='td'> " . $data['jam_keluar'] . " </td>";
            }
            if (!empty($data['jam_masuk']) && !empty($data['jam_keluar'])) {
              if($data['status']=='Accept'){
                echo "<td class='td'>".$data['jenis']."</td>";
              } else {
                echo "<td class='td'>Clear</td>";
              }
            } else {
              echo "<td class='td'>Bermasalah</td>";
            }
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>