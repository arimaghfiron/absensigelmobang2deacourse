<?php
include("connection.php");
include("users_class.php");

$user = new Users();

if (isset($_POST['login'])) {
	$user->set_login_data($_POST['user_id'], $_POST['password']);

	$user_id = $user->get_user_id();
	$password = $user->get_password();

	$sql = "SELECT * FROM users WHERE user_id='$user_id'";
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		$sql = "$sql AND password='$password'";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			$data = $result->fetch_assoc();
			if ($data['keluar_kerja'] != NULL) {
				header("location:index.php?message=Selain Karyawan Dilarang Masuk !!");
				die();
			}
			session_start();
			$_SESSION['user_id'] = $data['user_id'];
			$_SESSION['nama_lengkap'] = $data['nama_lengkap'];
			$_SESSION['role'] = $data['role'];
			$_SESSION['status'] = "login";
			if ($data['role'] == 'admin') {
				header("location:dashboard/index-admin.php");
			} else {
				header("location:dashboard/index.php?message=Selamat datang di sistem absensi sederhana");
			}
		} else {
			header("location:index.php?message=Password Salah !!");
		}
	} else {
		header("location:index.php?message=Username Tidak Ditemukan !!");
	}
} else {
	header("location:index.php");
}
