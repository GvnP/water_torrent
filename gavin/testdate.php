<script>

function getDayName(dateStr, locale)
{
    var date = new Date(dateStr);
    return date.toLocaleDateString(locale, { weekday: 'long' });        
}

var dateStr = new Date();
var day = getDayName(dateStr, "id-ID");

console.log(day);

</script>

<?php 

setlocale(LC_ALL, 'id-ID');

$datetime = DateTime::createFromFormat('YmdHi', '201308161830');




$a =  strftime("%A %e %B %Y", );
echo $a;


?>