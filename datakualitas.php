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

$sql = "SELECT * from kualitas ORDER BY `kualitas`.`date` DESC limit 1";
$run = mysqli_query($conn, $sql);
$data = array();

$i = 0;
while ($row = mysqli_fetch_assoc($run)) {
 
    $data[$i] = $row['tds'];
    $i++;
    $data[$i] = $row['tss'];
    $i++;
    $data[$i] = $row['ph'];
    $i++;
}

echo json_encode($data);
exit;
