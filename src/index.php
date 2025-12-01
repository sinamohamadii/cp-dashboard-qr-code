<?php
//Use httponly flag
ini_set('session.cookie_httponly', 1);

//Use only cookies
ini_set('session.use_only_cookies', 1);

//Use secure flag
ini_set('session.cookie_secure', 1);

session_start();

// Payload Authentication Guard
require_once './includes/payload_guard.php';

$db = getDbInstance();

//Get Dynamic qr code rows
$numQrcode_dynamic = $db->getValue("dynamic_qrcodes", "count(*)");

//Get Static qr code rows
$numQrcode_static = $db->getValue("static_qrcodes", "count(*)");

$total = $numQrcode_dynamic + $numQrcode_static;

//Get Total scan
$numScan = $db->getOne("dynamic_qrcodes", "sum(scan) as numScan");

                                                /* CREATED CHART */
//I initialize the variables that will contain the daily values to 0 otherwise in the foreach loop they will be reset every time

//Get the number of DYNAMIC qr code created in 7 days and total scan
$createdQrcode_dynamic = $db->query("select `created_at`, `scan` from ".DATABASE_PREFIX."dynamic_qrcodes where `created_at` > curdate()-7;");


$dynamic_today = $dynamic_oneday = $dynamic_twoday = $dynamic_threeday = $dynamic_fourday = $dynamic_fiveday = $dynamic_sixday  = 0;
$scan_today = $scan_oneday = $scan_twoday = $scan_threeday = $scan_fourday = $scan_fiveday = $scan_sixday = 0;
foreach ($createdQrcode_dynamic as $row) {
    switch (substr($row['created_at'],0,10)){
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d'),date('Y'))): $dynamic_today++; $scan_today = $scan_today + $row['scan']; break; 
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-1,date('Y'))): $dynamic_oneday++; $scan_oneday = $scan_oneday + $row['scan']; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-2,date('Y'))): $dynamic_twoday++; $scan_twoday = $scan_twoday + $row['scan']; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-3,date('Y'))): $dynamic_threeday++; $scan_threeday = $scan_threeday + $row['scan']; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-4,date('Y'))): $dynamic_fourday++; $scan_fourday = $scan_fourday + $row['scan']; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-5,date('Y'))): $dynamic_fiveday++; $scan_fiveday = $scan_fiveday + $row['scan']; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-6,date('Y'))): $dynamic_sixday++; $scan_sixday = $scan_sixday + $row['scan']; break;
        //I increase the daily variable and update the variable of the number of scans for a given day
    }
}

                                                /* SCAN CHART */
//Get the number of STATIC qr code created in 7 days
$createdQrcode_static = $db->query("select `created_at` from ".DATABASE_PREFIX."static_qrcodes where `created_at` > curdate()-7;");

$static_today = $static_oneday = $static_twoday = $static_threeday = $static_fourday = $static_fiveday = $static_sixday = 0;
foreach ($createdQrcode_static as $row) {
    switch (substr($row['created_at'],0,10)){
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d'),date('Y'))): $static_today++; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-1,date('Y'))): $static_oneday++; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-2,date('Y'))): $static_twoday++; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-3,date('Y'))): $static_threeday++; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-4,date('Y'))): $static_fourday++; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-5,date('Y'))): $static_fiveday++; break;
        case date("Y-m-d",mktime(0,0,0,date('m'),date('d')-6,date('Y'))): $static_sixday++; break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <title>Qr Code Generator</title>
    <head>
    <?php include './includes/head.php'; ?>
    </head>
    
    <body class="caesar-layout">
        <!-- Caesar Sidebar -->
        <?php include './includes/sidebar.php'; ?>
        
        <div class="wrapper">
            <!-- Caesar Header -->
            <?php include './includes/navbar.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Dashboard</h1>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div><!-- /.content-header -->
                
                <!-- Flash message-->
                <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
                <!-- /.Flash message-->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->
                            <div class="row">
                                
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="stat-card mb-3">
                                        <div class="stat-card-header">
                                            <span class="stat-card-title">Total QR Codes</span>
                                            <span class="stat-card-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="14" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="18" y="14" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="18" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="18" y="18" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="stat-card-value"><?php echo $total; ?></p>
                                    </div>
                                </div><!-- /.col -->
                                    
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="stat-card mb-3">
                                        <div class="stat-card-header">
                                            <span class="stat-card-title">Dynamic QR Codes</span>
                                            <span class="stat-card-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="14" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="18" y="14" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="18" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="18" y="18" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="stat-card-value"><?php echo $numQrcode_dynamic; ?></p>
                                    </div>
                                </div><!-- /.col -->

                                <!-- fix for small devices only -->
                                <div class="clearfix hidden-md-up"></div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="stat-card mb-3">
                                        <div class="stat-card-header">
                                            <span class="stat-card-title">Static QR Codes</span>
                                            <span class="stat-card-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="14" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="18" y="14" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="14" y="18" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                    <rect x="18" y="18" width="3" height="3" stroke="currentColor" stroke-width="1.5"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="stat-card-value"><?php echo $numQrcode_static; ?></p>
                                    </div>
                                </div><!-- /.col -->
                                
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="stat-card mb-3">
                                        <div class="stat-card-header">
                                            <span class="stat-card-title">Total Scans</span>
                                            <span class="stat-card-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 17L9 11L13 15L21 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M17 7H21V11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="stat-card-value"><?php echo $numScan["numScan"]; ?></p>
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->

                        <div class="row">
                                
                            <div class="col-md-6">
                                <!-- Created chart -->
                                <div class="chart-card mb-3">
                                    <div class="chart-card-header">
                                        <div class="chart-card-icon yellow">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 3V21H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M7 14L12 9L16 13L21 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <span class="chart-card-title">QR codes created in the last week</span>
                                    </div>
                                    <div class="chart-card-stats">
                                        <p class="chart-card-value"><?php echo $dynamic_today + $dynamic_oneday + $dynamic_twoday + $dynamic_threeday + $dynamic_fourday + $dynamic_fiveday + $dynamic_sixday + $static_today + $static_oneday + $static_twoday + $static_threeday + $static_fourday + $static_fiveday + $static_sixday?></p>
                                    </div>
                                    <div class="chart-card-body">
                                        <canvas id="created-chart"></canvas>
                                    </div>
                                </div><!-- /.chart-card -->
                            </div><!-- /.col (LEFT) -->

                            <div class="col-md-6">
                                <!-- Scan chart -->
                                <div class="chart-card mb-3">
                                    <div class="chart-card-header">
                                        <div class="chart-card-icon yellow">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                                                <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                                                <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                                                <rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                        </div>
                                        <span class="chart-card-title">Scan Graph</span>
                                    </div>
                                    <div class="chart-card-stats">
                                        <p class="chart-card-value"><?php echo $numScan["numScan"]; ?></p>
                                    </div>
                                    <div class="chart-card-body">
                                        <canvas id="scan-chart"></canvas>
                                    </div>
                                </div><!-- /.chart-card -->
                            </div><!-- /.col (RIGHT) -->
                        </div><!-- /.row -->
                        
                    </div><!--/. container-fluid -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
        

        <!-- Footer and scripts -->
        <?php include './includes/footer.php'; ?>
        <!-- ChartJS -->
        <script src="<?php echo asset_url('plugins/chart.js/Chart.min.js'); ?>"></script>
        <!-- Created Qr code Chart script -->
        <script>
        $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#98989A',
    fontStyle: 'normal',
    fontSize: 11
  }

  var mode      = 'index'
  var intersect = true

  var $createdChart = $('#created-chart')
  var createdChart  = new Chart($createdChart, {
    data   : {
      labels  : [   
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-6,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-5,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-4,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-3,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-2,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-1,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d'),date('Y'))); ?>'
                ],
      datasets: [{
        type                : 'line',
        data                : [
                                <?php echo $dynamic_sixday ?>, 
                                <?php echo $dynamic_fiveday ?>, 
                                <?php echo $dynamic_fourday ?>,
                                <?php echo $dynamic_threeday ?>,
                                <?php echo $dynamic_twoday ?>,
                                <?php echo $dynamic_oneday ?>,
                                <?php echo $dynamic_today ?>,

                            ],
        backgroundColor     : 'transparent',
        borderColor         : '#F7CC40',
        pointBorderColor    : '#F7CC40',
        pointBackgroundColor: '#F7CC40',
        pointRadius         : 4,
        pointHoverRadius    : 6,
        borderWidth         : 2,
        lineTension         : 0.4,
        fill                : false
      },
        {
          type                : 'line',
          data                : [
                                <?php echo $static_sixday ?>, 
                                <?php echo $static_fiveday ?>, 
                                <?php echo $static_fourday ?>,
                                <?php echo $static_threeday ?>,
                                <?php echo $static_twoday ?>,
                                <?php echo $static_oneday ?>,
                                <?php echo $static_today ?>,

                            ],
          backgroundColor     : 'transparent',
          borderColor         : '#E6E6E6',
          pointBorderColor    : '#E6E6E6',
          pointBackgroundColor: '#E6E6E6',
          pointRadius         : 4,
          pointHoverRadius    : 6,
          borderWidth         : 2,
          lineTension         : 0.4,
          fill                : false
        }]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          gridLines: {
            display      : true,
            lineWidth    : 1,
            color        : '#E6E6E6',
            zeroLineColor: '#E6E6E6',
            drawBorder   : false
          },
          ticks    : $.extend({
            beginAtZero : true,
            suggestedMax: 10,
            padding: 10
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks    : $.extend({
            padding: 10
          }, ticksStyle)
        }]
      }
    }
  })
})
        </script>
        <!-- /.Created Chart script -->
        <!-- Scan Chart -->
        <script>
$(function () {
  'use strict'
  
  var ticksStyle = {
    fontColor: '#98989A',
    fontStyle: 'normal',
    fontSize: 11
  }

  var scanChartCanvas = $('#scan-chart').get(0).getContext('2d');

  var scanChartData = {
    labels  : [   
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-6,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-5,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-4,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-3,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-2,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d')-1,date('Y'))); ?>', 
                    '<?php echo date("m/d",mktime(0,0,0,date('m'),date('d'),date('Y'))); ?>'
                ],
    datasets: [
      {
        label               : 'Scan',
        fill                : false,
        borderWidth         : 2,
        lineTension         : 0.4,
        spanGaps            : true,
        borderColor         : '#F7CC40',
        pointRadius         : 4,
        pointHoverRadius    : 6,
        pointBorderColor    : '#F7CC40',
        pointBackgroundColor: '#F7CC40',
        data                : [
                                <?php echo $scan_sixday ?>, 
                                <?php echo $scan_fiveday ?>, 
                                <?php echo $scan_fourday ?>,
                                <?php echo $scan_threeday ?>,
                                <?php echo $scan_twoday ?>,
                                <?php echo $scan_oneday ?>,
                                <?php echo $scan_today ?>,
                            ],
      }
    ]
  }

  var scanChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false,
    },
    scales: {
      xAxes: [{
        ticks : $.extend({
          padding: 10
        }, ticksStyle),
        gridLines : {
          display : false,
          drawBorder: false,
        }
      }],
      yAxes: [{
        ticks : $.extend({
          beginAtZero: true,
          suggestedMax: 30,
          padding: 10
        }, ticksStyle),
        gridLines : {
          display : true,
          color: '#E6E6E6',
          zeroLineColor: '#E6E6E6',
          drawBorder: false,
          lineWidth: 1
        }
      }]
    }
  }

  var scanChart = new Chart(scanChartCanvas, { 
      type: 'line', 
      data: scanChartData, 
      options: scanChartOptions
    }
  )
})
        </script>
        <!-- /. Scan Chart -->
        <!-- /.Footer and scripts -->
    </body>
</html>
