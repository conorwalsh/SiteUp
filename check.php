<?php

/*-------------------------------------------- LICENSE (MIT) -------------------------------------------------

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

----------------------------------------------- LICENSE END -----------------------------------------------*/

/*---------------------------------------------- PAGE INFO --------------------------------------------------

          		This script that is run by the cronjob that checks if the site is online
 				and sends and email if its not.
		  
---------------------------------------------- PAGE INFO END ----------------------------------------------*/

	$pass = $_GET['p'];
	
	include('db.php');
	
	$dbpass = mysql_result(mysql_query("SELECT dbpass FROM siteup_settings WHERE id=1 LIMIT 1;"),0);

	if($pass==$dbpass){

		$message;
		$response;
		
		$site = mysql_result(mysql_query("SELECT site FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
	
		function isSiteAvailable($url){
			//check, if a valid url is provided
			if(!filter_var($url, FILTER_VALIDATE_URL)){
				//return 'URL provided wasn\'t valid';
				return 'invalid';
			}
			
			//make the connection with curl
			$cl = curl_init($url);
			curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
			curl_setopt($cl,CURLOPT_HEADER,true);
			curl_setopt($cl,CURLOPT_NOBODY,true);
			curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);
			
			//get response
			$response = curl_exec($cl);
			
			curl_close($cl);
			
			//if ($response) return 'Site seems to be up and running!';
			if ($response) return 'success';
			
			//return 'Oops nothing found, the site is either offline or the domain doesn\'t exist';
			return 'failed';
		}
		
		$response = isSiteAvailable($site);
		
		$laststatusraw = explode(" ",mysql_result(mysql_query("SELECT status FROM siteup ORDER BY id DESC LIMIT 1;"),0));
	    
	    $laststatus = strtolower(strval($laststatusraw[0]));
		
		if ($response!="success"&&$laststatus!="offline") {	
						
			include('lib/mail.php');
			
			$to = mysql_result(mysql_query("SELECT toemail FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			$tofirstname = mysql_result(mysql_query("SELECT emailfirstname FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			$from = mysql_result(mysql_query("SELECT fromemail FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			
			$subject = mysql_result(mysql_query("SELECT warningsubject FROM siteup_settings WHERE id=1 LIMIT 1;"),0) . " (" . date('l jS \of F Y g:i:s A') . ")";
			
			$warning;
			if ($response == "failed") {
				$warning = mysql_result(mysql_query("SELECT warningoffline FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			}
			else if($response == "invalid") {
				$warning = mysql_result(mysql_query("SELECT warninginvalid FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			}
			else {
				$warning = mysql_result(mysql_query("SELECT warningelse FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			}
	
			$message = 'Hi ' . $tofirstname . ',<br/>This is a warning from the CCTV camera system.<br/><br/><strong style="font-weight: bold; color: #BD362F; font-size: 18px;">' . $warning . '</strong><br/><p style="text-align: center; font-size: 18px; font-weight: bold;"><a href="' . mysql_result(mysql_query("SELECT site FROM siteup_settings WHERE id=1 LIMIT 1;"),0) .'">Check site.</a></p>Regards,<br/>' . mysql_result(mysql_query("SELECT regardsname FROM siteup_settings WHERE id=1 LIMIT 1;"),0) .'.</p>';
			
			
			$status = sendmail($to, $subject, $message, $from);
		
			if($status==TRUE){
				$insertsql="INSERT INTO siteup (status) VALUES ('offline email success');";
				mysql_query($insertsql, $conn);
			}
			else if($status==FALSE){
				$status1 = sendmail($to, $subject, $message, $from);
				if($status1==TRUE){
					$insertsql="INSERT INTO siteup (status) VALUES ('offline email success2');";
					mysql_query($insertsql, $conn);
				}
				else if($status1==FALSE){
					$insertsql="INSERT INTO siteup (status) VALUES ('offline email fail');";
					mysql_query($insertsql, $conn);
				}
			}
		}
		else if($response=="success"&&$laststatus!="online"){
				
			include('lib/mail.php');
			
			$to = mysql_result(mysql_query("SELECT toemail FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			$tofirstname = mysql_result(mysql_query("SELECT emailfirstname FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			$from = mysql_result(mysql_query("SELECT fromemail FROM siteup_settings WHERE id=1 LIMIT 1;"),0);
			
			$subject = mysql_result(mysql_query("SELECT notificationsubject FROM siteup_settings WHERE id=1 LIMIT 1;"),0) . " (" . date('l jS \of F Y g:i:s A') . ")";
			
			$message = 'Hi ' . $tofirstname . ',<br/>This is a notification from the CCTV camera system.<br/><br/><strong style="font-weight: bold; color: #51A351; font-size: 18px;">The CCTV cameras are back online.</strong><br/><p style="text-align: center; font-size: 18px; font-weight: bold;"><a href="' . mysql_result(mysql_query("SELECT site FROM siteup_settings WHERE id=1 LIMIT 1;"),0) .'">Check site.</a></p>Regards,<br/>' . mysql_result(mysql_query("SELECT regardsname FROM siteup_settings WHERE id=1 LIMIT 1;"),0) .'.</p>';
			
			
			$status = sendmail($to, $subject, $message, $from);
		
			if($status==TRUE){
				$insertsql="INSERT INTO siteup (status) VALUES ('online email success');";
				mysql_query($insertsql, $conn);
			}
			else if($status==FALSE){
				$status1 = sendmail($to, $subject, $message, $from);
				if($status1==TRUE){
					$insertsql="INSERT INTO siteup (status) VALUES ('online email success2');";
					mysql_query($insertsql, $conn);
				}
				else if($status1==FALSE){
					$insertsql="INSERT INTO siteup (status) VALUES ('online email fail');";
					mysql_query($insertsql, $conn);
				}
			}
		}
	}
	else{
		 echo "Invalid Code";
	}
?>

