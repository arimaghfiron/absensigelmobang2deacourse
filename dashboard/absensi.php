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
  $sql = "SELECT * FROM absensi as a LEFT JOIN request as b ON a.req_id=b.req_id WHERE a.user_id='$user_id' AND a.tgl='$tgl'";
  $result = $db->query($sql);

  $btnabsen = '<form action="action.php" method="POST">
  <button name="absen" type="submit">ABSEN MASUK</button>
</form>';
  if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    if ($data['status'] == 'Accept') {
      echo "<p>Jadwal Anda Hari Ini " . $data['jenis'] . " !</p>";
    } else if (!empty($data['jam_keluar'])) {
      if (strtotime($data['jam_keluar']) == NULL) {
        echo $btnabsen;
      } else {
        echo "<p>Absen Pulang Berhasil, Terimakasih telah bekerja hari ini</p>";
      }
    } else {
      echo "
      <form action='' method='POST' class='form'>
      <span>Absen Masuk Berhasil, Selamat Bekerja</span>
              <button name='clockout' type='submit'>Absen Pulang</button>
            </form>";
    }
  } else {
    echo $btnabsen;
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
          <th class="th" width='5%'>No.</th>
          <th class="th" width='20%'>Tanggal</th>
          <th class="th" width='25%'>Absen Masuk</th>
          <th class="th" width='25%'>Absen Pulang</th>
          <th class="th" width='25%'>Performa</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;

        $intTgl = strtotime($tgl);
        $stopTgl = $intTgl - 30 * 60 * 60 * 24;

        $sql = "SELECT * FROM absensi as a LEFT JOIN request as b ON a.req_id=b.req_id WHERE a.user_id='$user_id' AND a.tgl <= '$tgl' order by tgl desc";
        $absen = [];
        $hasil2 = $db->query($sql);
        while ($data2 = $hasil2->fetch_assoc()) {
          array_push($absen, $data2);
        }

        for ($intTgl; $intTgl >= $stopTgl; $intTgl -= 60 * 60 * 24) {
          $tgljd = date('Y-m-d', $intTgl);

          echo "<tr class='tr'>";
          echo "<td class='td'>" . $no++ . "</td>";
          echo "<td class='td'> " . $tgljd . " </td>";

          $cek = 0;
          // $result = $db->query($sql);
          // while ($data = $result->fetch_assoc()) {
            foreach ($absen as $data) {
            if ($tgljd == $data['tgl']) {

              echo "<td class='td'> " . $data['jam_masuk'] . " </td>";
              if (empty($data['jam_keluar']) && !empty($data['jam_masuk'])) {
                echo "<td class='td'>Belum Absen Pulang</td>";
              } else {
                echo "<td class='td'> " . $data['jam_keluar'] . " </td>";
              }
              if ($data['status'] == 'Accept') {
                echo "<td class='td'>" . $data['jenis'] . "</td>";
              } else if (!empty($data['jam_masuk']) && strtotime($data['jam_keluar']) != NULL) {
                echo "<td class='td'>Clear</td>";
              } else {
                echo "<td class='td'>Unclear</td>";
              }
              $cek = 1;
              break;
            }
          }
          if ($cek == 0) {
            echo "<td class='td'>--:--:--</td><td class='td'>--:--:--</td>";
            if (date('D', $intTgl) == "Sun") {
              echo "<td class='td'>Libur Hari Minggu</td>";
            } else if (date('D', $intTgl) == "Sat") {
              echo "<td class='td'>Libur Hari Sabtu</td>";
            } else {
              echo "<td class='td'>Mangkir</td>";
            }
          }
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>