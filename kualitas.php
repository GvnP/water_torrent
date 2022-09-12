<?php
include './_database/config.php';
setlocale(LC_ALL, 'id-ID');
$Today =  strftime("%A");
$IdToday = strftime("%N");


//upload monitoring debit ke database
//Upload 1
class dht1
{
    public $link = '';
    function __construct($tds, $tss, $ph)
    {
        $this->connect();
        $this->storeInDB($tds, $tss, $ph);
    }

    function connect()
    {
        $this->link = mysqli_connect('localhost', 'root', '') or die('Cannot connect to the DB');
        mysqli_select_db($this->link, 'ethernettest') or die('Cannot select the DB');
    }

    function storeInDB($tds, $tss, $ph)
    {
        $query = "insert into kualitas set tds='" . $tds . "', tss='" . $tss . "', ph='".$ph."'";
        $result = mysqli_query($this->link, $query) or die('Errant query:  ' . $query);
        
    }
}
if ($_GET['tds'] != '' and  $_GET['tss'] != '' and $_GET['ph']) {

    $dht1 = new dht1($_GET['tds'], $_GET['tss'], $_GET['ph']);
}




//mengambil data debit dan volume dari database untuk sensor air masuk ke tandon
$hitung = mysqli_query($koneksitest, "SELECT * FROM kualitas");

$a = 0;
while (mysqli_fetch_assoc($hitung)) {
    $a++;
}

if ($a >= 13) {
    mysqli_query($koneksitest, "DELETE from kualitas order by 'date' asc limit 1");
}

// Jika sudah jam 5 maka monitoring akan direset
date_default_timezone_set("Asia/Bangkok");
$Jam = date("H");

if ($Jam == 17) {
    mysqli_query($koneksitest, "TRUNCATE TABLE test1");
    mysqli_query($koneksitest, "TRUNCATE TABLE keluar");
}

