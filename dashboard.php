<?php
session_start();
require "vendor/autoload.php";
$month = date('m');
if(isset($_SESSION["userid"])){
$mread;
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

      switch ($month) {
        case 1:
           $mread=$mtr['JAN'];
           $label=["Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan"];
           $data=[$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN']];
          break;
          case 2:
           $mread=$mtr['FEB'];
           $label=["Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb"];
           $data=[$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB']];
          break;
          case 3:
           $mread=$mtr['MAR'];
           $label=["Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar"];
           $data=[$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR']];
          break;
          case 4:
           $mread=$mtr['APR'];
           $label=["May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr"];
           $data= [$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR']];
          break;
          case 5:
           $mread=$mtr['MAY'];
           $label=["Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr","May"];
           $data=[$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY']];
          break;
          case 6:
           $mread=$mtr['JUN'];
           $label=["Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr","May","Jun"];
           $data=[$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN']];
          break;
          case 7:
           $mread=$mtr['JUL'];
           $label=["Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr","May","Jun","Jul"];
           $data=[$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL']];
          break;
          case 8:
           $mread=$mtr['AUG'];
           $label=["Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug"];
           $data=[$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG']];
          break;
          case 9:
           $mread=$mtr['SEP'];
           $label=["Oct","Nov","Dec","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep"];
           $data=[$mtr['OCT'],$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP']];
          break;
          case 10:
           $mread=$mtr['OCT'];
           $label=["Nov","Dec","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct"];
           $data=[$mtr['NOV'],$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT']];
          break;
          case 11:
           $mread=$mtr['NOV'];
           $label=["Dec","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov"];
           $data=[$mtr['DEC'],$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV']];
          break;
          case 12:
           $mread=$mtr['DEC'];
           $label=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
           $data=[$mtr['JAN'],$mtr['FEB'],$mtr['MAR'],$mtr['APR'],$mtr['MAY'],$mtr['JUN'],$mtr['JUL'],$mtr['AUG'],$mtr['SEP'],$mtr['OCT'],$mtr['NOV'],$mtr['DEC']];
          break;
        
        default:
         
          break;
      }
    
      $ucost = 7 * $mread;
      $regionCut = $ucost * ( $region['Unit_rate'] / 100 );
      $totla = 120 + $ucost + $regionCut;
    }
    else{
      print("DB connection Failed........");
    }
  }
  else{
    header('Refresh: 0; URL = index.php');
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
    <link href="css/button.css" rel="stylesheet">
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

<body style="background: url('C:\xampp\htdocs\akio\ims_gui\img\cityline.gif');background-repeat: no-repeat;background-size: 100% 100%;">

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
      <p class="display-4 align-self-end"><?php echo $mread; ?></p>
      <p class="align-self-end pb-2"></p>
    </div>
      <form action="logout.php">
				<button class="button blue" style="text-align:center;position: fixed; top: 10; right: 10;" type="submit">
					&nbsp;&nbsp;<b>Log Out</b>&nbsp;&nbsp;
        </button>
      </form>
    </div>
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
        <canvas id="lineChart" height="600px" width="600px"></canvas>
      </div>
      <!--/.Panel 1-->

      <!--Panel 2-->
      <div class="tab-pane fade" id="panel1002" role="tabpanel">
        <div class="table-responsive">
          <table class="table table-condensed">
            <thead>
              <tr>
                 <td><strong>Month</strong></td>
                 <td class="text-center"><strong>Units Consumed</strong></td>
                 <td class="text-center"><strong>Bill Amount</strong></td>
              </tr>
            </thead>
            <tbody>
            <tr>
              <td>January</td>
              <td class="text-center"><?php echo $mtr['JAN']?></td>
              <td class="text-center"><?php echo (7*$mtr['JAN'])+(7*$mtr['JAN'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>February</td>
              <td class="text-center"><?php echo $mtr['FEB']?></td>
              <td class="text-center"><?php echo (7*$mtr['FEB'])+(7*$mtr['FEB'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>March</td>
              <td class="text-center"><?php echo $mtr['MAR']?></td>
              <td class="text-center"><?php echo (7*$mtr['MAR'])+(7*$mtr['MAR'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>April</td>
              <td class="text-center"><?php echo $mtr['APR']?></td>
              <td class="text-center"><?php echo (7*$mtr['APR'])+(7*$mtr['APR'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>May</td>
              <td class="text-center"><?php echo $mtr['MAY']?></td>
              <td class="text-center"><?php echo (7*$mtr['MAY'])+(7*$mtr['MAY'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>June</td>
              <td class="text-center"><?php echo $mtr['JUN']?></td>
              <td class="text-center"><?php echo (7*$mtr['JUN'])+(7*$mtr['JUN'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>July</td>
              <td class="text-center"><?php echo $mtr['JUL']?></td>
              <td class="text-center"><?php echo (7*$mtr['JUL'])+(7*$mtr['JUL'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>August</td>
              <td class="text-center"><?php echo $mtr['AUG']?></td>
              <td class="text-center"><?php echo (7*$mtr['AUG'])+(7*$mtr['AUG'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>September</td>
              <td class="text-center"><?php echo $mtr['SEP']?></td>
              <td class="text-center"><?php echo (7*$mtr['SEP'])+(7*$mtr['SEP'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>October</td>
              <td class="text-center"><?php echo $mtr['OCT']?></td>
              <td class="text-center"><?php echo (7*$mtr['OCT'])+(7*$mtr['OCT'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>November</td>
              <td class="text-center"><?php echo $mtr['NOV']?></td>
              <td class="text-center"><?php echo (7*$mtr['NOV'])+(7*$mtr['NOV'])*( $region['Unit_rate'] / 100 )+120 ?></td>
            </tr>
            <tr>
              <td>December</td>
              <td class="text-center"><?php echo $mtr['DEC']?></td>
              <td class="text-center"><?php echo ((7*$mtr['DEC'])+(7*$mtr['DEC'])*( $region['Unit_rate'] / 100 )+120) ?></td>
            </tr>
        </table>
        </div>
      </div>
      <!--/.Panel 2-->

      <!--Panel 3-->
      <div class="tab-pane fade" id="panel1003" role="tabpanel">
        <div>
          <div class="container"  id="bill">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="text-center">
                          <h2>Electricity Bill</h2>
                      </div>
                      <hr>
                      <div class="square">
                          <div class="square">
                              <div class="panel panel-default height">
                                  <div class="panel-heading">Billing Details:<br></div>
                                  <div class="panel-body">
                                      <strong><?php echo $conn['first_name']." ".$conn['last_name']; ?></strong><br>
                                      <?php echo $conn['Address']; ?><br>
                                      Contact Number:</strong>
                                      <?php echo $conn['Contact_No']; ?><br>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xs-12">
                  <div style="position:absolute;
                              left: 75%;
                              width:30em;
                              height:20em;">
                          <br><h3>From: 1-<?php echo date('m-y')?></h3>
                          <br><h3>To: &nbsp;&nbsp;<?php echo date('t',strtotime(date('m-y')))?>-<?php echo date('m-y')?></h3>
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
                                              <td class="text-center"><?php echo $mread; ?></td>
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
          <div class="container-center" style="text-align:center;">
          <br>
						<button class="button blue" id="cmd" style="text-align:center;">
							&nbsp;&nbsp;<b>Download Bill</b>&nbsp;&nbsp;
            </button>
          <br>
          <br>
					</div>
      </div>
      <!--/.Panel 3-->
      
    </div>

  </div>
  <!-- Classic tabs -->

</div>
<!-- Card MeterUnits-->

    <!-- SCRIPTS -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type='text/javascript' src="js/jspdf.debug.js"></script>
<script>
$(document).ready(function() {
$('#cmd').click(function () {
var pdf = new jsPDF('p', 'pt', 'letter')
, source = $('#panel1003')[0]

}

margins = {
    top: 60,
    bottom: 60,
    left: 40,
    width: 522
  };
  // all coords and widths are in jsPDF instance's declared units
  // 'inches' in this case
pdf.fromHTML(
    source // HTML string or DOM elem ref.
    , margins.left // x coord
    , margins.top // y coord
    , {
        'width': margins.width // max width of content on PDF
        , 'elementHandlers': specialElementHandlers
    },
    function (dispose) {
      // dispose: object with X, Y of the last line add to the PDF
      //          this allow the insertion of new lines after html
        pdf.save('Downloaded.pdf');
      },
    margins
  )
});

    });
</script>
    

    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/pdf.js"></script>
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
    labels: <?php echo json_encode($label); ?>,
    datasets: [
      {
        fill: false,
        borderColor: "#673ab7",
        pointBackgroundColor: "#673ab7",
        data: <?php echo json_encode($data); ?>
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
          padding: 20,
          height: 120
        }
      }],
      yAxes: [{
        gridLines: {
          drawBorder: false
        },
        ticks: {
            maxTicksLimit: 20,
            padding: 15,
            min:120,
            max: 500
          }
      }]
    }
  }
});
  </script>
</body>
</html>