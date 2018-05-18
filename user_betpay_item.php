<?php
$ticket_id = $_POST['ticket_id'];

include("connect.php");
$con = mysqli_connect($server,$user,$pass,$dbname);
if (mysqli_connect_errno())
{
  die;
}
$query = "SELECT * FROM Bets WHERE BetStatus = 'Active' ORDER BY BetID";
$result = mysqli_query($con,$query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
if (count($rows) <= 0){
  echo "No winning bets for TicketID $ticket_id";
  die;
}
$bets = array();
foreach ($rows as $row){
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
  $win_bet = true;
  foreach ($event_list as $event){
    $query = "SELECT * FROM SessionLogs WHERE EventID = '".$event['event']."' AND Winner = '".$event['win']."'";
    $result = mysqli_query($con,$query);
    if (!$result) {
      $win_bet = false;
      break;
    }
    if (!mysqli_fetch_assoc($result)){
      $win_bet = false;
      break;
    }
    mysqli_free_result($result);
  }
  unset($event_list);
  if ($win_bet){
    array_push($bets, $row);
  }
}
if (count($bets) <= 0){
  echo "No winning bets for TicketID $ticket_id";
  die;
}
for ($i = 0; $i < count($bets); $i++){
  $bet = $bets[$i];
  if ($bet['TicketID'] != $ticket_id){
    continue;
  }
  if ($i % 2 == 0) {
    $coloring = 'ticket-even';
  } else {
    $coloring = 'ticket-odd';
  }
  ?>
  <div class="row <?=$coloring?>">
    <div id="bet-pay-<?=$bet['BetID']?>">
      <div class="col-md-2 col-xs-2 div-center">
        <h4><b><?=$bet['BetID']?></b></h4>
      </div>
      <div class="col-md-2 col-xs-2 div-center">
        <h4><b><?=$bet['TicketID']?></b></h4>
      </div>
      <div class="col-md-2 col-xs-2 div-center">
        <h4><b><?=$bet['TotalOdds']?></b></h4>
      </div>
      <div class="col-md-2 col-xs-2 div-center">
        <h4><b><?=$bet['Stake']?></b></h4>
      </div>
      <div class="col-md-2 col-xs-2 div-center">
        <h4><b><?=echo round($bet['TotalOdds'] * $bet['Stake'], 0);?></b></h4>
      </div>
      <div class="col-md-2 col-xs-2 div-center">
        <a val="<?=$bet['BetID']?>" class="btn-mark btn_close_bet"><b><i class="fa fa-credit-card"></i></b></a>
      </div>
    </div>
  </div>
  <?php
}
?>