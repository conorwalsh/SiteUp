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
		
		define('SITE_NAME', mysql_result(mysql_query("SELECT regardsname FROM siteup_settings WHERE id=1 LIMIT 1;"),0)); 
		define('SITE_URL', mysql_result(mysql_query("SELECT site FROM siteup_settings WHERE id=1 LIMIT 1;"),0)); 
	
		function email_template($message) {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ><style>table td p {margin-bottom:15px;}</style></head><body style="padding:0;margin:0;background: #f3f3f3;font-family:arial, \'helvetica neue\', helvetica, serif" ><table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="padding: 0 0 35px 0; background:#f3f3f3;"><tr><td align="center" style="margin: 0; padding: 0;"><center><table border="0" cellpadding="0" cellspacing="0" width="600"><tr><th style="padding:10px 0 10px 5px;text-align:left;vertical-align:top;" ><a href="'.SITE_URL.'" target="_blank" >'.SITE_NAME.'</a></th></tr><tr><td style="border-radius:5px;background:#fff;border:1px solid #e1e1e1;font-size:12px;font-family:arial, helvetica, sans-serif;padding:20px;font-size:13px;line-height:22px;" >'.$message.'</td></tr><tr><td style="padding-top:10px;font-size:10px;color:#aaa;line-height:14px;font-family:arial, \'helvetica neue\', helvetica, serif" ><p class="meta">This email is being sent to you from '.SITE_NAME.'.<br />&copy; <a href="http://conorwalsh.net/" style="font-size:10px;color:#aaa;line-height:14px;font-family:arial, \'helvetica neue\', helvetica, serif;">ConorWalsh.Net</a> '.date('Y').'</p></td></tr></table></center></td></tr></table></body></html>';
		}
	
		function isSiteAvailable($url){
			//check, if a valid url is provided
			if(!filter_var($url, FILTER_VALIDATE_URL)){
				//return 'URL provided wasnt valid';
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
		
		$laststatusraw = explode(" ",mysql_result(mysql_query("SELECT status FROM cctvup_new ORDER BY id DESC LIMIT 1;"),0));
	    
	    $laststatus = strtolower(strval($laststatusraw[0]));
		
		if($response!="success"){
			//First Check
			if($laststatus=="online") {	
				$insertsql="INSERT INTO cctvup_new (status) VALUES ('check fail email not required');";
				mysql_query($insertsql, $conn);
			}
			//Second check
			else if($laststatus=="check") {	
				//include('lib/mail.php');
				require_once('../mail/new/mail.cw.php');
				
				$to = mysql_result(mysql_query("SELECT toemail FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				$tofirstname = mysql_result(mysql_query("SELECT emailfirstname FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				$from = mysql_result(mysql_query("SELECT fromemail FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				
				$subject = mysql_result(mysql_query("SELECT warningsubject FROM cctvup_settings WHERE id=1 LIMIT 1;"),0) . " (" . date('l jS \of F Y g:i:s A') . ")";
				
				$warning;
				if ($response == "failed") {
					$warning = mysql_result(mysql_query("SELECT warningoffline FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				}
				else if($response == "invalid") {
					$warning = mysql_result(mysql_query("SELECT warninginvalid FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				}
				else {
					$warning = mysql_result(mysql_query("SELECT warningelse FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				}
		
				$message = 'Hi ' . $tofirstname . ',<br/>This is a warning from the CCTV camera system.<br/><br/><strong style="font-weight: bold; color: #BD362F; font-size: 18px;">' . $warning . '</strong><br/><p style="text-align: center; font-size: 18px; font-weight: bold;"><a href="' . mysql_result(mysql_query("SELECT site FROM cctvup_settings WHERE id=1 LIMIT 1;"),0) .'">Check site.</a></p>Regards,<br/>' . mysql_result(mysql_query("SELECT regardsname FROM cctvup_settings WHERE id=1 LIMIT 1;"),0) .'.</p>';
				
				$mail->Subject = $subject;
				$mail->MsgHTML($message = email_template($message));
				$mail->AddAddress($to);
				
				if($mail->Send()) {
				    $insertsql="INSERT INTO cctvup_new (status) VALUES ('offline email success');";
					mysql_query($insertsql, $conn);
				} else {
				    $insertsql="INSERT INTO cctvup_new (status) VALUES ('offline email fail: $mail->ErrorInfo');";
					mysql_query($insertsql, $conn);
					//echo "Mailer Error: " . $mail->ErrorInfo;
				}
			}
		}
		else {
			if($laststatus=="offline"){
			
				require_once('../mail/new/mail.cw.php');
				
				$to = mysql_result(mysql_query("SELECT toemail FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				$tofirstname = mysql_result(mysql_query("SELECT emailfirstname FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				$from = mysql_result(mysql_query("SELECT fromemail FROM cctvup_settings WHERE id=1 LIMIT 1;"),0);
				
				$subject = mysql_result(mysql_query("SELECT notificationsubject FROM cctvup_settings WHERE id=1 LIMIT 1;"),0) . " (" . date('l jS \of F Y g:i:s A') . ")";
				
				$message = 'Hi ' . $tofirstname . ',<br/>This is a notification from the CCTV camera system.<br/><br/><strong style="font-weight: bold; color: #51A351; font-size: 18px;">The CCTV cameras are back online.</strong><br/><p style="text-align: center; font-size: 18px; font-weight: bold;"><a href="' . mysql_result(mysql_query("SELECT site FROM cctvup_settings WHERE id=1 LIMIT 1;"),0) .'">Check site.</a></p>Regards,<br/>' . mysql_result(mysql_query("SELECT regardsname FROM cctvup_settings WHERE id=1 LIMIT 1;"),0) .'.</p>';
				
				$mail->Subject = $subject;
				$mail->MsgHTML($message = email_template($message));
				$mail->AddAddress($to);
				
				if($mail->Send()) {
				    $insertsql="INSERT INTO cctvup_new (status) VALUES ('online email success');";
					mysql_query($insertsql, $conn);
				} else {
				    $insertsql="INSERT INTO cctvup_new (status) VALUES ('online email fail: $mail->ErrorInfo');";
					mysql_query($insertsql, $conn);
				}
			}
			//Online without email
			else if($laststatus=="check"){
			
			    $insertsql="INSERT INTO cctvup_new (status) VALUES ('online email not required');";
				mysql_query($insertsql, $conn);
			}
		}
		
		
	}
	else{
		 echo "Invalid Code";
	}
?>

