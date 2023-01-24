<?php
if (
    !isset($_GET['submenu']) ||
    $_GET['submenu'] !== "input-absen" &&
    $_GET['submenu'] !== "input-absenpulang"
) {
} else {
    include($_GET['submenu'] . ".php");
}

?>
<div class="table">

    <div class="table_header">

        <p>DATA ABSENSI KARYAWAN</p>
        <form action="" method="POST">
            <input placeholder=" NIK" name="NIK" type="text" class="login-input" value="<?php if (isset($_POST['NIK'])) {
                                                                                            echo $_POST['NIK'];
                                                                                        } ?>">
            <button type="submit" name="cari">Cari</button>
            <button type="submit" name="semua">Semua</button>
        </form>
    </div>
    <div class="table_section">
        <table class="table">
            <thead>
                <tr class="tr">
                    <th width="5%">No.</th>
                    <th width="7%">NIK</th>
                    <th width="25%">Nama</th>
                    <th width="15%">Jabatan</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Absen Masuk</th>
                    <th width="10%">Absen Pulang</th>
                    <th width="11%">Keterangan</th>
                    <th width="7%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                include("../connection.php");
                date_default_timezone_set("Asia/Jakarta");
                $tgl = date('Y-m-d');
                $sql = "SELECT * FROM `users` as a,`absensi` as b LEFT JOIN request as c ON b.req_id=c.req_id WHERE a.user_id=b.user_id AND b.tgl <= '$tgl'";
                if (isset($_POST['cari']) && $_POST['NIK'] != NULL) {
                    $NIK = $_POST['NIK'];
                    $sql = $sql . " AND a.user_id='$NIK'";
                }
                $sql = $sql . " ORDER BY b.tgl desc, a.user_id";
                $sqluser = "SELECT * FROM users";
                if (isset($_POST['cari']) && $_POST['NIK'] != NULL) {
                    $NIKuser = $_POST['NIK'];
                    $sqluser = $sqluser . " WHERE user_id='$NIKuser'";
                }

                $no = 1;

                $intTgl = strtotime($tgl);
                $stopTgl = $intTgl - 30 * 60 * 60 * 24;
                

                for ($intTgl; $intTgl >= $stopTgl; $intTgl -= 60 * 60 * 24) {
                    $tgljd = date('Y-m-d', $intTgl);

                    $resultuser = $db->query($sqluser);
                    while ($datauser = $resultuser->fetch_assoc()) {
                        echo "<tr class='tr'>";
                        echo "<td class='td'>" . $no++ . "</td>";
                        echo "<td class='td'>" . $datauser['user_id'] . "</td>";
                        echo "<td class='td'>" . $datauser['nama_lengkap'] . "</td>";
                        echo "<td class='td'>" . $datauser['role'] . "</td>";
                        echo "<td class='td'> " . $tgljd . " </td>";

                        $cek = 0;

                        $result = $db->query($sql);
                        while ($data = $result->fetch_assoc()) {
                            if ($tgljd == $data['tgl'] && $datauser['user_id']==$data['user_id']) {
                                echo "<td class='td'>" . $data['jam_masuk'] . "</td>";
                                echo "<td class='td'>" . $data['jam_keluar'] . "</td>";
                                echo "<td class='td'>";
                                if ($data['jam_keluar'] == NULL) {
                                    if ($data['jam_masuk'] == NULL) {
                                        echo "Mangkir</td><td><a href='index-admin.php?menu=data-absensi&submenu=input-absen&NIK-absen=" . $data['user_id'] . "&tgl-absen=" . $data['tgl'] . "'>Input</a>";
                                    } else {
                                        echo "Belum Absen Pulang</td><td><a class='bt1' href='index-admin.php?menu=data-absensi&submenu=input-absenpulang&NIK-absen=" . $datauser['user_id'] . "&tgl-absen=" . $data['tgl'] . "&jam-masuk=" . $data['jam_masuk'] . "'>Input</a>";
                                    }
                                } else if ($data['status'] == 'Accept') {
                                    echo $data['jenis'] . "</td><td>";
                                } else {
                                    echo "Clear</td><td>";
                                }
                                echo "</td>";
                                $cek = 1;
                                break;
                            }
                        }
                        if ($cek == 0) {
                            echo "<td class='td'>--:--:--</td><td class='td'>--:--:--</td>";
                            if (date('D', $intTgl) == "Sun") {
                                echo "<td class='td'>Libur Hari Minggu</td><td></td>";
                            } else if (date('D', $intTgl) == "Sat") {
                                echo "<td class='td'>Libur Hari Sabtu</td><td></td>";
                            } else {
                                echo "<td class='td'>Mangkir</td><td><a class='bt1' href='index-admin.php?menu=data-absensi&submenu=input-absenpulang&NIK-mangkir=" . $datauser['user_id']."&tgl-mangkir=".$tgljd."&nama-lengkap=".$datauser['nama_lengkap'] ."&role=".$datauser['role']."'>Input</a></td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>