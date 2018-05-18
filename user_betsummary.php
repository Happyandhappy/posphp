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

    <title>Bet System | User</title>

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
	<link rel="stylesheet" type="text/css" href="build/css/daterangepicker.css" />
	<link href="../build/css/styles.css" rel="stylesheet">
	
	<style>
	#datatable-buttons_filter{visibility: hidden;}
	</style>
	
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
                  <li><a href="user_betplace.php"><i class="fa fa-check-square-o"></i> Place Bets </a></li>
                  <li><a href="user_ticketcancel.php"><i class="fa fa-eraser"></i> Cancel Tickets </a></li>
                  <li><a href="user_betpay.php"><i class="fa fa-credit-card"></i> Pay Bets </a></li>
                  <li><a href="user_resultreport.php"><i class="fa fa-pencil-square-o"></i> Result Report </a></li>
                  <li><a href="javascript:void(0)"><i class="fa fa-list-alt"></i> Bet Report </a></li>
				  <li class="active"><a href="user_betsummary.php"><i class="fa fa-list-alt"></i> Bet Summary </a></li>
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
				  <div class="row" style=" top: 60px; right: 15px; position: absolute;"><div class="col-md-12 col-xs-12"><?php if(!empty(@$_POST['Daterange'])){ echo @$_POST['Daterange'];}?></div></div>
				  <div class="row" style=" top: 80px; right: 15px; position: absolute;">
				        <div class="col-md-8 col-xs-12"></div>
								
						<div class="col-md-4 col-xs-12">
                       
					    <form id="filterdateselection" action="" method="post" class="form-horizontal form-label-left">
                    
						<div class="control-group">
                            <div class="form-group">

                              <div class="input-prepend input-group">
                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                
                                <input type="text" name="Daterange" id="reservation" class="form-control reservation" value="" />
                              </div>
                            </div>
                        </div>
						
						<!--<input name="submit" type="submit" class="btn btn-success" value="Submit" style="visibility: hidden; display: none;">-->
						</form>

                        </div>

				    </div>
					
                  <div class="x_content">
                    <br />
                     <div class="row">
                    <!--<table id="datatable-buttons" class="table table-striped table-bordered betsummary">
                      <thead>
                        <tr>
                          <th>Location</th>
                          <th>Total Bet Amount</th>
                          <th>Total Win Amount</th>
                          <th>Credit/Cancelled Bets</th>
                          <th>Grosss Gaining Revenue</th>
                        </tr>
                      </thead>
					  
                        
                      
					  

                      <tbody style="font-weight: bold">
<?php
include("connect.php");


$loclist = array();

// connect to the database
$con = mysqli_connect($server,$user,$pass,$dbname);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect : " . mysqli_connect_error();
  }

// Query  
$bet_id_from = @$_POST['TicketIDFrom'];
$bet_id_to = @$_POST['TicketIDTo'];
$User = $_SESSION['username'];
$location = @$_POST['Location'];

// Swap if $TicketFrom is > $TickerTo
if ($bet_id_from  > $bet_id_to)
{
list($bet_id_to, $bet_id_from)=array($bet_id_from, $bet_id_to);
}
// End of Swap

$Daterange = @$_POST['Daterange'];

echo $Daterange.'jks';
$From = "";
$To = "";
// Check if Datefilter is used or not
if (isset($Daterange) && $Daterange){
// Convert Daterange to Database Timestamp format
$range_From = substr ($Daterange, 0, 19 );
$range_To = substr ($Daterange, -19 );

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
  //$query = "SELECT * FROM Tickets WHERE TicketID = '".$row['TicketID']."'";
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
$sumStake = 0;
$sumTotalOdds = 0;
foreach ($event_list as $event){
  
  $query = "SELECT SUM(TotalOdds) TotalOdds, SUM(Stake) Stake FROM Bets WHERE Event1 = '".$event['event']."' AND BetStatus LIKE 'Active' GROUP BY Event1";
  $event_result = mysqli_query($con,$query);

  $session_data = mysqli_fetch_assoc($event_result);
 
  $sumStake = $sumStake + $session_data['Stake'];
  $sumTotalOdds = $sumTotalOdds + $session_data['TotalOdds'];
  mysqli_free_result($event_result);
}

$sumCancelled = 0;
foreach ($event_list as $event){
  
  $query = "SELECT SUM(Stake) Stake FROM Bets WHERE Event1 = '".$event['event']."' AND BetStatus NOT LIKE 'Active' GROUP BY Event1";
  $event_result = mysqli_query($con,$query);

  $session_data = mysqli_fetch_assoc($event_result);

  $sumCancelled = $sumCancelled + $session_data['Stake'];
  mysqli_free_result($event_result);
}

unset($event_list);




//if($win_status == 'Win'){
	
//$iTotalBetAmount = $row['Stake'];

$iTotalWinAmount = 0;
if($row['BetStatus'] == "Active" && $win_status == 'Win'){
    $iTotalWinAmount = $row['TotalOdds'] * $row['Stake'];
}



$isumCancelled = 0;
if($row['BetStatus'] != "Active"){
    $isumCancelled = $row['Stake'];
}

$iTotalBetAmount = $row['Stake'] - $isumCancelled;
$iGrossGamingRevenue = $iTotalBetAmount - $iTotalWinAmount;
?>
<tr>

<td><?php echo $ticket['Location'];?></td>
<td><?php echo $iTotalBetAmount;?></td>
<td><?php echo $iTotalWinAmount;?></td>
<td><?php echo $isumCancelled;?></td>
<td><?php echo $iGrossGamingRevenue;?></td>
						  
</tr>



<?php




array_push($loclist, ['Location' => $ticket['Location'], 'TotalBetAmount' => $iTotalBetAmount, 'TotalWinAmount' => $iTotalWinAmount, 'sumCancelled' => $isumCancelled, 'GrossGamingRevenue' => $iGrossGamingRevenue]);



//}
}
// Free result set
mysqli_free_result($result);
mysqli_close($con);
?>
                      </tbody>
                    </table>-->
					
					
					<table id="datatable-buttons" class="table table-striped table-bordered betsummary">
                      <thead>
                        <tr>
                          <th>Location</th>
                          <th>Total Bet Amount</th>
                          <th>Total Win Amount</th>
                          <th>Credit/Cancelled Bets</th>
                          <th>Grosss Gaining Revenue</th>
                        </tr>
                      </thead>
					  
                        
                      
					  

                      <tbody style="font-weight: bold">
					  <?php
/*foreach ($loclist as $loc){
  ?>
  <tr>

<td><?php echo $loc['Location'];?></td>
<td><?php echo $loc['TotalBetAmount'];?></td>
<td><?php echo $loc['TotalWinAmount'];?></td>
<td><?php echo $loc['sumCancelled'];?></td>
<td><?php echo $loc['GrossGamingRevenue'];?></td>
						  
</tr>
  
  <?php
 // echo $loc['TotalBetAmount'];
}*/

//print_r($loclist);


$sumloc = array();
foreach($loclist as $loc) {
    $index = loc_exists($loc['Location'], $sumloc);
    if ($index < 0) {
        $sumloc[] = $loc;
    }
    else {
        $sumloc[$index]['TotalBetAmount'] +=  $loc['TotalBetAmount'];
		$sumloc[$index]['TotalWinAmount'] +=  $loc['TotalWinAmount'];
		$sumloc[$index]['sumCancelled'] +=  $loc['sumCancelled'];
		$sumloc[$index]['GrossGamingRevenue'] +=  $loc['GrossGamingRevenue'];
    }
}
//print_r($sumloc); //display 

// for search if a loc has been added into $sumloc, returns the key (index)
function loc_exists($location, $array) {
    $result = -1;
    for($i=0; $i<sizeof($array); $i++) {
        if ($array[$i]['Location'] == $location) {
            $result = $i;
            break;
        }
    }
    return $result;
}


$locTotalBetAmount = 0;
$locTotalWinAmount = 0;
$locsumCancelled = 0;
$locGrossGamingRevenue = 0;

foreach ($sumloc as $loc){
  ?>
  <tr>

<td><?php echo $loc['Location'];?></td>
<td><?php echo $loc['TotalBetAmount'];?></td>
<td><?php echo $loc['TotalWinAmount'];?></td>
<td><?php echo $loc['sumCancelled'];?></td>
<td><?php echo $loc['GrossGamingRevenue'];?></td>
						  
</tr>
  
  <?php
 // echo $loc['TotalBetAmount'];
$locTotalBetAmount = $locTotalBetAmount + $loc['TotalBetAmount'];
$locTotalWinAmount = $locTotalWinAmount + $loc['TotalWinAmount'];
$locsumCancelled = $locsumCancelled + $loc['sumCancelled'];
$locGrossGamingRevenue = $locGrossGamingRevenue + $loc['GrossGamingRevenue'];

}

unset($loclist);
?>

  <tfoot>

<th>Total</th>
<th><?php echo $locTotalBetAmount;?></th>
<th><?php echo $locTotalWinAmount;?></th>
<th><?php echo $locsumCancelled;?></th>
<th><?php echo $locGrossGamingRevenue;?></th>
						  
</tfoot>
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
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script type="text/javascript" src="build/js/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
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

    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        $('#birthday').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- bootstrap-wysiwyg -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editor').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg -->

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select a Location",
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

    <!-- jQuery Tags Input -->
    <script>
      function onAddTag(tag) {
        alert("Added a tag: " + tag);
      }

      function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
      }

      function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
      }

      $(document).ready(function() {
        $('#tags_1').tagsInput({
          width: 'auto'
        });
      });
    </script>
    <!-- /jQuery Tags Input -->

    <!-- Parsley -->
    <script>
      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form .btn').on('click', function() {
          $('#demo-form').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });

      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form2 .btn').on('click', function() {
          $('#demo-form2').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form2').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });
      try {
        hljs.initHighlightingOnLoad();
      } catch (err) {}
    </script>
    <!-- /Parsley -->

    <!-- Autosize -->
    <script>
      $(document).ready(function() {
        autosize($('.resizable_textarea'));
      });
    </script>
    <!-- /Autosize -->

    <!-- jQuery autocomplete -->
    <script>
      $(document).ready(function() {
        var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"Ĭand Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barth諥my",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"C󳣠dIvoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"R贮ion",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"S⭠Tom矡nd Pr쭣ipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };

        var countriesArray = $.map(countries, function(value, key) {
          return {
            value: value,
            data: key
          };
        });

        // initialize autocomplete with custom appendTo
        $('#autocomplete-custom-append').autocomplete({
          lookup: countriesArray,
          appendTo: '#autocomplete-container'
        });
      });
    </script>
    <!-- /jQuery autocomplete -->

    <!-- Starrr -->
    <script>
      $(document).ready(function() {
        $(".stars").starrr();

        $('.stars-existing').starrr({
          rating: 4
        });

        $('.stars').on('starrr:change', function (e, value) {
          $('.stars-count').html(value);
        });

        $('.stars-existing').on('starrr:change', function (e, value) {
          $('.stars-count-existing').html(value);
        });
      });
    </script>

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
	
	<script>
      $(document).ready(function() {
		  var td = new Date();

var tmonth = td.getMonth()+1;
var tday = td.getDate();

var stmonth = td.getMonth();
var sdoutput = ((''+stmonth).length<2 ? '0' : '') + stmonth + '/' +
               ((''+tday).length<2 ? '0' : '') + tday + '/' +
	           td.getFullYear() + ' ' + 
			   td.getHours() + ":" + 
			   td.getMinutes() + ":" + 
			   td.getSeconds();
			   
var edoutput = ((''+tmonth).length<2 ? '0' : '') + tmonth + '/' +
               ((''+tday).length<2 ? '0' : '') + tday + '/' +
	           td.getFullYear() + ' ' + 
			   td.getHours() + ":" + 
			   td.getMinutes() + ":" + 
			   td.getSeconds();
			   
			  // alert(edoutput);
function changeFormatDate(date) {
    var d = new Date(date);
    var hh = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    var dd = "AM";
    var h = hh;
    if (h >= 12) {
        h = hh-12;
        dd = "PM";
    }
    if (h == 0) {
        h = 12;
    }
    m = m<10?"0"+m:m;
    
    s = s<10?"0"+s:s;

    /* if you want 2 digit hours: */
    h = h<10?"0"+h:h;

    var pattern = new RegExp("0?"+hh+":"+m+":"+s);
    return date.replace(pattern,h+":"+m+":"+s+" "+dd)
}
var stdate = changeFormatDate(sdoutput);
var etdate = changeFormatDate(edoutput);

$("#reservation").val();
		$('#reservation').daterangepicker({
    //"showDropdowns": true,
    //"timePickerIncrement": 1,
    <?php //if(empty(@$_POST['Daterange'])){ echo "autoUpdateInput: false,";}?>
	"autoUpdateInput": false,
    "startDate": sdoutput,
    "endDate": edoutput,
    "minDate": "01/01/2010",
    //"opens": "center",
    //"drops": "down",
	timePicker24Hour: true,
	timePickerSeconds: true,
    timePicker: true,
    timePickerIncrement: 1,
    locale: {
		<?php //if(empty(@$_POST['Daterange'])){ echo "cancelLabel: 'Clear',";}?>
		cancelLabel: 'Clear',
        format: 'MM/DD/YYYY h:mm:ss'
    }
}, function(start, end, label) {
         // console.log(start.toISOString(), end.toISOString(), label);
		 console.log("New date range selected: " + start.format('MM/DD/YYYY h:mm:ss') + " - " + end.format('MM/DD/YYYY h:mm:ss') + " (predefined range: " + label);
		  //$("#filterdateselection").submit();
		  $("#reservation").val(start.format('MM/DD/YYYY h:mm:ss') + " - " + end.format('MM/DD/YYYY h:mm:ss'));
		  //alert($("#reservation").val());
		  $("#filterdateselection").submit();
		  
        });
      });
    </script>
    <!-- /Datatables -->

  </body>
</html>