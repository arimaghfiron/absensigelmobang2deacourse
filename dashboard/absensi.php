<div class="bform">
  <?php
  include("../connection.php");
  date_default_timezone_set("Asia/Jakarta");
  $user_id = $_SESSION['user_id'];
  $tgl = date('Y-m-d');
  $time = date('H:i:s');
  $intTgl = strtotime($tgl);
  $stopTgl = $intTgl - 30 * 60 * 60 * 24;

  if (isset($_POST['clockout'])) {
    $sql = "UPDATE absensi SET jam_keluar='$time' WHERE user_id='$user_id' AND tgl='$tgl'";
    $clockout = $db->query($sql);
    if ($clockout === TRUE) {
    } else {
      echo "<p>Maaf terjadi kesalahan</p>";
    }

  }
  
  $sql = "SELECT * FROM users WHERE user_id='$user_id'";
  $hasil = $db->query($sql);
  $datauser = mysqli_fetch_row($hasil);

  if (isset($_POST['semua'])) {
    $stopTgl = strtotime($datauser[5]);
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
    <form action="" method="POST">


      <input name="tgl-awal" type="date" class="login-input" value="<?php if(isset($_POST['semua'])){
                echo date('Y-m-d', $stopTgl);
            } else if (isset($_POST['tgl-awal'])) {

                                                                      echo $_POST['tgl-awal'];
                                                                    } else {
                                                                      echo date('Y-m-d', $stopTgl);
                                                                    } ?>">
      <span style='padding: 0.5rem'>s/d</span>

      <input name="tgl-akhir" type="date" class="login-input" value="<?php if(isset($_POST['semua'])){
                echo $tgl;
            } else if (isset($_POST['tgl-akhir'])) {
                                                                        echo $_POST['tgl-akhir'];
                                                                      } else {
                                                                        echo date('Y-m-d', $intTgl);
                                                                      } ?>">
      <button type="submit" name="cari">Cari</button>
      <button type="submit" name="semua">Semua</button>
    </form>
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

        $tgl_awal = date('Y-m-d', $stopTgl);
        $tgl_akhir = $tgl;

        if (isset($_POST['cari'])) {
          if ($_POST['tgl-awal'] != NULL && $_POST['tgl-akhir'] != NULL) {
            $tgl_awal = $_POST['tgl-awal'];
            $tgl_akhir = $_POST['tgl-akhir'];
            $stopTgl = strtotime($tgl_awal);
            $intTgl = strtotime($tgl_akhir);
            if ($stopTgl > $intTgl) {
              header('location:index.php?message=Tanggal Awal melebihi Tanggal Akhir, Mohon masukkan data tanggal dengan benar !');
              die();
            }
          } else {
            header('location:index.php?message=Data Tanggal KOSONG, Mohon masukkan data tanggal dengan benar ! !');
            die();
          }
        }
        $sql = "SELECT * FROM absensi as a LEFT JOIN request as b ON a.req_id=b.req_id WHERE a.user_id='$user_id' AND a.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY a.tgl desc";

        $hasil = $db->query($sql);
        $absen = mysqli_fetch_all($hasil);

        for ($intTgl; $intTgl >= $stopTgl; $intTgl -= 60 * 60 * 24) {
          $tgljd = date('Y-m-d', $intTgl);

          if ($intTgl >= strtotime($datauser[5])) {
            echo "<tr class='tr'>";
            echo "<td class='td'>" . $no++ . "</td>";
            echo "<td class='td'> " . $tgljd . " </td>";

            $cek = 0;
            foreach ($absen as $data) {

              if ($tgljd == $data[2]) {
                echo "<td class='td'> " . $data[3] . " </td>";
                if (empty($data[4]) && !empty($data[3])) {
                  echo "<td class='td'>Belum Absen Pulang</td>";
                } else {
                  echo "<td class='td'> " . $data[4] . " </td>";
                }
                if ($data[10] == 'Accept') {
                  echo "<td class='td'>" . $data[8] . "</td>";
                }
                else if (strtotime($data[3]) == NULL && strtotime($data[4]) == NULL) {
                   if($data[10] == 'Pending' || $data[10] == 'Reject') {
                    echo "<td class='td'>Mangkir</td>";
                  } 
                }
                else if (!empty($data[3]) && strtotime($data[4]) != NULL) {
                  echo "<td class='td'>Clear</td>";
                } else{
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
          } else {
            break;
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>