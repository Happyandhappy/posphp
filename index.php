<?php 

session_start();
if ($_SESSION["userid"] == "") header("Location: login.php");
include_once 'header.php'; 

$streamName = file_get_contents("loginuser");
?>
	
<script src="js/head.min.js" type="text/javascript" ></script>
<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="js/AC_RunActiveContent.js" language="javascript"></script>
<div class="main">
<!--<div class="Titlebar"> 
<div class="Logowrap"> -->
<div class="container"> 
		<div class="main-left">
			<!-- <img src='images/logo.png' alt='edge logo' style="width: 200px;margin-top: 500px;margin-left: 10px;"/> -->
			&nbsp;&nbsp;
		</div>
		<div class="main-middle">
			<div id="wowza">
	  		 <script language="javascript">
	                if (AC_FL_RunContent == 0) {
	                    alert("This page requires AC_RunActiveContent.js.");
	                } else {
	                    AC_FL_RunContent(
	                                     'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
	                                   //  'width', '636',
	                                   //  'height', '380',
					'width', '636',
					'height', '400',
	                                     'src', 'live',
	                                     'quality', 'high',
	                                     'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
	                                     'align', 'middle',
	                                     'play', 'true',
	                                     'loop', 'true',
	                                     'scale', 'showall',
	                                     'wmode', 'window',
	                                     'devicefont', 'false',
	                                     'id', 'live',
	                                     'bgcolor', '#000000',
	                                     'name', 'live',
	                                     'menu', 'true',
	                                     'allowFullScreen', 'true',
	                                     'allowScriptAccess','sameDomain',
	                                     'movie', 'live',
	                                     'salign', ''
	                                     ); //end AC code
	                }
	                </script>
	            <noscript>
	                <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="636" height="380" id="live" align="middle">
	                    <param name="allowScriptAccess" value="sameDomain" />
	                    <param name="allowFullScreen" value="true" />
	                    <param name="movie" value="live.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#000000" />	<embed src="live.swf" quality="high" bgcolor="#000000" width="636" height="380" name="live" align="middle" allowScriptAccess="sameDomain" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	                </object>
	            </noscript>
	  		</div>
	  		<div id="eventlist">
	  		<?php include_once 'ajaxoddslist.php';?> 
	  		</div>
			<div id="Sales">
         <span class="site-address" id="yui_3_17_2_1_1449813013316_1113"></span>
			</div>
			<div id="footer">
		<a href="http://edge-gaming.com/privacy-policy/" target="_blank"><span></span></a> <br/><br/>
         <span class="site-address" id="yui_3_17_2_1_1449813013316_1113"></span><br/><br/>
	<span class="site-address" id="yui_3_17_2_1_1449813013316_1113"></span>
		</div>
			
	  		
	  	</div>
		<div class="main-right">
			<?php include_once 'ajaxbetlist.php'?>
		</div>    
</div>
</div>
</div>


<script type="text/javascript">

function htmlSpecialChars(unsafe) {
    return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;");
}

var socket;
var isConnect = false;
function init() {
	//var host = "ws://52.77.222.127:9030/"; // SET THIS TO YOUR SERVER
	var host = "ws://<?php echo $addr?>:<?php echo $port?>/"; // connect to client server
	
	try {
		socket = new WebSocket(host);
		//log('WebSocket - status '+socket.readyState);
		socket.onopen    = function(msg) {
			isConnect = true; 
		};
		socket.onmessage = function(msg) {
			if (window.DOMParser)
			  {
			    parser=new DOMParser();
			    xmlDoc=parser.parseFromString(msg.data,"text/xml");
			  }
			else // Internet Explorer
			  {
			    xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
			    xmlDoc.async=false;
			    xmlDoc.loadXML(msg.data);
			  }
			if (xmlDoc.documentElement.nodeName == "ServerStatus") { // server status
				 $("#span_server_status").html(xmlDoc.documentElement.innerHTML);
			}  
			else if (xmlDoc.documentElement.nodeName == "LastMessage") { // Last Message
				$("#msg_display").html(xmlDoc.documentElement.innerHTML);
			}
			else if (xmlDoc.documentElement.nodeName == "RefreshEventList") { // Last Message
				$.ajax({
			           type: "POST",
			           url: "ajaxoddslist.php",
			           data: {
			           },
			           success: function(data)
			           {
			        	   $('#eventlist').html(data);
			           }
			         });
			}
			else if (xmlDoc.documentElement.nodeName == "BetConfirm") { // Last Message
				$.ajax({
			           type: "POST",
			           url: "ajaxbetconfirm.php",
			           data: {
			           },
			           success: function(data)
			           {
			        	   $('.main-right').html(data);
			           }
			         });
			}else if (xmlDoc.documentElement.nodeName == "BetSlipConfirm") { // Last Message
				$.ajax({
			           type: "POST",
			           url: "ajaxbetslipconfirm.php",
			           data: {
			           },
			           success: function(data)
			           {
			        	   $('.main-right').html(data);
			           }
			         });
			}
			
		};
		socket.onclose   = function(msg) { 
			$('#span_server_status').html("Connection Closed<br/>");
			isConnect = false;
		};
	}
	catch(ex){
		//alert('tt'); 
		//log(ex);
		$('#span_server_status').html("Not connected<br/>");
		isConnect = false;  
	}
	
}
function send(msg){
	try { 
		if (isConnect== false) reconnect();
		socket.send(msg);
		//socket.send("\r\n\r\n"); 
		log('Sent: '+msg); 
	} catch(ex) { 
		log(ex); 
	}
}
function quit(){
	if (socket != null) {
		log("Goodbye!");
		socket.close();
		socket=null;
	}
}

function reconnect() {
	quit();
	init();
}

// Utilities
function log(msg){ $("log").html($("log").html() +msg + "<br>"); }
function onkey(event){ if(event.keyCode==13){ send(); } }

function getLiveRTMPStream() {
	return "<?php echo $streamName?>";
}

function getLiveRTMPServer() {
//	return "rtmp://52.76.109.119:1935/live/";
	return "rtmp://52.76.109.119:1935/live/";
}

window.onload = function() {
	init();	
}

function AddBetSlip(eventid, playerid) {
	$.ajax({
        type: "POST",
        url: "ajaxaddbetslip.php",
        data: {
        	eventid: eventid,
        	playerid: playerid
        },
        success: function(data)
        {
     	   $('.main-right').html(data);
        }
      });
	/*var reqObj = new Object();
	reqObj.Type = "AddBetSlip";
	reqObj.EventID = eventid;
	reqObj.PlayerID = playerid;
	reqObj.TempBuffer = ""; // chrome buffers some short message, so add this random string
	var jsonStr = JSON.stringify(reqObj);
	send("<reqmsg>" + jsonStr+ "</reqmsg>");
	*/
}

function DeleteBetSlip(eventid, playerid) {
	$.ajax({
        type: "POST",
        url: "ajaxdeletebetslip.php",
        data: {
        	eventid: eventid,
        	playerid: playerid
        },
        success: function(data)
        {
     	   $('.main-right').html(data);
        }
      });
}

function CalcReturn() {
	if ($('#stake').val()!="") {
		$('#return').val(parseInt($('#stake').val() * $('#oddsmulti').val()));
	} else {
		$('#return').val("");
	}
}

function BetSlipConfirm() {
	if ($('#oddsmulti').val() == "") return;
	if ($('#return').val() == "" ) {
		alert('Please input stake value');
		return;
	}
	if ($('#curbet').val() == 1 ) {
		alert('Current Bet in Progress');
		return;
	}
	$.ajax({
        type: "POST",
        url: "ajaxslipconfirm.php",
        data: {
            stake: $('#stake').val(),
            ret: $('#return').val()
        },
        success: function(data)
        {
     	   $('.main-right').html(data);
        }
      });	
}
$(document).ready(function() {
    $("#stake").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});


  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-67806954-2', 'auto');
  ga('send', 'pageview');


</script>
