
<head>
    <style>
        .gauge {
            width: 450px;
            height: 450px;
        }
    </style>
</head>
<div id="gg1" class="gauge text-align center">

</div>

<form action="" id="nilaiInput">
    <input type="hidden" name="nilai" value="<?php echo $nilai; ?>">
    <input class="btn btn-primary" type="submit" name="submit" value="nilai">
</form>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="./js/raphael-2.1.4.min.js"></script>
<script src="./js/justgage.js"></script>

<script>
var nilaiGauge;

$( document ).ready(function newData() {
    var gg1 = new JustGage({
      id: "gg1",
      value : updateData(),
      min: 0,
      max: 10,
      decimals: 2,
      gaugeWidthScale: 0.6,
      customSectors: [{
        color : "#00ff00",
        lo : 0,
        hi : 5
      },{
        color : "#ff0000",
        lo : 5,
        hi : 7
      },{
        color : "#fc03f0",
        lo : 7,
        hi : 10
      }],
      counter: true
    });

    //update data
    
    function updateData(){
        $.ajax({
            type: "POST",
            url: "../data.php",
            data: "data='data'",
            success: function(no){
                let arr = JSON.parse(no);
               gg1.refresh(arr[22]);
            }
        })
    }
    
        setInterval(function(){
            updateData();
               }, 1000);
});

    


</script>