<?php
session_start();
require "vendor/autoload.php";
$cid=$_SESSION["userid"];
  $con = new MongoDB\Client("mongodb://localhost:27017");
    if($con){
      $db = $con -> IMS;
      $consumer = $db -> consumer;
      $meter = $db -> meter;
      $bill = $db -> bill;
      $regg = $db -> region;

      $qry = ["Consumer_Id" => $cid];
      $conn   = $consumer -> findOne($qry);
      $meterno = $conn['meter_no'];
      
      $qry2 = ["meter_no" => $meterno];
      $mtr   = $meter -> findOne($qry2);
      $status  = $mtr['Status'];
      
      $qry3 = ["region_id" => $conn['region_id']];
      $region   = $regg -> findOne($qry3);

      $ucost = 7 * $mtr['Reading'];
      $regionCut = $ucost * ( $region['Unit_rate'] / 100 );
      $totla = 120 + $ucost + $regionCut;
    }
    else{
      print("DB connection Failed........");
    }

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>DashBoard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.min.css" rel="stylesheet">
    <style type="text/css">

      html,
      body,
      header,
      .carousel {
        height: 60vh;
      }

      @media (max-width: 740px) {
        html,
        body,
        header,
        .carousel {
          height: 100vh;
        }
      }

      @media (min-width: 800px) and (max-width: 850px) {
        html,
        body,
        header,
        .carousel {
          height: 100vh;
        }
      }

      @media (min-width: 800px) and (max-width: 850px) {
              .navbar:not(.top-nav-collapse) {
                  background: #1C2331!important;
              }
          }
          .height {
                  min-height: 200px;
              }
              
              .icon {
                  font-size: 47px;
                  color: #5CB85C;
              }
              
              .iconbig {
                  font-size: 77px;
                  color: #5CB85C;
              }
              
              .table > tbody > tr > .emptyrow {
                  border-top: none;
              }
              
              .table > thead > tr > .emptyrow {
                  border-bottom: none;
              }
              
              .table > tbody > tr > .highrow {
                  border-top: 3px solid;
              }
    </style>
</head>

<body>

<!-- Card MeterUnits-->
<div class="card chart-card">

  <!-- Card content -->
  <div class="card-body pb-0">

    <!-- Title -->
    <h4 class="card-title font-weight-bold"><?php echo $conn['first_name']." ".$conn['last_name']; ?></h4>
    <!-- Text -->
    <p class="card-text mb-4">Meter No: <?php echo (int)$conn["meter_no"]; ?></p> 
    <p class="card-text mb-4">Status: 
      <?php
      if ($mtr['Status'] == 1){echo "Online";} 
      else{echo "Offline";}
     ?></p>
    <div class="d-flex justify-content-between">
      <p class="display-4 align-self-end"><?php echo $mtr['Reading']; ?></p>
      <p class="align-self-end pb-2"></p>
    </div>

  </div>

  <!-- Classic tabs -->
  <div class="classic-tabs">

    <!-- Nav tabs -->
    <ul class="nav tabs-white nav-fill" role="tablist">
      <li class="nav-item ml-0">
        <a class="nav-link waves-light active" data-toggle="tab" href="#panel1001" role="tab">Usage</a>
      </li>
      <li class="nav-item">
        <a class="nav-link waves-light" data-toggle="tab" href="#panel1002" role="tab">Previous Stats</a>
      </li>
      <li class="nav-item">
        <a class="nav-link waves-light" data-toggle="tab" href="#panel1003" role="tab" action="billgen.php">Bill</a>
      </li>
    </ul>

    <div class="tab-content rounded-bottom">
      <!--Panel 1-->
      <div class="tab-pane fade in show active" id="panel1001" role="tabpanel">
        <canvas id="lineChart" height="250px"></canvas>
      </div>
      <!--/.Panel 1-->

      <!--Panel 2-->
      <div class="tab-pane fade" id="panel1002" role="tabpanel">
      
      </div>
      <!--/.Panel 2-->

      <!--Panel 3-->
      <div class="tab-pane fade" id="panel1003" role="tabpanel">
          <div class="container">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="text-center">
                          <h2>Electricity Bill</h2>
                      </div>
                      <hr>
                      <div class="square">
                          <div class="square">
                              <div class="panel panel-default height">
                                  <div class="panel-heading">Billing Details</div>
                                  <div class="panel-body">
                                      <strong><?php echo $conn['first_name']." ".$conn['last_name']; ?></strong><br>
                                      <?php echo $conn['Address']; ?><br>
                                      <br>
                                      <strong><?php echo $conn['Contact_No']; ?></strong><br>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              <h3 class="text-center"><strong>Bill summary</strong></h3>
                          </div>
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table table-condensed">
                                      <thead>
                                          <tr>
                                              <td><strong>Usage type</strong></td>
                                              <td class="text-center"><strong>Price</strong></td>
                                              <td class="text-center"><strong>Quantity</strong></td>
                                              <td class="text-right"><strong>Total</strong></td>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>Minimum Charges</td>
                                              <td class="text-center">120</td>
                                              <td class="text-center">1</td>
                                              <td class="text-right">120</td>
                                          </tr>
                                          <tr>
                                              <td>Units Consumed</td>
                                              <td class="text-center">7</td>
                                              <td class="text-center"><?php echo $mtr['Reading']; ?></td>
                                              <td class="text-right"><?php echo $ucost; ?></td>
                                          </tr>
                                          <tr>
                                              <td>Region Tax</td>
                                              <td class="text-center"><?php echo $region['Unit_rate']; ?></td>
                                              <td class="text-center">1</td>
                                              <td class="text-right"><?php echo $regionCut; ?></td>
                                          </tr>
                                          <tr>
                                              <td class="highrow"></td>
                                              <td class="highrow"></td>
                                              <td class="highrow text-center"><strong>Subtotal</strong></td>
                                              <td class="highrow text-right"><?php echo $totla; ?></td>
                                          </tr>
                                          <tr>
                                              <td class="emptyrow"></i></td>
                                              <td class="emptyrow"></td>
                                              <td class="emptyrow text-center"><strong><?php echo $totla; ?></strong></td>
                                              <td class="emptyrow text-right"></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      
      </div>
      <!--/.Panel 3-->
    </div>

  </div>
  <!-- Classic tabs -->

</div>
<!-- Card MeterUnits-->

    <!-- SCRIPTS -->
    

    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
      <!-- Initializations -->
  <script type="text/javascript">
    // Animations initialization
    new WOW().init();
    var ctxL = document.getElementById("lineChart").getContext('2d');
  var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ["Jan","Feb","Mar","Apr","May","Jun"],
    datasets: [
      {
        fill: false,
        borderColor: "#673ab7",
        pointBackgroundColor: "#673ab7",
        data: [60,70,64,56,78,54]
      }
    ]
  },
  options: {
    responsive: false,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false,
        },
        ticks: {
          padding: 15,
          height: 30
        }
      }],
      yAxes: [{
        gridLines: {
          drawBorder: false
        },
        ticks: {
            maxTicksLimit: 5,
            padding: 15,
            min: 20,
            max: 100
          }
      }]
    }
  }
});
  </script>
</body>

</html>
