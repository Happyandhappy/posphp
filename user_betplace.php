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

    <title>Bet Report | User</title>

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
    <link href="../build/css/jquery-ui.min.css" rel="stylesheet">
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
                  <li><a href="user_resultreport.php"><i class="fa fa-pencil-square-o"></i> Result Report </a></li>
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
              <h3>Bet</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <?php
            $bank_notes = array(
                [5, '#DAEFEF', 'black'],
                [10, '#B7DDEA', 'black'],
                [20, '#94CBDF', 'black'],
                [50, '#67B8D3', 'black'],
                [100, '#65B9D1', 'black'],
                [200, '#3A8BA0', 'white'],
                [500, '#33859D', 'white'],
                [1000, '#2B7080', 'white'],
                [2000, '#26566A', 'white'],);
            function toLight($color){
              return '#'.dechex(hexdec(substr($color, 1, 6)) + 0x101010);
            }
            function toDark($color){
              return '#'.dechex(hexdec(substr($color, 1, 6)) - 0x101010);
            }
            ?>
            <div>
              <div class="row"> <!--Session Panel-->
                <div class="x_panel custom-panel">
                  <div class="x_title">
                    <h2><b id="session_id">Sesion ID : 0</b></h2>
                    <input type="hidden" id="user_name" val="<?=$_SESSION['username']?>"></input>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="fit_base">
                    <div class="col-md-6 col-xs-12">
                      <br />
                      <div class="row">
                        <div class="col-md-2 col-xs-2">
                        </div>
                        <div class="col-md-10 col-xs-10">
                          <div class="col-md-3 col-xs-3">
                            <h4><b>Opponent A</b></h4>
                          </div>
                          <div class="col-md-3 col-xs-3">
                            <h4 style="text-align: center;"><b>Odds A</b></h4>
                          </div>
                          <div class="col-md-3 col-xs-3">
                            <h4 style="text-align: center;"><b>Odds B</b></h4>
                          </div>
                          <div class="col-md-3 col-xs-3">
                            <h4><b>Opponent B</b></h4>
                          </div>
                        </div>
                      </div>
                      <?php
                      for ($i = 0; $i < 5; $i++){
                        ?>
                        <div class="row">
                          <div class="col-md-2 col-xs-2 event_splitter">
                            <h4><b id="session_event<?=$i?>_title">Event<?=($i+1)?></b></h4>
                          </div>
                          <div class="col-md-10 col-xs-10">
                            <div class="col-md-3 col-xs-3">
                              <h4 class="opt-name"><div id="session_event<?=$i?>_opt1_name">Opponent1</div></h4>
                            </div>
                            <div class="col-md-3 col-xs-3">
                              <button class="btn-custom btn-wide" id="fit_A"><h4><b id="session_event<?=$i?>_oddA">0.00</b></h4></button>
                            </div>
                            <div class="col-md-3 col-xs-3">
                              <button class="btn-custom btn-wide" id="fit_B"><h4><b id="session_event<?=$i?>_oddB">0.00</b></h4></button>
                            </div>
                            <div class="col-md-3 col-xs-3">
                              <h4 class="opt-name"><div id="session_event<?=$i?>_opt2_name">Opponent2</div></h4>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                      <br />
                      <div class="row">
                        <div class="col-md-2 col-xs-2">
                        </div>
                        <div class="col-md-10 col-xs-10">
                          <div class="col-md-3 col-xs-3">
                            <h4><b>Opponent A</b></h4>
                          </div>
                          <div class="col-md-3 col-xs-3">
                            <h4 style="text-align: center;"><b>Odds A</b></h4>
                          </div>
                          <div class="col-md-3 col-xs-3">
                            <h4 style="text-align: center;"><b>Odds B</b></h4>
                          </div>
                          <div class="col-md-3 col-xs-3">
                            <h4><b>Opponent B</b></h4>
                          </div>
                        </div>
                      </div>
                      <?php
                      for ($i = 5; $i < 10; $i++){
                        ?>
                        <div class="row">
                          <div class="col-md-2 col-xs-2 event_splitter">
                            <h4><b id="session_event<?=$i?>_title">Event<?=($i+1)?></b></h4>
                          </div>
                          <div class="col-md-10 col-xs-10">
                            <div class="col-md-3 col-xs-3">
                              <h4 class="opt-name"><div id="session_event<?=$i?>_opt1_name">Opponent1</div></h4>
                            </div>
                            <div class="col-md-3 col-xs-3">
                              <button class="btn-custom btn-wide"><h4><b id="session_event<?=$i?>_oddA">0.00</b></h4></button>
                            </div>
                            <div class="col-md-3 col-xs-3">
                              <button class="btn-custom btn-wide"><h4><b id="session_event<?=$i?>_oddB">0.00</b></h4></button>
                            </div>
                            <div class="col-md-3 col-xs-3">
                              <h4 class="opt-name"><div id="session_event<?=$i?>_opt2_name">Opponent2</div></h4>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row"> <!--Stake button panel-->
                <div class="x_panel custom-panel">
                  <div class="row" style="margin-left: 10px;">
                    <h2><b>Select Stake:</b></h2>
                  </div>
                  <div class="row">
                    <?php
                    foreach ($bank_notes as $bank){
                    ?>
                      <div class="col-md-1 col-xs-1" style="width:<?=(100 / count($bank_notes))?>%;">
                        <button class="btn-custom btn-wide bank" style="background: <?=$bank[1]?>; color: <?=$bank[2]?>;" onMouseOver="this.style.background='<?=toLight($bank[1])?>'" onMouseDown="this.style.background='<?=toDark($bank[1])?>'" onMouseUp="this.style.background='<?=toLight($bank[1])?>'" onMouseOut="this.style.background='<?=$bank[1]?>'"><h4><b><?php echo $bank[0]; ?></b></h4></button>
                      </div>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="x_panel custom-panel">
                  <div class="x_content">
                    <br />
                    <div class="col-md-6 col-xs-12">
                      <div id="ticket-preview">
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <div id="ticket-preview-id"><b>Ticket ID: 1</b></div>
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <div id="ticket-preview-date"><b>Date: <?=date("m/d/Y")?></b></div>
                          </div>
                        </div>
                        <div class="row">
                          <div id="ticket-preview-table" class="col-md-12 col-xs-12">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 col-xs-12">
                            <div id="ticket-preview-stake">Total Stake: 0</div>
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
                          <button id="btn-confirm" class="btn-custom btn-action" onclick="confirm()"><h4><b>Confirm</b></h4></button>
                          <button id="btn-cancel" class="btn-custom btn-action" onclick="cancel()"><h4><b>Cancel</b></h4></button>
                          <button id="btn-add" class="btn-custom btn-action" onclick="addBet()"><h4><b>Add</b></h4></button>
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

        <!-- modial dialog content -->
        <div id="max_paycheck_dialog" title="Win exceeds user's max payout limit" style="display:none; margin-top: 50px; overflow: hidden;">
          <div class="row" style="text-align: center">
            <div class="row">
              <label>Enter Admin password</label>
            </div>
            <div class="row">
              <input id="max_paycheck_password" name="password" type="password" style="width: 350px; margin:15px; padding: 5px; border: 1px solid grey; outline: 1px solid grey;">
            </div>
            <div class="row">
              <div class="col-md-12 col-xs-12" >
                <button id="btn-dialog-ok" class="btn-custom btn-dialog"><h4><b>OK</b></h4></button>
                <button id="btn-dialog-cancel" class="btn-custom btn-dialog"><h4><b>Cancel</b></h4></button>
              </div>
            </div>
          </div>
        </div>
        <!-- /modal dialog content -->


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
    <script src="../build/js/jquery-ui.min.js"></script>

    <script>
      class Event{
        constructor(){
          this.event_id = '';
          this.event_winner = '';
          this.event_odds = '';
        }
      }
      class Bet{
        constructor(){
          this.bet_id = '';
          this.bet_event_list = [];
          this.bet_stake = '';
          this.bet_odds = '';
          this.bet_win = '';
          this.bet_valid = false;
        }
      }
      var timer;
      var ticket_data = [];
      var bet_count = 1;

      function feedStatus() {
        $.ajax({
          url : 'db.php',
          type : 'POST',
          dataType : 'JSON',
          cache : false,
          data: {action: 'active_session'},
          success(res){
            var i;
            var event_data;
            var sel_oddA, sel_oddB;
            var btn_oddA, btn_oddB;
            var txt_event, txt_opt1, txt_opt2;
            switch (res.code)
            {
              case 0:
                $('#session_id').html('Session ID : ' + res.data[0]['SessionID']);
                for (i = 0; i < 10; i++) {
                  event_data = res.data[i];
                  sel_oddA = '#session_event' + i + '_oddA';
                  sel_oddB = '#session_event' + i + '_oddB';
                  txt_event = $('#session_event' + i + '_title');
                  txt_opt1 = $('#session_event' + i + '_opt1_name');
                  txt_opt2 = $('#session_event' + i + '_opt2_name');
                  txt_opt1.html(event_data['Opponent1']);
                  txt_opt2.html(event_data['Opponent2']);
                  $(sel_oddA).html(event_data['OddsA']);
                  $(sel_oddB).html(event_data['OddsB']);
                  btn_oddA = $(sel_oddA).parent().parent();
                  btn_oddB = $(sel_oddB).parent().parent();
                  if (event_data['BetStatus'] == 'BetStop'){
                    if (!txt_event.hasClass('txt-inactive')){
                      txt_event.addClass('txt-inactive');
                    }
                    if (!txt_opt1.hasClass('txt-inactive')){
                      txt_opt1.addClass('txt-inactive');
                    }
                    if (!txt_opt2.hasClass('txt-inactive')){
                      txt_opt2.addClass('txt-inactive');
                    }
                    btn_oddA.removeClass('btn-active');
                    btn_oddB.removeClass('btn-active');
                    if (!btn_oddA.hasClass('btn-inactive')){
                      btn_oddA.addClass('btn-inactive');
                    }
                    if (!btn_oddB.hasClass('btn-inactive')){
                      btn_oddB.addClass('btn-inactive');
                    }
                  } else if (event_data['BetStatus'] == 'BetStart'){
                    txt_event.removeClass('txt-inactive');
                    txt_opt1.removeClass('txt-inactive');
                    txt_opt2.removeClass('txt-inactive');
                    btn_oddA.removeClass('btn-inactive');
                    btn_oddB.removeClass('btn-inactive');
                    if (!btn_oddA.hasClass('btn-active')){
                      btn_oddA.addClass('btn-active');
                    }
                    if (!btn_oddB.hasClass('btn-active')){
                      btn_oddB.addClass('btn-active');
                    }
                    btn_oddA.attr('event_id', event_data['EventID']);
                    btn_oddB.attr('event_id', event_data['EventID']);
                    btn_oddA.attr('slot_id', event_data['SlotID']);
                    btn_oddB.attr('slot_id', event_data['SlotID']);
                    btn_oddA.attr('event_idx', i);
                    btn_oddB.attr('event_idx', i);
                    btn_oddA.attr('event_opt', 1);
                    btn_oddB.attr('event_opt', 2);
                  }
                }
                $('.btn-inactive').off('click');
                $('.btn-active').off('click');
                $('.btn-active').click(onOddsClick);
                break;
              case 1:
                console.log(res.data);
                break;
              case 2:
                console.log('no active session');
                break;
            }
          },
          error(res){
            console.log(res);
          }
        });
      }

      $(document).ready(function() {
        $('.bank').click(onBankNote);
        feedStatus();
        startTimer();
        addPendingBet(bet_count);
        $('#btn-add').hide();
        fitTicketSectionToOdds();
        $("#max_paycheck_dialog").dialog({
          autoOpen: false,
          modal: true,
          resizable: false,
          my: "center",
          at: "center",
          of: window,
          width: 500,
          height: 250,
          open: function(event, ui) {
            $(".ui-dialog-titlebar-close").hide();
            $(".ui-dialog-title").css('text-align', 'center');
            $(".ui-dialog-title").css('width', '100%');
            $('#max_paycheck_password').val('');
            $('#btn-dialog-ok').off("click");
            $('#btn-dialog-cancel').off("click");
            $('#btn-dialog-ok').click(function(){
              var password
              var i;
              var upload_data = [];
              var user = $('#user_name').attr('val');
              for (i = 0; i < ticket_data.length; i++){
                if (ticket_data[i].bet_valid){
                  upload_data.push(ticket_data[i]);
                }
              }

              password = $('#max_paycheck_password').val();
              if (password == ''){
                alert('Please input password.');
                $('#max_paycheck_password').focus();
                return;
              } else {
                $.ajax({
                  url : 'db.php',
                  type : 'POST',
                  dataType : 'JSON',
                  cache : false,
                  async : false,
                  data: {action: 'check_admin_password', user:user, password: password},
                  success(res){
                    switch (res.code){
                      case 0:
                        if (res.data == 'no_admin_matching'){
                          alert("No admin matching current location.");
                        } else if (res.data == 'no_password_matching'){
                          alert("No password matching current location.");
                        } else if (res.data == 'ok'){
                          sendAddTicketRequest(user, upload_data);
                          $("#max_paycheck_dialog").dialog("close");
                        } else {
                          alert("Unhandled error occured.");
                        }
                        break;
                      case 1:
                        alert("Password doesn't match.");
                        return;
                        break;
                      default:
                        alert('Unhandled error occurred.');
                        return;
                        break;
                    }
                  },
                  error(res){
                    console.log(res);
                  }
                });
              }
            });
            $('#btn-dialog-cancel').click(function(){
              $("#max_paycheck_dialog").dialog("close");
            });
          },
        });
      });
      $(window).resize(function() {
        fitTicketSectionToOdds();
      });
      function startTimer() {
        timer = setInterval(feedStatus, 5000);
      }
      function stopTimer() {
        clearInterval(timer);
      }
      function fitTicketSectionToOdds(){
        var odd_left = $('#fit_A').offset().left;
        var odd_right = $('#fit_B').offset().left + $('#fit_B').width() / 2;
        var ticket_base = $('#fit_base').offset().left;
        var ticket_center = $('#ticket-preview').width() / 2;
        $('#ticket-preview').css('margin-left', (odd_left + odd_right) / 2 - ticket_center - ticket_base);
      }
      function confirm(){
        var i;
        var upload_data = [];
        var win_amount = 0;
        var user = $('#user_name').attr('val');
        for (i = 0; i < ticket_data.length; i++){
          if (ticket_data[i].bet_valid){
            upload_data.push(ticket_data[i]);
          }
        }
        if (upload_data.length == 0){
          alert("Por favor añada al menos una apuesta.");
          return;
        }
        $.ajax({
          url : 'db.php',
          type : 'POST',
          dataType : 'JSON',
          cache : false,
          data: {action: 'get_max_payout', user:user},
          success(res){
            switch (res.code){
              case 0:
                for (i = 0; i < upload_data.length; i++){
                  win_amount = parseFloat(win_amount) + parseFloat(upload_data[i].bet_win);
                }
                if (win_amount > res.data){
                  $("#max_paycheck_dialog").dialog("open");
                } else {
                  sendAddTicketRequest(user, upload_data);
                }
                break;
              default:
                alert('Unhandled error occurred.');
                return;
                break;
            }
          },
          error(res){
            console.log(res);
          }
        });
      }
      function sendAddTicketRequest(user, upload_data){
        $.ajax({
          url : 'db.php',
          type : 'POST',
          dataType : 'JSON',
          cache : false,
          data: {action: 'add_ticket', user:user, data:upload_data},
          success(res){
            switch (res.code){
              case 0:
                $.redirect('ticketprint.php', {data:res.data}, 'POST', '');
                return;
                break;
              case 3:
                alert('Event has started.');
                return;
                break;
              default:
                alert('Unhandled error occurred.');
                return;
                break;
            }
          },
          error(res){
            console.log(res);
          }
        });
      }
      function cancel(){
        bet_count = 1;
        ticket_data.length = 0;
        $('.btn_close_bet').trigger('click');
        addPendingBet(bet_count);
      }
      function addBet() {
        var bet_prefix = 'ticket_bet'+bet_count;
        var stake = $('#'+bet_prefix+'_stake');
        if (stake.val() <= 0){
          alert('Stake must be greater than 0.');
          return;
        }
        stake.parent().html('<b id="'+stake.attr('id')+'">'+stake.val()+'</b>');

        var bet_data = new Bet();
        bet_data.bet_valid = true;
        bet_data.bet_id = bet_count;
        bet_data.bet_stake = parseInt($('#'+bet_prefix+'_stake').html());
        bet_data.bet_odds = parseFloat($('#'+bet_prefix+'_odds').html()).toFixed(2);
        bet_data.bet_win = parseFloat($('#'+bet_prefix+'_win').html()).toFixed(2);
        $.each($('#'+bet_prefix+'_table').find('tbody').find('.event_entry'), function() {
          var event_data = new Event();
          event_data.event_id = $(this).children('td:nth-child(2)').html();
          event_data.event_winner = $(this).children('td:nth-child(3)').html();
          event_data.event_odds = $(this).children('td:nth-child(4)').html();
          bet_data.bet_event_list.push(event_data);
        });
        ticket_data.push(bet_data);

        bet_count++;
        $('.btn_close_bet').show();
        addPendingBet(bet_count);
        $('#btn-add').hide();
      }
      function addPendingBet(id){
        var ticket_view = $("#ticket-preview-table");
        var div_bet = $(document.createElement('div'));
        var div_bet_header = $(document.createElement('div'));
        var div_bet_left = $(document.createElement('div'));
        var div_bet_right = $(document.createElement('div'));
        var div_bet_id = $(document.createElement('div'));
        var div_bet_type = $(document.createElement('div'));
        var div_bet_close = $(document.createElement('a'));
        var div_bet_table = $(document.createElement('table'));
        var div_bet_table_head = $(document.createElement('thead'));
        var div_bet_table_body = $(document.createElement('tbody'));
        var div_bet_table_stake = $(document.createElement('tr'));
        var div_bet_table_odds = $(document.createElement('tr'));
        var div_bet_table_win = $(document.createElement('tr'));
        var bet_prefix = 'ticket_bet'+id;

        div_bet_header.attr('class', 'row ticket-head');
        div_bet_header.append(div_bet_left);
        div_bet_header.append(div_bet_right);
        div_bet_left.attr('class', 'col-md-8 col-xs-8');
        div_bet_right.attr('class', 'col-md-4 col-xs-4').css('text-align', 'right');
        div_bet_id.attr('id', bet_prefix + '_id').html('<b>Bet ID: ' + id + '</b>')
        div_bet_type.attr('id', bet_prefix + '_type').html('<b>Bet Type: Single</b>');
        div_bet_left.append(div_bet_id);
        div_bet_left.append(div_bet_type);
        div_bet_close.attr('val', id).attr('class', 'btn_close_bet').html('<i class="fa fa-close"></i>');
        div_bet_close.hide();
        div_bet_right.append(div_bet_close);
        div_bet_table.attr('id', bet_prefix + '_table').attr('class', 'row ticket_bet_table');
        div_bet_table_head.html('<tr><th>Fight</th><th>Event</th><th>Winner</th><th>Stake</th></tr>');
        div_bet_table_stake.attr('class', 'ticket-even ticket-stake').html('<td></td><td><b>Stake</b></td><td><input class="stake-input" id="'+bet_prefix+'_stake'+'"></input></td><td></td>');
        div_bet_table_odds.attr('class', 'ticket-odd').html('<td></td><td><b>Odds</b></td><td><b id="'+bet_prefix+'_odds'+'">0.00</b></td><td></td>');
        div_bet_table_win.attr('class', 'ticket-even').html('<td></td><td><b>Win</b></td><td><b id="'+bet_prefix+'_win'+'">0.00</b></td><td></td>');
        div_bet_table.append(div_bet_table_head);
        div_bet_table.append(div_bet_table_body);
        div_bet_table_body.append(div_bet_table_stake);
        div_bet_table_body.append(div_bet_table_odds);
        div_bet_table_body.append(div_bet_table_win);
        div_bet.attr('id', 'ticket_bet'+id).attr('class', 'ticket_element');
        div_bet.append(div_bet_header);
        div_bet.append(div_bet_table);
        ticket_view.prepend(div_bet);
        $('#'+bet_prefix+'_stake').val(0);
        $('.btn_close_bet').off('click');
        $('.btn_close_bet').click(closeBet);
        $('.stake-input').on('input', updateTicket);
      }
      function closeBet(){
        var id = parseInt($(this).attr('val'));
        var i;

        for (i = 0; i < ticket_data.length; i++){
          if (ticket_data[i].bet_id == id){
            ticket_data[i].bet_valid = false;
            break;
          }
        }
        $('#ticket_bet' + id).slideUp('fast', function(){$(this).remove()}).animate({ opacity: 0 },{ queue: false, duration: 'fast' });
      }
      function updateTicket(){
        var bet_prefix = 'ticket_bet'+bet_count;
        var odds = 0.0;
        var win;
        var cur_stake;
        var total_stake = 0;

        $.each($('#'+bet_prefix+'_table').find('tbody').find('.event_entry'), function() {
          if (parseFloat(odds) == 0.0){
            odds = parseFloat($(this).children('td:nth-child(4)').html());
          } else {
            odds = odds * parseFloat($(this).children('td:nth-child(4)').html());
          }
        });
        odds = odds.toFixed(2);
        $('#'+bet_prefix+'_odds').html(odds);

        cur_stake = $('#'+bet_prefix+'_stake').val();
        win = parseFloat(cur_stake) * parseFloat(odds);
        win = win.toFixed(2);
        $('#'+bet_prefix+'_win').html(win);

        $.each($('#ticket-preview').find('.ticket-stake'), function(idx) {
          if (idx == 0) { //for pending stake, use cur_stake variable.
            total_stake = parseInt(total_stake) + parseInt(cur_stake);
          } else {
            total_stake = parseInt(total_stake) + parseInt($(this).children('td:nth-child(3)').children().first().html());
          }
        });
        $('#ticket-preview-stake').html('Stake Total: ' + total_stake);
      }
      function onOddsClick(){
        var id = $(this).attr('event_id');
        var slot_id = $(this).attr('slot_id');
        var idx = $(this).attr('event_idx');
        var opt = $(this).attr('event_opt');
        var winner = $('#session_event'+idx+'_opt'+opt+'_name').html();
        var odds = $(this).children().children().html();
        var tr_same = $('#ticket_bet'+bet_count+'_table').find('#event_'+id);
        if (tr_same.html() === undefined){ //not exist
          var tr_entry = $(document.createElement('tr'));
          var coloring = coloring = 'ticket-even';
          if ($('#ticket_bet'+bet_count+'_table').find('tbody').find('.event_entry').length % 2 == 1){
            coloring = 'ticket-odd';
          }
          tr_entry.attr('id', 'event_'+id).attr('class', 'ticket_bet event_entry ' + coloring).html('<td>'+slot_id+'</td><td>'+id+'</td><td>'+winner+'</td><td>'+odds+'</td>');
          tr_entry.insertBefore($('.ticket-stake').first());
          if ($('#ticket_bet'+bet_count+'_table').find('tbody').find('.event_entry').length > 1){
            $('#ticket_bet'+bet_count+'_type').html('<b>Bet Type: Multiple</b>');
          } else if ($('#ticket_bet'+bet_count+'_table').find('tbody').find('.event_entry').length >= 1){
            $('#btn-add').show();
          }
        } else { //exist
          tr_same.html('<td>'+slot_id+'</td><td>'+id+'</td><td>'+winner+'</td><td>'+odds+'</td>');
        }
        updateTicket();
      }
      function onBankNote(){
        var note = $(this).children().children().html();
        var stake = $('#ticket_bet'+bet_count+'_stake');
        stake.val(parseInt(stake.val()) + parseInt(note));
        updateTicket();
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