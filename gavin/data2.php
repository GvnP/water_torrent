<?php
$server 	= 'localhost';
$userNM 	= 'root';
$pass 		= '';
$database 	= 'testing';
$conn = mysqli_connect($server, $userNM, $pass, $database);

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}

$sql = 'select * from data order by id desc';
$run = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($run);
$nilai = $row['nilai'];
echo json_encode($nilai);
exit;
?>