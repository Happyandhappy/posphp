<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include_once 'func.php';
	?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edge Game Server</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="copyright" content="" />
	<meta name="viewport" content="width=device-width" />
	
	<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
	<link href="css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />
	<link href="css/datepicker.css" type="text/css" rel="stylesheet" />
	<link href="css/dataTables.bootstrap.css" type="text/css" rel="stylesheet" />
	
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/jquery.treegrid.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.dataTables.js"></script>
	<script type="text/javascript" src="js/validate/formValidation.js"></script>
	<script type="text/javascript" src="js/validate/framework/bootstrap.js"></script>
	
	<script type="text/javascript">
		$(function(){
			// 유효성
			var validate = {
				rules : {
					userid : {
						required : true
					},
					userpw : {
						required : true
					}
				},
				message : {
					userid : {
						required : "Please input the username"
					},
					userpw : {
						required : "Please input the Password."
					}
				}
			}
			$("#loginform").submit(function(){
				if(isFormEmpty($(this).get(0), validate)) return false;
				setWait();
				$.ajax({
						type : "post",
						datatype : "text",
						data : $(this).serialize(),
						url : "login_proc.php",
						success : function(data, code){
							unsetWait();
							if(data == "ok") window.location.href = "index.php";
							else alert(data);
						}
				});
				return false;
			});
			$("#inputId").focus();
		});
	</script>
	
	<style type="text/css">
      body {
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 350px;
        padding: 19px 29px 29px;
        margin: 150px auto;
        
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
</head>
<body>
	<div class="page">
	
	<div class="form-signin" >
    
		 <form class="" id="loginform" method="post">
		     <input type="hidden" name="act" value="login" />
		     
			<h3 class="form-signin-heading">Video Stream</h3>
			<input type="text" class="input-block-level" placeholder="User Name" value="" name="userid" id="inputId">
			<input type="password" class="input-block-level" placeholder="Password" value="" name="userpw" id="inputPw">
			<!-- <label class="checkbox">
			    <input type="checkbox" value="1" name="rememberme" checked> Remember me
			</label>  --> <br/>
			<button class="btn btn-large btn-primary" type="submit">Confirm</button>
			<p></p>
			<p>
			<a href="http://ec2-54-169-111-167.ap-southeast-1.compute.amazonaws.com/login.php">System Login</a>
			</p>
		</form>

   	</div>
        
	</div>
</body>


</div>
  
</div>
        
</body>
</html>
    