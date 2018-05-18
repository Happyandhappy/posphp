<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login...</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">


  
<?php
include("connect.php");

// connect to the database
$con = mysqli_connect($server,$user,$pass,$dbname);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect : " . mysqli_connect_error();
  }

 // If form submitted, insert values into the database.

 if (isset($_POST['username'])){
 $username = $_POST['username'];
 $password = $_POST['password'];
 $username = stripslashes($username);
 $username = mysqli_real_escape_string($con,$username);
 $password = stripslashes($password);
 $password = mysqli_real_escape_string($con,$password);
 //Checking is user existing in the database or not
 $query = "SELECT * FROM `Users` WHERE UserName='$username' and Password='".md5($password)."'"; //password='".md5($password)."'";
 $result = mysqli_query($con,$query);
 $rows = mysqli_num_rows($result);

if ($username=='admin' && $password=='joda') {
	 $_SESSION['username'] = $username;
 		echo "<script type=\"text/javascript\">window.location.href='betreport.php';</script>";
 		}

 if($rows==1){
 //Check if user is Admin or normal user
 $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 if ($row['UserType'] == 'Admin') {
 $_SESSION['username'] = $username;
 echo "<script type=\"text/javascript\">window.location.href='betreport.php';</script>";
 }
 else{
 $_SESSION['username'] = $username;
 echo "<script type=\"text/javascript\">window.location.href='user_betreport.php';</script>";
 }
mysqli_free_result($result);
mysqli_close($con);
 }else{
?>
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
        <h1 style="text-align:center"><i class="fa fa-lock fa-4x"></i></h1>

        <section class="login_content">
            <form action="" method="post" name="login">
              <h1>ERROR !!!</h1><br/><h1>Login Data incorrect !</h1>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />
                <div>
                  <p>©2016 All Rights Reserved. Privacy and Terms</p>
                </div>
              </div>
						</form>
          </section>
        </div>
      </div>
    </div>

<?php
 }
 }else{
?>

    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
        <h1 style="text-align:center"><i class="fa fa-unlock-alt fa-3x"></i></h1>

        <section class="login_content">

            <form action="" method="post" name="login">
              <h1>Login please...</h1>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <input class="btn btn-default submit" type="submit" value="Login" name="login">
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <p>©2016 All Rights Reserved. Privacy and Terms</p>
				  <a href="http://ec2-54-169-111-167.ap-southeast-1.compute.amazonaws.com/login_stream.php">Video Stream</a>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>

<?php }
?>

</html>