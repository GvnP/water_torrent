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
    function __construct($volume, $debit)
    {
        $this->connect();
        $this->storeInDB($volume, $debit);
    }

    function connect()
    {
        $this->link = mysqli_connect('localhost', 'root', '') or die('Cannot connect to the DB');
        mysqli_select_db($this->link, 'ethernettest') or die('Cannot select the DB');
    }

    function storeInDB($volume, $debit)
    {
        $query = "insert into air set debit='" . $debit . "', volume='" . $volume . "', arah='masuk'";


        $result = mysqli_query($this->link, $query) or die('Errant query:  ' . $query);
    }
}
if ($_GET['volume'] != '' and  $_GET['debit'] != '') {

    $dht1 = new dht1($_GET['volume'], $_GET['debit']);
}

//Upload 2

class dht2
{
    public $link2 = '';
    function __construct($volume2, $debit2)
    {
        $this->connect();
        $this->storeInDB($volume2, $debit2);
    }

    function connect()
    {
        $this->link2 = mysqli_connect('localhost', 'root', '') or die('Cannot connect to the DB');
        mysqli_select_db($this->link2, 'ethernettest') or die('Cannot select the DB');
    }

    function storeInDB($volume2, $debit2)
    {

        $query2 = "insert into air set debit='" . $debit2 . "', volume='" . $volume2 . "', arah='keluar'";
        $result2 = mysqli_query($this->link2, $query2) or die('Errant query:  ' . $query2);
    }
}
if ($_GET['volume2'] != '' and $_GET['debit2'] != '') {

    $dht2 = new dht2($_GET['volume2'], $_GET['debit2']);
}


//mengambil data debit dan volume dari database untuk sensor air masuk ke tandon
$hitung = mysqli_query($koneksitest, "SELECT * FROM air");


$VolHariNow = mysqli_query($koneksitest, "SELECT * from harian where hari = '$Today' ");
$VolMasukNow = mysqli_query($koneksitest, "SELECT volume from air where arah=masuk order by 'date' DESC limit 1");

$fetchharinow = mysqli_fetch_assoc($VolHariNow);
$fetchmasuknow = mysqli_fetch_assoc($VolMasukNow);


$hariini = array();
$masuknow = array();

array_push($hariini, $fetchharinow['volume']);
array_push($masuknow, $fetchmasuknow['volume']);


//mengambil data debit dan volume dari database untuk sensor air keluar ke tandon
$hitungout = mysqli_query($koneksitest, "SELECT * FROM air");

$VolOutToday = mysqli_query($koneksitest, "SELECT * from harian2 where hari = '$Today' ");
$VolKeluarNow = mysqli_query($koneksitest, "SELECT volume from air where arah=keluar order by 'date' DESC limit 1");

$FetchOutToday = mysqli_fetch_assoc($VolOutToday);
$FetchKeluarNow = mysqli_fetch_assoc($VolKeluarNow);


$OutToday = array();
$OutNow = array();

array_push($OutToday, $FetchOutToday['volume']);
array_push($OutNow, $FetchKeluarNow['volume']);


$i = 0;
$a = 0;
while (mysqli_fetch_assoc($hitung)) {
    $i++;
}
while (mysqli_fetch_assoc($hitungout)) {
    $a++;
}

if ($i >= 13) {
    mysqli_query($koneksitest, "DELETE from air where arah=masuk order by 'date' asc limit 1");
}
if ($a >= 13) {
    mysqli_query($koneksitest, "DELETE from air where arah=keluar order by 'date' asc limit 1");
}

// Jika sudah jam 5 maka monitoring akan direset
date_default_timezone_set("Asia/Bangkok");
$Jam = date("H");

if ($Jam == 17) {
    mysqli_query($koneksitest, "TRUNCATE TABLE air");
}

//Ketika mati lampu / direset pertama kali dan data volume di arduino reset ke 0 maka tunggu sampai sama sebelum akhirnya ditambah

// Air keluar Tandon dan dikonsumsi (BETULIN !!!)

if (($OutNow[0] > $OutToday[0])) {
    $sekarang2 = $OutNow[0] + $OutToday[0];
    mysqli_query($koneksitest, "UPDATE harian2 SET volume = '$sekarang' WHERE hari = '$Today' ");
    $SetOut = 1;  //Penambahan ini hanya dilakukan sekali agar tidak terjadi error pada data
}

if (($OutNow[0] > $OutToday[0]) && ($SetOut = 1)) {
    mysqli_query($koneksitest, "UPDATE harian2 SET volume = '$sekarang' WHERE hari = '$Today' ");
}
//jika ada mati lampu ditengah - tengah dan angka belum melewati volume tersimpan, saat jam 4 nilai sisa ditambahkan
if (($OutNow[0] < $OutToday[0]) && ($Jam = 16)) {
    $sisa = $OutNow[0] + $OutToday[0];
    $SetOut = 1;
}

//Air masuk Tandon
if (($masuknow[0] > $hariini[0])) {
    $sekarang = $masuknow[0] + $hariini[0];
    mysqli_query($koneksitest, "UPDATE harian SET volume = '$sekarang' WHERE hari = '$Today' ");
    $set = 1;
}

if (($masuknow[0] > $hariini[0]) && ($set = 1)) {
    mysqli_query($koneksitest, "UPDATE harian SET volume = '$sekarang' WHERE hari = '$Today' ");
}
//jika ada mati lampu ditengah - tengah dan angka belum melewati volume tersimpan, saat jam 4 nilai sisa ditambahkan
if (($masuknow[0] < $hariini[0]) && ($Jam = 16)) {
    $sisa = $hariini[0] + $masuknow[0];
    $set = 1;
}
