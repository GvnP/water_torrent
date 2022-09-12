<?php
//koneksi ke database mysql,
$koneksi = mysqli_connect("localhost", "root" , "", "volumeair");
$koneksitest = mysqli_connect("localhost", "root", "", "ethernettest");
//cek jika koneksi ke mysql gagal, maka akan tampil pesan berikut
if (mysqli_connect_errno()){
	echo "gagal" . mysqli_connect_error();
}

?>

