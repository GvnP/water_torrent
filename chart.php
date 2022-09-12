<?php
$server 	= 'localhost';
$userNM 	= 'root';
$pass 		= '';
$database 	= 'testing';
$conn = mysqli_connect($server, $userNM, $pass, $database);

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}

//ambil data terakhir dari db
$nilai = 5;
$sql = 'select * from data order BY id DESC';
$run = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($run);

if($row['nilai'] != null){
    $nilai = $row['nilai'];
}

?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.2/dist/chart.min.js"></script>
<div style="max-height:250px;max-width:400px;">
    <canvas id="myChart" width="400" height="250"></canvas>
</div>
<!-- <input type="button" value="Add Data" onclick="adddata()"> -->

<form action="" id="nilaiInput">
    <input type="hidden" name="nilai" value="<?php echo $nilai; ?>">
    <input class="btn btn-primary" type="submit" name="submit" value="nilai">
</form>

<script>
// chart
var canvas = document.getElementById('myChart');
var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "My First dataset",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 5,
            pointHitRadius: 10,
            data: [0,0,0,0,0,0,0],
        }
    ]
};

var option = {
	showLines: true
};
var myLineChart = new Chart(canvas,{
  type: 'line',
	data:data,
  options:option
});


//kirim data ajax
$(function(){
	$("#nilaiInput").on("submit", function(e){
		var dataString = $(this).serialize();
		console.log(dataString);
		
		$.ajax({
			type: "POST",
			url: "chartdata.php",
			data: dataString,
            cache: false,
			success: {
                //do something
            },
		});
	e.preventDefault();
    });
});

function testin(){
    $.ajax({
        type: 'POST',
        url: 'data.php',
        data: 'data="data";',
        success: function(no){
                    let arr = JSON.parse(no);
                    myLineChart.data.datasets[0].data[6] = arr[0];
                    myLineChart.data.datasets[0].data[5] = arr[1];
                    myLineChart.data.datasets[0].data[4] = arr[2];
                    myLineChart.data.datasets[0].data[3] = arr[3];
                    myLineChart.data.datasets[0].data[2] = arr[4];
                    myLineChart.data.datasets[0].data[1] = arr[5];
                    myLineChart.data.datasets[0].data[0] = arr[6];
                    myLineChart.update();
                    //console.log(arr);
                },
    })
}
setInterval(function(){testin();}, 1000);

// function adddata(e){
//     let dataString = generateRandom(e);
//     console.log('nilai='+dataString);
// 	$.ajax({
// 		type: "POST",
// 		url: "chartdata.php",
// 		data: 'nilai='+dataString,
// 		success: function(){
// 			//do something
// 		}
// 	});
// }
</script>
