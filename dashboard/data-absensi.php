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
                $sql = "SELECT * FROM `users` as a,`absensi` as b LEFT JOIN request as c ON b.req_id=c.req_id WHERE a.user_id=b.user_id";
                if (isset($_POST['cari']) && $_POST['NIK'] != NULL) {
                    $NIK = $_POST['NIK'];




                    $sql = $sql . " AND a.user_id='$NIK'";
                }
                $sql = $sql . " ORDER BY b.tgl desc, a.user_id";
                $result = $db->query($sql);

                $no = 1;
                while ($data = $result->fetch_assoc()) {
                    if ($data['status'] != "Pending" && $data['status'] != "Reject") {
                        echo "<tr class='tr'>";
                        echo "<td class='td'>" . $no++ . "</td>";
                        echo "<td class='td'>" . $data['user_id'] . "</td>";
                        echo "<td class='td'>" . $data['nama_lengkap'] . "</td>";
                        echo "<td class='td'>" . $data['role'] . "</td>";
                        echo "<td class='td'>" . $data['tgl'] . "</td>";
                        echo "<td class='td'>" . $data['jam_masuk'] . "</td>";
                        echo "<td class='td'>" . $data['jam_keluar'] . "</td>";
                        echo "<td class='td'>";
                        if ($data['jam_keluar'] == NULL) {
                            if ($data['jam_masuk'] == NULL) {
                                echo "Mangkir</td><td><a href='index-admin.php?menu=data-absensi&submenu=input-absen&NIK-absen=" . $data['user_id'] . "&tgl-absen=" . $data['tgl'] . "'>Input</a>";
                            } else {
                                echo "Belum Absen Pulang</td><td><a class='bt1' href='index-admin.php?menu=data-absensi&submenu=input-absenpulang&NIK-absen=" . $data['user_id'] . "&tgl-absen=" . $data['tgl'] . "&jam-masuk=" . $data['jam_masuk'] . "'>Input</a>";
                            }
                        } else if ($data['status'] == 'Accept') {
                            echo $data['jenis'] . "</td><td>";
                        } else {
                            echo "Clear</td><td>";
                        }
                        echo "</td></tr>";
                    }
                }      ?>
            </tbody>
        </table>
    </div>
</div>