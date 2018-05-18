<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: login.php",  true,  301 );  exit;
}
else{
include("connect.php");

// connect to the database
$con = mysqli_connect($server,$user,$pass,$dbname);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect : " . mysqli_connect_error();
  }

// Check if user is Admin or normal user
$query = "SELECT * FROM `Users` WHERE UserName='".$_SESSION['username']."'";
$result = mysqli_query($con,$query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

// If User is Admin redirect him to Admin page
if ($row['UserType'] == 'Admin') {
$_SESSION['username'] = $row['UserName'];
mysqli_free_result($result);
mysqli_close($con);
}
// If User is normal redirect him to User page
else{
$_SESSION['username'] = $username;
mysqli_free_result($result);
mysqli_close($con);
die("RESTRICTED ADMIN AREA !");
}
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

    <title>Bet System | Admin</title>

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
              <a href="javascript:void(0)" class="site_title"><i class="fa fa-unlock"></i> <span>Admin Panel</span></a>
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
                  <li><a href="adduser.php"><i class="fa fa-user-plus"></i> Add User </a></li>
                  <li><a href="addlocation.php"><i class="fa fa-globe"></i> Add Location </a></li>
                  <li><a href="edituser.php"><i class="fa fa-user-times"></i> Edit / Delete User </a></li>
                  <li><a href="editlocation.php"><i class="fa fa-location-arrow"></i> Edit / Delete Location </a></li>
                  <li class="active"><a href="betreport.php"><i class="fa fa-list-alt"></i> Bet Report </a></li>
				  <li><a href="_admin_betsummary.php"><i class="fa fa-list-alt"></i> Bet Summary </a></li>
                  </br>
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
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
                <h3></h3>				<!-- ۢerschrift Main Fenster -->
              </div>
            </div>
          <div class="clearfix"></div>

            <div class="row">										<!-- Start mit Zeile -->
              <div class="col-md-12 col-sm-12 col-xs-12">	
                <div class="x_panel">						<!-- Start Panel/Fenster -->
                  <div class="x_title">
                    <h2>Bet Report : </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <div class="row">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>BetID</th>
                          <th>WinStatus</th>
                          <th>TicketID</th>
                          <th>UserName</th>
                          <th>Location</th>
                          <th>BetType</th>
                          <th>BetStatus</th>
                          <th>Pick1</th>
                          <th>Odds1</th>
                          <th>Event1</th>
                          <th>Pick2</th>
                          <th>Odds2</th>
                          <th>Event2</th>
                          <th>Pick3</th>
                          <th>Odds3</th>
                          <th>Event3</th>
                          <th>Pick4</th>
                          <th>Odds4</th>
                          <th>Event4</th>
                          <th>Pick5</th>
                          <th>Odds5</th>
                          <th>Event5</th>
                          <th>Pick6</th>
                          <th>Odds6</th>
                          <th>Event6</th>
                          <th>Pick7</th>
                          <th>Odds7</th>
                          <th>Event7</th>
                          <th>Pick8</th>
                          <th>Odds8</th>
                          <th>Event8</th>
                          <th>Pick9</th>
                          <th>Odds9</th>
                          <th>Event9</th>
                          <th>Pick10</th>
                          <th>Odds10</th>
                          <th>Event10</th>
                          <th>TotalOdds</th>
                          <th>Stake</th>
                          <th>BetReturn</th>
                          <th>DateTime</th>
                        </tr>
                      </thead>

                      <tbody style="font-weight: bold">
<?php
include("connect.php");

// connect to the database
$con = mysqli_connect($server,$user,$pass,$dbname);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect : " . mysqli_connect_error();
  }

// Query  
$bet_id_from = $_POST['TicketIDFrom'];
$bet_id_to = $_POST['TicketIDTo'];
$User = $_POST['UserName'];
$location = $_POST['Location'];

// Swap if $TicketFrom is > $TickerTo
if ($bet_id_from  > $bet_id_to)
{
list($bet_id_to, $bet_id_from)=array($bet_id_from, $bet_id_to);
}
// End of Swap

$Daterange = $_POST['Daterange'];

$From = "";
$To = "";
// Check if Datefilter is used or not
if (isset($Daterange) && $Daterange){
// Convert Daterange to Database Timestamp format
$range_From = substr ($Daterange, 0, 10 );
$range_To = substr ($Daterange, -10 );

$From_new = date_create($range_From);
$To_new = date_create($range_To);

$From = date_format($From_new, "Y/m/d 00:00:00");
$To = date_format($To_new, "Y/m/d 23:59:59");
// End convert
}
if ($From == "2014/01/08 00:00:00" and $To == "2016/08/08 23:59:59") {
	$From ="";
	$To="";
}
	 
// End Check if Datefilter is used or not

/*if (!empty($bet_id_from) && !empty($bet_id_to) && empty($User) && empty($From) && empty($To)){
	$query = "SELECT * FROM Bets WHERE BetID BETWEEN '.$bet_id_from.' AND '.$bet_id_to.'";
}

if (!empty($bet_id_from) && !empty($bet_id_to) && empty($User) && !empty($From) && !empty($To)){
	$query = "SELECT * FROM Bets WHERE BetID BETWEEN '.$bet_id_from.' AND '.$bet_id_to.' AND TimeDate BETWEEN ('.$From.') AND ('.$To.')";
}

if (!empty($bet_id_from) && !empty($bet_id_to) && !empty($User) && empty($From) && empty($To)){
	$query = "SELECT * FROM Bets WHERE BetID BETWEEN '.$bet_id_from.' AND '.$bet_id_to.' AND User= '.$User.'";
}

if (empty($bet_id_from) && empty($bet_id_to) && !empty($User) && !empty($From) && !empty($To)){
	$query = "SELECT * FROM Bets WHERE BetID BETWEEN ('.$From.') AND ('.$To.') AND User= '.$User.'";
}*/
if ($bet_id_from && $bet_id_to){
  $query = "SELECT * FROM Bets WHERE BetID BETWEEN '$bet_id_from' AND '$bet_id_to'";
} else {
  $query = "SELECT * FROM Bets WHERE 1";
}
$result = mysqli_query($con,$query);
?>

<?php
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
if (isset($Daterange) && $Daterange) {
  $query = "SELECT * FROM Tickets WHERE TicketID = '".$row['TicketID']."' AND TimeDate BETWEEN ('".$From."') AND ('".$To."')";
  $ticket_result = mysqli_query($con,$query);
  if (!$ticket_result){
    continue;
  }
  if (!mysqli_fetch_array($ticket_result, MYSQLI_ASSOC)){
    continue;
  }
}
if (isset($User) && $User){
  $query = "SELECT * FROM Tickets WHERE TicketID = '".$row['TicketID']."' AND User = '".$User."'";
  $ticket_result = mysqli_query($con,$query);
  if (!$ticket_result){
    continue;
  }
  if (!mysqli_fetch_array($ticket_result, MYSQLI_ASSOC)){
    continue;
  }
}
if (isset($location) && $location){
  $query = "SELECT * FROM Tickets WHERE TicketID = '".$row['TicketID']."' AND Location = '".$location."'";
  $ticket_result = mysqli_query($con,$query);
  if (!$ticket_result){
    continue;
  }
  if (!mysqli_fetch_array($ticket_result, MYSQLI_ASSOC)){
    continue;
  }
}

$query = "SELECT * FROM Tickets WHERE TicketID = '".$row['TicketID']."'";
$ticket_result = mysqli_query($con,$query);
if (!$ticket_result){
  continue;
}
$ticket = mysqli_fetch_array($ticket_result, MYSQLI_ASSOC);
if (!$ticket){
  continue;
}
$event_list = array();
if ($row['Pick1'] && $row['Event1']){
  array_push($event_list, ['win' => $row['Pick1'], 'event' => $row['Event1']]);
}
if ($row['Pick2'] && $row['Event2']){
  array_push($event_list, ['win' => $row['Pick2'], 'event' => $row['Event2']]);
}
if ($row['Pick3'] && $row['Event3']){
  array_push($event_list, ['win' => $row['Pick3'], 'event' => $row['Event3']]);
}
if ($row['Pick4'] && $row['Event4']){
  array_push($event_list, ['win' => $row['Pick4'], 'event' => $row['Event4']]);
}
if ($row['Pick5'] && $row['Event5']){
  array_push($event_list, ['win' => $row['Pick5'], 'event' => $row['Event5']]);
}
if ($row['Pick6'] && $row['Event6']){
  array_push($event_list, ['win' => $row['Pick6'], 'event' => $row['Event6']]);
}
if ($row['Pick7'] && $row['Event7']){
  array_push($event_list, ['win' => $row['Pick7'], 'event' => $row['Event7']]);
}
if ($row['Pick8'] && $row['Event8']){
  array_push($event_list, ['win' => $row['Pick8'], 'event' => $row['Event8']]);
}
if ($row['Pick9'] && $row['Event9']){
  array_push($event_list, ['win' => $row['Pick9'], 'event' => $row['Event9']]);
}
if ($row['Pick10'] && $row['Event10']){
  array_push($event_list, ['win' => $row['Pick10'], 'event' => $row['Event10']]);
}
$win_status = 'NA';
foreach ($event_list as $event){
  $query = "SELECT * FROM SessionLogs WHERE EventID = '".$event['event']."'";
  $event_result = mysqli_query($con,$query);
  if (!$event_result) {
    $win_status = 'NA';
    break;
  }
  $session_data = mysqli_fetch_assoc($event_result);
  if (!$session_data){
    $win_status = 'NA';
    break;
  }
  if ($session_data['Winner']){
    if ($session_data['Winner'] == $event['win']){
      $win_status = 'Win';
    } else {
      $win_status = 'Lose';
      break;
    }
  } else {
    $win_status = 'NA';
    break;
  }
  mysqli_free_result($event_result);
}
unset($event_list);
?>
<tr>
  <td><?php echo $row['BetID'];?></td>
  <td><?php echo $win_status;?></td>
  <td><?php echo $row['TicketID'];?></td>
  <td><?php echo $ticket['User'];?></td>
  <td><?php echo $ticket['Location'];?></td>
  <td><?php echo $row['BetType'];?></td>
  <td><?php echo $row['BetStatus'];?></td>
  <td><?php echo $row['Pick1'];?></td>
  <td><?php echo $row['Odds1'];?></td>
  <td><?php echo $row['Event1'];?></td>
  <td><?php echo $row['Pick2'];?></td>
  <td><?php echo $row['Odds2'];?></td>
  <td><?php echo $row['Event2'];?></td>
  <td><?php echo $row['Pick3'];?></td>
  <td><?php echo $row['Odds3'];?></td>
  <td><?php echo $row['Event3'];?></td>
  <td><?php echo $row['Pick4'];?></td>
  <td><?php echo $row['Odds4'];?></td>
  <td><?php echo $row['Event4'];?></td>
  <td><?php echo $row['Pick5'];?></td>
  <td><?php echo $row['Odds5'];?></td>
  <td><?php echo $row['Event5'];?></td>
  <td><?php echo $row['Pick6'];?></td>
  <td><?php echo $row['Odds6'];?></td>
  <td><?php echo $row['Event6'];?></td>
  <td><?php echo $row['Pick7'];?></td>
  <td><?php echo $row['Odds7'];?></td>
  <td><?php echo $row['Event7'];?></td>
  <td><?php echo $row['Pick8']?></td>
  <td><?php echo $row['Odds8'];?></td>
  <td><?php echo $row['Event8'];?></td>
  <td><?php echo $row['Pick9']?></td>
  <td><?php echo $row['Odds9'];?></td>
  <td><?php echo $row['Event9'];?></td>
  <td><?php echo $row['Pick10']?></td>
  <td><?php echo $row['Odds10'];?></td>
  <td><?php echo $row['Event10'];?></td>
  <td><?php echo $row['TotalOdds'];?></td>
  <td><?php echo $row['Stake'];?></td>
  <td><?php echo round($row['TotalOdds']*$row['Stake'], 2);?></td>
  <td><?php echo $ticket['TimeDate'];?></td>
</tr>
<?php
}
// Free result set
mysqli_free_result($result);
mysqli_close($con);
?>

                      </tbody>
                    </table>
                    </div>
                  </div>
                  
                  </div>
<a class="btn btn-success btn-lg" href="betreport.php">Back ...</a>
              </div>													<!-- End Database User -->

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

    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

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
    "startDate": "07/24/2016",
    "endDate": "08/03/2016",
    "minDate": "01/01/2010",
    "opens": "center",
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

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
  </body>
</html>