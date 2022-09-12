<?php

$server     = 'localhost';
$userNM     = 'root';
$pass         = '';
$database     = 'ethernettest';
$conn = mysqli_connect($server, $userNM, $pass, $database);

if (mysqli_connect_errno()) {
    echo "DATABASE ERROR : " . mysqli_connect_error();
}

setlocale(LC_ALL, 'id-ID');
$Today =  strftime("%A");


$barsql = "SELECT * from harian2 order by 'id'";
$go = mysqli_query($conn, $barsql);
$vol = array();
$i = 0;

while ($bar = mysqli_fetch_assoc($go)){
array_push($data, $bar['volume']);
}
echo json_encode($data);
exit;
