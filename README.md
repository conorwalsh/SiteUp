# SiteUp?

Description
-----------

SiteUp? is a php script and online control panel that sends an email if it can't reach a specified URL.

Installation
-----------

1. Download or clone this repository.
2. Setup a MySQL database using the SQL files in the MySQL folder.
3. Change the settings in the db.php file and in lib/dp.php in the web folder to connect to your MySQL server.
4. Upload all the files in the Web folder to your server.
5. Setup a cronjob to run the check.php file every 5 minutes. You can use the command:
```curl http://yourdomainhere.com/siteup/check.php?p=yourpassword```
6. Login to your system using the default password (siteup). **NOTE: This is an example control panel and the password system is not very secure, if you plan to use this system a proper authentication system should be implemented and the default password must be changed.**
7. From this page you can change the url of the site you are monitoring and the email information.

That should be it but if you run into any problems just send me an email (conor@conorwalsh.net).

<img height="300px" src="http://conorwalsh.net/img/siteup_screenshot.png" />

Credits
------

The web system interface is based on this template sb admin from <a href="http://startbootstrap.com/template-overviews/sb-admin/" target="_blank">Startbootstrap.com/template-overviews/sb-admin</a>.<br/>
The web system uses font awesome from <a href="http://fontawesome.io/" target="_blank">Fontawesome.io</a>.<br/>
Basic PHP mail script from <a href="http://online-code-generator.com/html-email-starter-script.php" target="_blank">Online-code-generator.com/html-email-starter-script.php</a>.

License (MIT)
------
Copyright (c) 2016 Conor Walsh 

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

Thanks
------

Thank you for taking the time to look at this project I hope that it is of use to you,<br/>
<img src="http://conorwalsh.net/sig.png" /><br/>
Conor Walsh.
