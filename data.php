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

$sql = 'SELECT * from air where arah = "masuk" order by "date" desc limit 13';
$run = mysqli_query($conn, $sql);
$data = array();
$i = 0;

while ($row = mysqli_fetch_assoc($run)) {
    $data[$i] = $row['debit'];
    $i++;
    $data[$i] = $row['date'];
    $i++;
}

echo json_encode($data);
exit;
