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
$query = "SELECT * FROM `Users` WHERE UserName='".$_SESSION['username']."'"; //password='".md5($password)."'";
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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="javascript:void(0)" class="site_title"><i class="fa fa-unlock"></i> <span>Admin</span></a>
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
                  <li class="active"><a href=""><i class="fa fa-user-times"></i> Edit / Delete User </a></li>
                  <li><a href="editlocation.php"><i class="fa fa-location-arrow"></i> Edit / Delete  Location</a></li>
                  <li><a href="betreport.php"><i class="fa fa-list-alt"></i> Bet Report </a></li>
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
                <h3>Menu - Edit / Delete User</h3>				<!-- Überschrift Main Fenster -->
              </div>
            </div>
          <div class="clearfix"></div>

            <div class="row">										<!-- Start mit Zeile -->

              <div class="col-md-5 col-xs-12">	<!-- Layout der Zeile -->
                <div class="x_panel">						<!-- Start mit Panel/Fenster -->
                  <div class="x_title">
                    <h2>Edit / Delete User...</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />

                    <form action="edit_user.php" method="post" class="form-horizontal form-label-left">	<!-- Start des Formulars -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select User</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
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
                                $query = "SELECT * FROM Users WHERE `UserStatus`='Active' ORDER BY UserID";
                                $result = mysqli_query($con,$query);
                                ?>

                                <select style="width:250px" name="UserID" class="select2_single form-control" tabindex="-1" id="UserID" onchange="onUserSelect(this);" required><option></option>
                                    <?php
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        ?>
                                        <option value="<?=$row['UserID']?>"> <?=$row['UserName']?> </option>
                                        <?php
                                    }
                                    // Free result set
                                    mysqli_free_result($result);
                                    mysqli_close($con);
                                    ?>
                                </select>
                            </div>
                        </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">First Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="FirstName" placeholder="First Name" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Second Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="LastName" placeholder="Second Name" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="UserName" placeholder="Username" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="password" class="form-control" name="Password" placeholder="Password">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
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
                            $query = "SELECT * FROM Locations WHERE LocationStatus='Active' ORDER BY Location";
                            $result = mysqli_query($con,$query);
                            ?>

                            <select style="width:250px" name="Location" class="select2_single form-control" tabindex="-1" id="Location" required><option></option>
                            <?php
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            ?>
                            <option value="<?=$row['LocationID']?>"> <?=$row['Location']?> </option>

                            <?php
                            }
                            // Free result set
                            mysqli_free_result($result);
                            mysqli_close($con);
                            ?>
                          </select>
                        </div>
                      </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Max Bet</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="MaxPayout" placeholder="Max Bet" required>
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Admin
                        </label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="UserType" value="Admin" class="flat">
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <input type="checkbox" name="IsDelete" style="display:none;">
                          <button class="btn btn-success" id="btn_submit">Submit</button>
                          <button class="btn btn-success" id="btn_delete">Delete</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>	<!-- End AddUser -->
              </div>														

							<div class="row">									<!-- Start Database User -->
              <div class="col-md-12 col-sm-12 col-xs-12">	
                <div class="x_panel">						<!-- Start Panel/Fenster -->
                  <div class="x_title">
                    <h2>Users in database...</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>User ID</th>
                          <th>Username</th>
                          <th>First Name</th>
                          <th>Second Name</th>
                          <th>Location ID</th>
                          <th>Type of User</th>
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
$query = "SELECT * FROM Users WHERE UserStatus='Active'";
$result = mysqli_query($con,$query);
?>

<?php
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
<tr>
<td><?php echo $row['UserID'];?></td>
<!----Admin?--->
<?php
if ($row['UserType'] == 'Admin') {
	?>
	<td style = "color:#44cc00"><?php echo $row['UserName'];?></td>
<?php
}else{
?>
<td><?php echo $row['UserName'];?></td>
<?php
}
?>
<!------------>
<td><?php echo $row['FirstName'];?></td>
<td><?php echo $row['LastName'];?></td>
<td><?php echo $row['LocationID'];?></td>

<?php
if ($row['UserType'] == 'Admin') {
	?>
	<td style = "color:#44cc00"><?php echo $row['UserType'];?></td>
<?php
}else{
?>
<td><?php echo $row['UserType'];?></td>
<?php
}
?>

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
    <script src="js/datepicker/daterangepicker.js"></script>
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

    <script>
        function onUserSelect(param){
            var user_id = param.value;
            if (user_id <= 0){
                alert('error');
                return;
            }
            $.ajax({
                url : 'db.php',
                type : 'POST',
                dataType : 'JSON',
                cache : false,
                data: {action: 'get_user', user_id:user_id},
                success(res){
                    switch (res.code){
                        case 0:
                            console.log(res.data);
                            $('input[name="FirstName"]').val(res.data.FirstName);
                            $('input[name="LastName"]').val(res.data.LastName);
                            $('input[name="UserName"]').val(res.data.UserName);
                            $('select[name="Location"]').val(res.data.LocationID).trigger("change");
                            $('input[name="MaxPayout"]').val(res.data.Max);
                            if (res.data.UserType == 'Admin'){
                                $('input[name="UserType"]').iCheck('check');
                            } else {
                                $('input[name="UserType"]').iCheck('uncheck');
                            }
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

        $(document).ready(function() {
            $('#btn_delete').click(function(){
                $('input[name="IsDelete"]').prop('checked', true);
            })
        });
    </script>

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
          placeholder: "Seleccionar",
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
        var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"Åland Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barthélemy",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"Côte d’Ivoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"Réunion",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"São Tomé and Príncipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };

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
    <!-- /Datatables -->

  </body>
</html>