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

          		This script is used by the index page to update the email format settings in a MySQL
                database.
		  
---------------------------------------------- PAGE INFO END ----------------------------------------------*/

	include('db.php');
	
	$dbpass = mysql_result(mysql_query("SELECT dbpass FROM siteup_settings WHERE id=1 LIMIT 1;"),0);

	$warningsubject=mysql_real_escape_string($_POST['warningsubject']);
	
	$notificationsubject=mysql_real_escape_string($_POST['notificationsubject']);
	
	$warningoffline=mysql_real_escape_string($_POST['warningoffline']);
	
	$warninginvalid=mysql_real_escape_string($_POST['warninginvalid']);
	
	$warningelse=mysql_real_escape_string($_POST['warningelse']);
	
	$regardsname=mysql_real_escape_string($_POST['regardsname']);
	
	if(strlen($warningsubject)<1||strlen($notificationsubject)<1||strlen($warningoffline)<1||strlen($warninginvalid)<1||strlen($warningelse)<1||strlen($regardsname)<1){
		header("Location:index.php?emailformatchanged=blank&p=$dbpass");
	}
	else{		
		$sql="UPDATE siteup_settings SET warningsubject='$warningsubject', notificationsubject='$notificationsubject', warningoffline='$warningoffline', warninginvalid='$warninginvalid', warningelse='$warningelse', regardsname='$regardsname' WHERE id='1'";
		$result=mysql_query($sql);
		
		if($result){
			header("Location:index.php?emailformatchanged=true&p=$dbpass");
		}
		else {
			header("Location:index.php?emailformatchanged=false&p=$dbpass");
		}
	}
?>
