<?php
include('db.php');

$dbpass = mysql_result(mysql_query("SELECT dbpass FROM siteup_settings WHERE id=1 LIMIT 1;"),0);

$password = $_GET['p'];
if ($password=="") {
	die("<b>SiteUp?</b><form method='get' action=''>
			<label for='p'>Password: </label>
			<input type='password' value='" . $_GET["i"] . "' name='p' id='p' />
			<button type='submit'>Go</button>
		</form>");
}
else if ($password!=$dbpass) {
	die("<b style='color:red;'>Invalid</b><br/><form method='get' action=''>
			<label for='p'>Password: </label>
			<input type='password' value='" . $_GET["i"] . "' name='p' id='p' />
			<button type='submit'>Go</button>
		</form>");
}
?>
<!DOCTYPE html>

<!-------------------------------------------- LICENSE (MIT) -------------------------------------------------

         					    Copyright (c) 2016 Conor Walsh
         					  Website: http://www.conorwalsh.net
	                            		GitHub:  https://github.com/conorwalsh
	                     				  Project: SiteUp?

				Permission is hereby granted, free of charge, to any person obtaining a copy
				of this software and associated documentation files (the "Software"), to deal
				in the Software without restriction, including without limitation the rights
				to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
				copies of the Software, and to permit persons to whom the Software is
				furnished to do so, subject to the following conditions:
				
				The above copyright notice and this permission notice shall be included in all
				copies or substantial portions of the Software.
				
				THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
				IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
				FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
				AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
				LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
				OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
				SOFTWARE.
		    _____      ____                        __        __    _     _       ____   ___  _  __   
		   / ___ \    / ___|___  _ __   ___  _ __  \ \      / /_ _| |___| |__   |___ \ / _ \/ |/ /_  
		  / / __| \  | |   / _ \| '_ \ / _ \| '__|  \ \ /\ / / _` | / __| '_ \    __) | | | | | '_ \ 
		 | | (__   | | |__| (_) | | | | (_) | |      \ V  V / (_| | \__ \ | | |  / __/| |_| | | (_) |
		  \ \___| /   \____\___/|_| |_|\___/|_|       \_/\_/ \__,_|_|___/_| |_| |_____|\___/|_|\___/ 
		   \_____/                                                                                   

----------------------------------------------- LICENSE END ------------------------------------------------>

<!---------------------------------------------- PAGE INFO --------------------------------------------------

          		This is the index page.
		  
---------------------------------------------- PAGE INFO END ----------------------------------------------->

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>SiteUp?</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/moment.js"></script>
  </head>

  <body>
    <div>

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home.php">SiteUp? Settings</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right navbar-user">
            <li style="padding: 15px 15px 14.5px;" class="userbtn" class="alerts-dropdown">
              <div id="clockbox"></div>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>SiteUp? Settings <small>View and edit settings</small></h1>
            <ol class="breadcrumb">
              <li><i class="fa fa-dashboard"></i> Dashboard</li>
            </ol>
            
             <?php if($_GET['emailchanged']=="true"){ echo "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The email report settings have been successfully updated.</div>"; }
                  else if($_GET['emailchanged']=="false"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The email report settings have failed to update.</div>"; }
				  else if($_GET['emailchanged']=="blank"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No text fields may be left blank or ommitted.</div>"; }
				  else if($_GET['emailchanged']=="invalid"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The email address that you entered was invalid.</div>"; }
				  
				  if($_GET['sitechanged']=="true"){ echo "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The domain name settings have been successfully updated.</div>"; }
                  else if($_GET['sitechanged']=="false"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The domain name settings have failed to update.</div>"; }
				  else if($_GET['sitechanged']=="blank"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No text fields may be left blank or ommitted.</div>"; }
				  else if($_GET['sitechanged']=="invalid"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The domain name that you entered was invalid.</div>"; }
				  
				  if($_GET['emailformatchanged']=="true"){ echo "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The email format settings have been successfully updated.</div>"; }
                  else if($_GET['emailformatchanged']=="false"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>The email format settings have failed to update.</div>"; }
				  else if($_GET['emailformatchanged']=="blank"){ echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No text fields may be left blank or ommitted.</div>"; }
				  ?>
            
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
          	
          	<?php
				
				$site = mysql_result(mysql_query("SELECT site FROM siteup_settings LIMIT 1"),0);
				
				$toemail = mysql_result(mysql_query("SELECT toemail FROM siteup_settings LIMIT 1"),0);
				$emailfirstname = mysql_result(mysql_query("SELECT emailfirstname FROM siteup_settings LIMIT 1"),0);
				$emaillastname = mysql_result(mysql_query("SELECT emaillastname FROM siteup_settings LIMIT 1"),0);
				$fromemail = mysql_result(mysql_query("SELECT fromemail FROM siteup_settings LIMIT 1"),0);
				
				$warningsubject = mysql_result(mysql_query("SELECT warningsubject FROM siteup_settings LIMIT 1"),0);
				$notificationsubject = mysql_result(mysql_query("SELECT notificationsubject FROM siteup_settings LIMIT 1"),0);
				$regardsname = mysql_result(mysql_query("SELECT regardsname FROM siteup_settings LIMIT 1"),0);
				$warningoffline = mysql_result(mysql_query("SELECT warningoffline FROM siteup_settings LIMIT 1"),0);
				$warninginvalid = mysql_result(mysql_query("SELECT warninginvalid FROM siteup_settings LIMIT 1"),0);
				$warningelse = mysql_result(mysql_query("SELECT warningelse FROM siteup_settings LIMIT 1"),0);
          	?>
          	
          	         	
          	<form style="margin-top: 20px;" role="form" method="post" action="sitechange.php">
          		<label>Domain name of website that is being monitored: </label>
				<input style="width:200px;" type="text" name="site" id="site" value="<?php echo $site;?>">
				<input style="padding: 3px 6px !important;" class="btn btn-primary" id="site-button" type="submit" name="submit" value="Save Changes" data-toggle="modal" data-controls-modal="#buffering" data-backdrop="static" data-keyboard="false" data-target="#buffering" /> 
          	</form><br/>
          	
          	<strong>Email Settings:</strong> <button style="font-size: 14px; padding: 3px 6px !important;" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#emailsettings">Change</button><br/><br/>
          	
          	<strong>Email Format:</strong> <button style="font-size: 14px; padding: 3px 6px !important;" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#emailformat">Change</button><br/><br/>
          	        	
          	<div class="modal fade" id="emailsettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title" id="myModalLabel">Change Email Settings</h4>
			      </div>
			       <form name="e1" role="form" action="changeemail.php" method="post">
				      <div class="modal-body">
				      	  <label for="emailcheck">Enable email notifications and reports:</label>
				      	  
				      	  <label for="toemail">Email Address:</label>
						  <input class="form-control" type="text" name="toemail" id="toemail" value="<?php echo $toemail; ?>"/>
						  <p class="help-block">This is the email address that the emails will be sent to.</p>
						  
						  <label for="tofirstname">First Name:</label>
						  <input class="form-control" type="text" name="emailfirstname" id="emailfirstname" value="<?php echo $emailfirstname; ?>"/>
						  <p class="help-block">This is the first name of the person associcated with the email address that the emails will be sent to.</p>
						  
						  <label for="tolastname">Last Name:</label>
						  <input class="form-control" type="text" name="emaillastname" id="emaillastname" value="<?php echo $emaillastname; ?>"/>
						  <p class="help-block">This is the last name of the person associcated with the email address that the emails will be sent to.</p>
						  
						  <label for="fromemail">From Email Address:</label>
						  <input class="form-control" type="email" name="fromemail" id="fromemail" value="<?php echo $fromemail; ?>" disabled="true"/>
						  <p class="help-block">This is the email address that the emails will be sent from (Cannot be changed).</p>
						  
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <input class="btn btn-primary" id="change-button" type="submit" name="submit" value="Save Changes" data-toggle="modal" data-controls-modal="#buffering" data-backdrop="static" data-keyboard="false" data-target="#buffering" /> 
				      </div>
				  </form>
			    </div>
			  </div>
			</div>
			
			<div class="modal fade" id="emailformat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title" id="myModalLabel">Change Email Format</h4>
			      </div>
			       <form name="g1" role="form" action="changeemailformat.php" method="post">
				      <div class="modal-body">
				      	  <label for="warningsubject">Offline Subject:</label>
						  <input class="form-control" type="text" name="warningsubject" id="warningsubject" value="<?php echo $warningsubject; ?>"/>
						  <p class="help-block">This is what appears in the subject of the offline email.</p>
						  
						  <label for="notificationsubject">Online Subject:</label>
						  <input class="form-control" type="text" name="notificationsubject" id="notificationsubject" value="<?php echo $notificationsubject; ?>"/>
						  <p class="help-block">This is what appears in the subject of the online email.</p>
						  
						  <label for="warningoffline">Offline Email Body Text:</label>
						  <input class="form-control" type="text" name="warningoffline" id="warningoffline" value="<?php echo $warningoffline; ?>"/>
						  <p class="help-block">This is what appears in the body of the online email.</p>
						  
						  <label for="warninginvalid">Invalid Error Email Body Text:</label>
						  <input class="form-control" type="text" name="warninginvalid" id="warninginvalid" value="<?php echo $warninginvalid; ?>"/>
						  <p class="help-block">This is what appears in the body of the invalid error email.</p>
						  
						  <label for="warningelse">Unknown Error Email Body Text:</label>
						  <input class="form-control" type="text" name="warningelse" id="warningelse" value="<?php echo $warningelse; ?>"/>
						  <p class="help-block">This is what appears in the body of the unknown error email.</p>
						  
						  <label for="regardsname">Regards Name:</label>
						  <input class="form-control" type="text" name="regardsname" id="regardsname" value="<?php echo $regardsname; ?>"/>
						  <p class="help-block">This is what appears at the end of the body of the emails.</p>
						  
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <input class="btn btn-primary" id="change-button" type="submit" name="submit" value="Save Changes" data-toggle="modal" data-controls-modal="#buffering" data-backdrop="static" data-keyboard="false" data-target="#buffering" /> 
				      </div>
				  </form>
			    </div>
			  </div>
			</div>
			
			
			
			<div class="modal fade" id="buffering" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div style="width: 93px!important; margin-left: 250px; margin-top: 130px;" class="modal-content">
			      <img width="90px" src="img/buffer.gif" />
			    </div>
			  </div>
			</div>
          	
          	
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="js/clock.js"></script>
		
    </script>
    
  </body>
</html>
