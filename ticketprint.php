<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: login.php",  true,  301 );  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Print Ticket | <?=$_SESSION['username']?></title>


    <!-- CSS for printing -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" media="print">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="print">
    <link href="../vendors/normalize-css/normalize.css" rel="stylesheet" media="print">
    <link href="../vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet" media="print">
    <link href="../vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" media="print">
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet" media="print">
    <link href="../vendors/cropper/dist/cropper.min.css" rel="stylesheet" media="print">
    <link href="../build/css/print.css" rel="stylesheet" media="print">

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ion.RangeSlider -->
    <link href="../vendors/normalize-css/normalize.css" rel="stylesheet">
    <link href="../vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
    <link href="../vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <link href="../vendors/cropper/dist/cropper.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="javascript:void(0)" class="site_title"><i class="fa fa-user"></i> <span>User Panel</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $_SESSION['username'];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
                  <li class="active"><a href="javascript:void(0)"><i class="fa fa-check-square-o"></i> Place Bets </a></li>
                  <li><a href="user_ticketcancel.php"><i class="fa fa-eraser"></i> Cancel Tickets </a></li>
                  <li><a href="user_betpay.php"><i class="fa fa-credit-card"></i> Pay Bets </a></li>
                  <li><a href="user_resultreport.php"><i class="fa fa-pencil-square-o"></i> Results Report </a></li>
                  <li><a href="user_betreport.php"><i class="fa fa-list-alt"></i> Bet Report </a></li>
				  <li><a href="user_betsummary.php"><i class="fa fa-list-alt"></i> Bet Summary </a></li>
                  <br/>
                  <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout </a></li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt=""><?php echo $_SESSION['username'];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Logout</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              <h3>Ticket Preview</h3>
              </div>
            </div>
            <?php
              if (!$_POST || !$_POST['data']){
                echo "<h4>Invalid ticket id.</h4>";
                die;
              }
              $ticket_id = $_POST['data'];
              include("connect.php");
              // connect to the database
              $con = mysqli_connect($server,$user,$pass,$dbname);
              // Check connection
              if (mysqli_connect_errno())
              {
              echo "Failed to connect : " . mysqli_connect_error();
              }
              // Query
              $query = "SELECT * FROM Tickets WHERE TicketID = $ticket_id AND User = '".$_SESSION['username']."'";
              $ticket_query_result = mysqli_query($con,$query);
              $rows = mysqli_fetch_all($ticket_query_result, MYSQLI_ASSOC);
              if (count($rows) > 1){
                echo "<h4>There's two tickets for same id.</h4>";
                die;
              }
              $ticket_row = $rows[0];
            ?>
            <div class="clearfix"></div>
            <div>
              <div class="row">
                <div class="x_panel custom-panel">
                  <div class="x_content">
                    <br />
                    <div class="col-md-6 col-xs-12">
                      <div id="ticket-preview-div" style="width: 192px;">
                        <div class="row div-center">
                            <div><b style="font-size: 30px;">Virtual Cockfighting</b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 col-xs-12 div-center">
                            <div><b><?=$ticket_row['Location']?></b></div>
                          </div>
                          <div class="col-md-12 col-xs-12 div-center">
                            <div><b>Ticket ID: <?=$ticket_id?></b></div>
                          </div>
                          <div class="col-md-12 col-xs-12 div-center">
                            <div><b>Date: <?=$ticket_row['TimeDate']?></b></div>
                          </div>
                        </div>
                        <hr class="bet-separator"/>
                        <div class="row">
                          <div class="col-md-12 col-xs-12">
                            <?php
                            $bet_id_list = array();
                            if ($ticket_row['BetID1'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID1']);
                            }
                            if ($ticket_row['BetID2'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID2']);
                            }
                            if ($ticket_row['BetID3'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID3']);
                            }
                            if ($ticket_row['BetID4'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID4']);
                            }
                            if ($ticket_row['BetID5'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID5']);
                            }
                            if ($ticket_row['BetID6'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID6']);
                            }
                            if ($ticket_row['BetID7'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID7']);
                            }
                            if ($ticket_row['BetID8'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID8']);
                            }
                            if ($ticket_row['BetID9'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID9']);
                            }
                            if ($ticket_row['BetID10'] != 0){
                              array_push($bet_id_list, $ticket_row['BetID10']);
                            }
                            foreach ($bet_id_list as $bet_id){
                              $query = "SELECT * FROM `Bets` WHERE `BetID`='$bet_id'";
                              $result = mysqli_query($con, $query);
                              if ($result){
                                $row = mysqli_fetch_assoc($result);
                                if ($row){
                                  $bet_type = 'Single';
                                  if ($row['BetType'] != 'Single'){
                                    $bet_type = 'Parlay';
                                  }
                                  ?>
                                  <div class="row">
                                    <div class="col-md-8 col-xs-8">
                                      <div>
                                        <b>Bet ID: <?=$bet_id?></b>
                                      </div>
                                      <div>
                                        <b>Bet Type: <?=$bet_type?></b>
                                      </div>
                                    </div>
                                  </div>
                                  <hr class="bet-section-separator"/>
                                  <div class="row">
                                    <div class="col-md-2 col-xs-2 div-center">
                                    </div>
                                    <div class="col-md-2 col-xs-2 div-center">
                                      <b>Fight</b>
                                    </div>
                                    <div class="col-md-2 col-xs-2 div-center">
                                      <b>Event</b>
                                    </div>
                                    <div class="col-m3-4 col-xs-4 div-center">
                                      <b>Opponent</b>
                                    </div>
                                    <div class="col-md-2 col-xs-2 div-center">
									  <b>Odds</b>
                                    </div>
                                  </div>
                                  <?php
                                    $event_list = array();
                                    if ($row['Pick1'] && $row['Event1']){
                                      array_push($event_list, ['pick' => $row['Pick1'], 'odds' => $row['Odds1'], 'event' => $row['Event1']]);
                                    }
                                    if ($row['Pick2'] && $row['Event2']){
                                      array_push($event_list, ['pick' => $row['Pick2'], 'odds' => $row['Odds2'], 'event' => $row['Event2']]);
                                    }
                                    if ($row['Pick3'] && $row['Event3']){
                                      array_push($event_list, ['pick' => $row['Pick3'], 'odds' => $row['Odds3'], 'event' => $row['Event3']]);
                                    }
                                    if ($row['Pick4'] && $row['Event4']){
                                      array_push($event_list, ['pick' => $row['Pick4'], 'odds' => $row['Odds4'], 'event' => $row['Event4']]);
                                    }
                                    if ($row['Pick5'] && $row['Event5']){
                                      array_push($event_list, ['pick' => $row['Pick5'], 'odds' => $row['Odds5'], 'event' => $row['Event5']]);
                                    }
                                    if ($row['Pick6'] && $row['Event6']){
                                      array_push($event_list, ['pick' => $row['Pick6'], 'odds' => $row['Odds6'], 'event' => $row['Event6']]);
                                    }
                                    if ($row['Pick7'] && $row['Event7']){
                                      array_push($event_list, ['pick' => $row['Pick7'], 'odds' => $row['Odds7'], 'event' => $row['Event7']]);
                                    }
                                    if ($row['Pick8'] && $row['Event8']){
                                      array_push($event_list, ['pick' => $row['Pick8'], 'odds' => $row['Odds8'], 'event' => $row['Event8']]);
                                    }
                                    if ($row['Pick9'] && $row['Event9']){
                                      array_push($event_list, ['pick' => $row['Pick9'], 'odds' => $row['Odds9'], 'event' => $row['Event9']]);
                                    }
                                    if ($row['Pick10'] && $row['Event10']){
                                      array_push($event_list, ['pick' => $row['Pick10'], 'odds' => $row['Odds10'], 'event' => $row['Event10']]);
                                    }
                                    foreach ($event_list as $event){
                                      $query = "SELECT * FROM `SessionLogs` WHERE `EventID`='".$event['event']."'";
                                      $result = mysqli_query($con, $query);
                                      $slot_id = 0;
                                      if ($result) {
                                        $session_row = mysqli_fetch_assoc($result);
                                        $slot_id = $session_row['SlotID'];
                                      }
                                      ?>
                                      <div class="row">
                                        <div class="col-md-2 col-xs-2 div-center">
                                        </div>
                                        <div class="col-md-2 col-xs-2 div-center">
                                          <b><?=$slot_id?></b>
                                        </div>
                                        <div class="col-md-2 col-xs-2 div-center">
                                          <b><?=$event['event']?></b>
                                        </div>
                                        <div class="col-m3-4 col-xs-4 div-center">
                                          <b><?=$event['pick']?></b>
                                        </div>
                                        <div class="col-md-2 col-xs-2 div-center">
                                          <b><?=$event['odds']?></b>
                                        </div>
                                      </div>
                                      <?php
                                    }
                                    unset($event_list);
                                  ?>
                                  <hr class="bet-section-separator"/>
                                  <div class="row">
                                    <div class="col-md-3 col-xs-3 div-center">
                                    </div>
                                    <div class="col-md-3 col-xs-3 div-center">
                                      <b>Stake</b>
                                    </div>
                                    <div class="col-m3-4 col-xs-4 div-center">
                                      <b><?=$row['Stake']?></b>
                                    </div>
                                    <div class="col-md-2 col-xs-2 div-center">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-3 col-xs-3 div-center">
                                    </div>
                                    <div class="col-md-3 col-xs-3 div-center">
                                      <b>Win</b>
                                    </div>
                                    <div class="col-m3-4 col-xs-4 div-center">
                                      <b><?=round($row['Stake'] * $row['TotalOdds'] - $row['Stake'], 2);?></b>
                                      <hr class="bet-summary"/>
                                    </div>
                                    <div class="col-md-2 col-xs-2 div-center">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-3 col-xs-3 div-center">
                                    </div>
                                    <div class="col-md-3 col-xs-3 div-center">
                                      <b>Total</b>
                                    </div>
                                    <div class="col-m3-4 col-xs-4 div-center">
                                      <b><?=round($row['Stake'] * $row['TotalOdds'], 2);?></b>
                                    </div>
                                    <div class="col-md-2 col-xs-2 div-center">
                                    </div>
                                  </div>
                                  <hr class="bet-separator"/>
                            <?php
                                }
                              }
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                      <br />
                      <div class="row">
                        <div class="col-md-3 col-xs-3">
                        </div>
                        <div class="col-md-6 col-xs-6">
                          <button id="btn-confirm" class="btn-custom btn-action" onclick="print()"><h4><b>Print</b></h4></button>
                          <button id="btn-cancel" class="btn-custom btn-action" onclick="cancel()"><h4><b>Return to Place Bets ...</b></h4></button>
                        </div>
                        <div class="col-md-3 col-xs-3">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->


        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    <!-- Ion.RangeSlider -->
    <script src="../vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="../vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- jQuery Knob -->
    <script src="../vendors/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- Cropper -->
    <script src="../vendors/cropper/dist/cropper.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <script src="../build/js/jquery.redirect.js"></script>
    <script src="../build/js/jquery.printElement.js"></script>

    <script>
      $(document).ready(function() {
      });
      function print(){
        $('#ticket-preview-div').printElement();
		$.redirect('user_betplace.php');
      }
      function cancel(){
        $.redirect('user_betplace.php');
      }
    </script>
  </body>
</html>

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select...",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->

    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'right',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };

        $('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#reportrange_right').daterangepicker(optionSet1, cb);

        $('#reportrange_right').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange_right').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange_right').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });

        $('#options1').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
        });

        $('#options2').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
        });

        $('#destroy').click(function() {
          $('#reportrange_right').data('daterangepicker').remove();
        });

      });
    </script>

    <script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        $('#daterange').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal3').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_3"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal4').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        $('#reservation').daterangepicker({
    "showDropdowns": true,
    "timePickerIncrement": 1,
    "startDate": "08/01/2016",
    "endDate": "08/08/2016",
    "minDate": "01/01/2010",
    "opens": "right",
    "drops": "down",
}, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- Ion.RangeSlider -->
    <script>
      $(document).ready(function() {
        $("#range_27").ionRangeSlider({
          type: "double",
          min: 1000000,
          max: 2000000,
          grid: true,
          force_edges: true
        });
        $("#range").ionRangeSlider({
          hide_min_max: true,
          keyboard: true,
          min: 0,
          max: 5000,
          from: 1000,
          to: 4000,
          type: 'double',
          step: 1,
          prefix: "$",
          grid: true
        });
        $("#range_25").ionRangeSlider({
          type: "double",
          min: 1000000,
          max: 2000000,
          grid: true
        });
        $("#range_26").ionRangeSlider({
          type: "double",
          min: 0,
          max: 10000,
          step: 500,
          grid: true,
          grid_snap: true
        });
        $("#range_31").ionRangeSlider({
          type: "double",
          min: 0,
          max: 100,
          from: 30,
          to: 70,
          from_fixed: true
        });
        $(".range_min_max").ionRangeSlider({
          type: "double",
          min: 0,
          max: 100,
          from: 30,
          to: 70,
          max_interval: 50
        });
        $(".range_time24").ionRangeSlider({
          min: +moment().subtract(12, "hours").format("X"),
          max: +moment().format("X"),
          from: +moment().subtract(6, "hours").format("X"),
          grid: true,
          force_edges: true,
          prettify: function(num) {
            var m = moment(num, "X");
            return m.format("Do MMMM, HH:mm");
          }
        });
      });
    </script>
    <!-- /Ion.RangeSlider -->

    <!-- Bootstrap Colorpicker -->
    <script>
      $(document).ready(function() {
        $('.demo1').colorpicker();
        $('.demo2').colorpicker();

        $('#demo_forceformat').colorpicker({
            format: 'rgba',
            horizontal: true
        });

        $('#demo_forceformat3').colorpicker({
            format: 'rgba',
        });

        $('.demo-auto').colorpicker();
      });
    </script>
    <!-- /Bootstrap Colorpicker -->

    <!-- jquery.inputmask -->
    <script>
      $(document).ready(function() {
        $(":input").inputmask();
      });
    </script>
    <!-- /jquery.inputmask -->

    <!-- jQuery Knob -->
    <script>
      $(function($) {

        $(".knob").knob({
          change: function(value) {
            //console.log("change : " + value);
          },
          release: function(value) {
            //console.log(this.$.attr('value'));
            console.log("release : " + value);
          },
          cancel: function() {
            console.log("cancel : ", this);
          },
          /*format : function (value) {
           return value + '%';
           },*/
          draw: function() {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

              this.cursorExt = 0.3;

              var a = this.arc(this.cv) // Arc
                ,
                pa // Previous arc
                , r = 1;

              this.g.lineWidth = this.lineWidth;

              if (this.o.displayPrevious) {
                pa = this.arc(this.v);
                this.g.beginPath();
                this.g.strokeStyle = this.pColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                this.g.stroke();
              }

              this.g.beginPath();
              this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
              this.g.stroke();

              this.g.lineWidth = 2;
              this.g.beginPath();
              this.g.strokeStyle = this.o.fgColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
              this.g.stroke();

              return false;
            }
          }
        });

        // Example of infinite knob, iPod click wheel
        var v, up = 0,
          down = 0,
          i = 0,
          $idir = $("div.idir"),
          $ival = $("div.ival"),
          incr = function() {
            i++;
            $idir.show().html("+").fadeOut();
            $ival.html(i);
          },
          decr = function() {
            i--;
            $idir.show().html("-").fadeOut();
            $ival.html(i);
          };
        $("input.infinite").knob({
          min: 0,
          max: 20,
          stopper: false,
          change: function() {
            if (v > this.cv) {
              if (up) {
                decr();
                up = 0;
              } else {
                up = 1;
                down = 0;
              }
            } else {
              if (v < this.cv) {
                if (down) {
                  incr();
                  down = 0;
                } else {
                  down = 1;
                  up = 0;
                }
              }
            }
            v = this.cv;
          }
        });
      });
    </script>
    <!-- /jQuery Knob -->

    <!-- Cropper -->
    <script>
      $(document).ready(function() {
        var $image = $('#image');
        var $download = $('#download');
        var $dataX = $('#dataX');
        var $dataY = $('#dataY');
        var $dataHeight = $('#dataHeight');
        var $dataWidth = $('#dataWidth');
        var $dataRotate = $('#dataRotate');
        var $dataScaleX = $('#dataScaleX');
        var $dataScaleY = $('#dataScaleY');
        var options = {
              aspectRatio: 16 / 9,
              preview: '.img-preview',
              crop: function (e) {
                $dataX.val(Math.round(e.x));
                $dataY.val(Math.round(e.y));
                $dataHeight.val(Math.round(e.height));
                $dataWidth.val(Math.round(e.width));
                $dataRotate.val(e.rotate);
                $dataScaleX.val(e.scaleX);
                $dataScaleY.val(e.scaleY);
              }
            };


        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();


        // Cropper
        $image.on({
          'build.cropper': function (e) {
            console.log(e.type);
          },
          'built.cropper': function (e) {
            console.log(e.type);
          },
          'cropstart.cropper': function (e) {
            console.log(e.type, e.action);
          },
          'cropmove.cropper': function (e) {
            console.log(e.type, e.action);
          },
          'cropend.cropper': function (e) {
            console.log(e.type, e.action);
          },
          'crop.cropper': function (e) {
            console.log(e.type, e.x, e.y, e.width, e.height, e.rotate, e.scaleX, e.scaleY);
          },
          'zoom.cropper': function (e) {
            console.log(e.type, e.ratio);
          }
        }).cropper(options);


        // Buttons
        if (!$.isFunction(document.createElement('canvas').getContext)) {
          $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
        }

        if (typeof document.createElement('cropper').style.transition === 'undefined') {
          $('button[data-method="rotate"]').prop('disabled', true);
          $('button[data-method="scale"]').prop('disabled', true);
        }


        // Download
        /*if (typeof $download[0].download === 'undefined') {
          $download.addClass('disabled');
        }*/


        // Options
        $('.docs-toggles').on('change', 'input', function () {
          var $this = $(this);
          var name = $this.attr('name');
          var type = $this.prop('type');
          var cropBoxData;
          var canvasData;

          if (!$image.data('cropper')) {
            return;
          }

          if (type === 'checkbox') {
            options[name] = $this.prop('checked');
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');

            options.built = function () {
              $image.cropper('setCropBoxData', cropBoxData);
              $image.cropper('setCanvasData', canvasData);
            };
          } else if (type === 'radio') {
            options[name] = $this.val();
          }

          $image.cropper('destroy').cropper(options);
        });


        // Methods
        $('.docs-buttons').on('click', '[data-method]', function () {
          var $this = $(this);
          var data = $this.data();
          var $target;
          var result;

          if ($this.prop('disabled') || $this.hasClass('disabled')) {
            return;
          }

          if ($image.data('cropper') && data.method) {
            data = $.extend({}, data); // Clone a new one

            if (typeof data.target !== 'undefined') {
              $target = $(data.target);

              if (typeof data.option === 'undefined') {
                try {
                  data.option = JSON.parse($target.val());
                } catch (e) {
                  console.log(e.message);
                }
              }
            }

            result = $image.cropper(data.method, data.option, data.secondOption);

            switch (data.method) {
              case 'scaleX':
              case 'scaleY':
                $(this).data('option', -data.option);
                break;

              case 'getCroppedCanvas':
                if (result) {

                  // Bootstrap's Modal
                  $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                  if (!$download.hasClass('disabled')) {
                    $download.attr('href', result.toDataURL());
                  }
                }

                break;
            }

            if ($.isPlainObject(result) && $target) {
              try {
                $target.val(JSON.stringify(result));
              } catch (e) {
                console.log(e.message);
              }
            }

          }
        });

        // Keyboard
        $(document.body).on('keydown', function (e) {
          if (!$image.data('cropper') || this.scrollTop > 300) {
            return;
          }

          switch (e.which) {
            case 37:
              e.preventDefault();
              $image.cropper('move', -1, 0);
              break;

            case 38:
              e.preventDefault();
              $image.cropper('move', 0, -1);
              break;

            case 39:
              e.preventDefault();
              $image.cropper('move', 1, 0);
              break;

            case 40:
              e.preventDefault();
              $image.cropper('move', 0, 1);
              break;
          }
        });

        // Import image
        var $inputImage = $('#inputImage');
        var URL = window.URL || window.webkitURL;
        var blobURL;

        if (URL) {
          $inputImage.change(function () {
            var files = this.files;
            var file;

            if (!$image.data('cropper')) {
              return;
            }

            if (files && files.length) {
              file = files[0];

              if (/^image\/\w+$/.test(file.type)) {
                blobURL = URL.createObjectURL(file);
                $image.one('built.cropper', function () {

                  // Revoke when load complete
                  URL.revokeObjectURL(blobURL);
                }).cropper('reset').cropper('replace', blobURL);
                $inputImage.val('');
              } else {
                window.alert('Please choose an image file.');
              }
            }
          });
        } else {
          $inputImage.prop('disabled', true).parent().addClass('disabled');
        }
      });
    </script>
    <!-- /Cropper -->
  </body>
</html>