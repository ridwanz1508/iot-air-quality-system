<?php 
    //koneksi ke database
    $konek = mysqli_connect("localhost", "root", "", "iot-air-quality-db");

    $sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM `tb-dataarea`");
    $data_ID = mysqli_fetch_array($sql_ID);
    $ID_Akhir = $data_ID ['MAX(ID)'];
    $ID_Awal = $ID_Akhir-10;

    //Membaca data (sumbu x)
    $tanggal = mysqli_query($konek, "SELECT tanggal FROM `tb-dataarea` WHERE ID >= '$ID_Awal' 
    and ID <= '$ID_Akhir' ORDER BY ID ASC ");
    //membaca data (sumbu y)
    $PM10 = mysqli_query($konek, "SELECT PM10 FROM `tb-dataarea` WHERE ID >= '$ID_Awal' 
    and ID <= '$ID_Akhir'ORDER BY ID ASC ");
?>

<!-- Card Header -->
<div class="card-header bg-dark shadow py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-light">Grafik Monitoring</h6>
</div>
<!-- Card Body -->
<div class="card-body shadow mb-4">
    <div class="chart-area col-xl-12 col-lg-11">
        <canvas id="MyAreaChart2" ></canvas>

        <!---Gambar AreaChart atau Grafik-->
        <script type="text/javascript">
            var canvas = document.getElementById('MyAreaChart2');
            var data = {
                labels: [ //x coordinat graph
                  <?php 
                      while($data_tanggal = mysqli_fetch_array($tanggal)) {
                        echo '"'.$data_tanggal['tanggal'].'",' ; 
                      }
                  ?>
                ],
                datasets: [ { //y coordinat graph
                          label : 'PM10', 
                          fill : true,
                          backgroundColor : "rgba(34, 139, 34, 0.4)",
                          borderColor: "rgba(34, 139, 34, 0.5)",
                          borderWidth: 2,
                          lineTension: 0.5,
                          pointRadius: 2,
                          data : [
                              <?php
                                while($data_PM10 = mysqli_fetch_array($PM10)) {
                                  echo $data_PM10['PM10'].',' ;
                                }
                              ?>
                          ] },
                 ]
            };
          //option graph
          var option = {
            ShowLines : true,
            animation : {duration : 0}
          };

          //printing graph to canvas
          var myLineChart = Chart.Line(canvas, {
            data : data,
            options : option
          });

        </script>

    </div>
</div>


