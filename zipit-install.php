<?php
###############################################################
# Zipit Backup Utility
###############################################################
# Developed by Jereme Hancock for Cloud Sites
# Visit http://zipitbackup.com for updates
###############################################################

// Set the default timezone
date_default_timezone_set('America/Chicago');
$date = date("M-d-Y-h:i:s");

// check for previous installation and back it up
if (is_dir("zipit")) {
   shell_exec("mv zipit zipit_backed_up_$date");
   $previous_install = "true";
}


// determine datacenter for storage
$string = $_SERVER["PHP_DOCUMENT_ROOT"];

$pos = strpos($string, "dfw");
   if ($pos == false) {
      $datacenter = "ORD";
    } 
    else {
      $datacenter = "DFW";
    }

// define url -- will check for test link and remove extra characters if installing from test link
$server = $_SERVER['SERVER_NAME'];

   if (strpos($server,'websitetestlink') !== false) {
      $split = explode(".php",$server,2);
      $url = $split[0];
      $url = str_replace("www.", "", $url);
    } 
    else {
      $url = $_SERVER['SERVER_NAME'];
      $url = str_replace("www.", "", $url);
    }

// define backup path
    $path = getcwd();

// generate hash for auto option
$hash = substr(hash("sha512",rand()),0,12); // Reduces the size to 12 chars

if (isset($_POST["Submit"])) {

// grab the latest version of zipit from github
shell_exec('wget https://github.com/jeremehancock/zipit-backup-utility/archive/master.zip --no-check-certificate -O zipit.zip; unzip zipit.zip; mv zipit-backup-utility-master* zipit; rm zipit.zip');

$string = '<?php 
###############################################################
# Zipit Backup Utility
###############################################################
# Developed by Jereme Hancock for Cloud Sites
# Visit http://zipitbackup.com for updates
############################################################### 

// Zipit Backup Utility Login Credentials
$zipituser = "'. $_POST["zipituser"]. '";
$password = "'. $_POST["password"]. '";

// Cloud Files API -- Required!!
$username = "'. $_POST["username"]. '";
$key = "'. $_POST["key"]. '";

// Datacenter
$datacenter = "'. $_POST["datacenter"]. '";

// URL
$url = "'. $_POST["url"]. '";

// Site path
$path = "'. $_POST["path"]. '";

// Zipit Auth Hash
$auth_hash = "'. $_POST["hash"]. '";

// Usage Feedback
$usage_feedback = "'. $_POST["usage"]. '";

?>';

$fp = fopen("./zipit/zipit-config.php", "w");
fwrite($fp, $string);
fclose($fp);

// remove zipit install file
shell_exec("rm ./zipit-install.php");

echo '<script type="text/javascript">';
echo 'alert("Zipit Backup Utility installed successfully.\n\nYou will now be redirected to the Zipit login page.")';
echo '</script>';

//redirect to login
echo "<script>";
echo "location.href='./zipit/index.php'";
echo "</script>";

}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Zipit Backup Utility -- Install</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<style>

* {
	margin:0;
	padding:0;
}

body {
	font: 1em "Arial", sans-serif;
   background:#ccc;background: url(https://raw.github.com/jeremehancock/zipit-backup-utility/master/images/background.jpg) no-repeat center center fixed; 
   -webkit-background-size: cover;
   -moz-background-size: cover;
   -o-background-size: cover;
   background-size: cover;
   background-color:#7397a7;
}

h2 { 
   margin-bottom:10px;
   font-family: 'Source Sans Pro', sans-serif;
}

h5 { 
	font-size:1.5em;
	margin-bottom:0px;
   font-family: 'Source Sans Pro', sans-serif;
}

h4 { 
	font-size:1.1em;
	margin-bottom:0px;
   font-family: 'Source Sans Pro', sans-serif;
}

#wrapper {
	width:720px;
	margin:40px auto 0;
}

#wrapper h1 {
	color:#2E2E2E;
	margin-bottom:10px;
   font-family: 'Source Sans Pro', sans-serif;
}

#wrapper a {
	font-size:1.2em;
	color:#108DE3;
	text-decoration:none;
	text-align:center;
}

#tabContainer {
	width:700px;
	padding:15px;
	background-color:#2e2e2e;
	-moz-border-radius: 5px;
	border-radius: 5px; 
}

#tabs {
	height:30px;
	overflow:hidden;
}

#tabs > ul {
	font: 1em;
	list-style:none;
}

#tabs > ul > li {
	margin:0 2px 0 0;
	padding:7px 10px;
	display:block;
	float:left;
	color:#FFF;
	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
	-moz-border-radius-bottomright: 0px;
	-moz-border-radius-bottomleft: 0px;
	border-top-left-radius:5px;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 0px;
	border-bottom-left-radius: 0px; 
	background: #C9C9C9; /* old browsers */
	background: -moz-linear-gradient(top, #0C91EC 0%, #257AB6 100%); /* firefox */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#0C91EC), color-stop(100%,#257AB6)); /* webkit */
}

#tabs > ul > li:hover {
	background: #FFFFFF; /* old browsers */
	background: -moz-linear-gradient(top, #FFFFFF 0%, #F3F3F3 10%, #F3F3F3 50%, #FFFFFF 100%); /* firefox */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FFFFFF), color-stop(10%,#F3F3F3), color-stop(50%,#F3F3F3), color-stop(100%,#FFFFFF)); /* webkit */
	cursor:pointer;
	color: #333;
}

#tabs > ul > li.tabActiveHeader {
	background: #FFFFFF; /* old browsers */
	background: -moz-linear-gradient(top, #FFFFFF 0%, #F3F3F3 10%, #F3F3F3 50%, #FFFFFF 100%); /* firefox */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FFFFFF), color-stop(10%,#F3F3F3), color-stop(50%,#F3F3F3), color-stop(100%,#FFFFFF)); /* webkit */
	cursor:pointer;
	color: #333;
}

#tabscontent {
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
	-moz-border-radius-bottomright: 5px;
	-moz-border-radius-bottomleft: 5px;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
	border-bottom-left-radius: 5px; 
	padding:10px 10px 25px;
	background: #FFFFFF; /* old browsers */
	background: -moz-linear-gradient(top, #FFFFFF 0%, #FFFFFF 90%, #e4e9ed 100%); /* firefox */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FFFFFF), color-stop(90%,#FFFFFF), color-stop(100%,#e4e9ed)); /* webkit */
	margin:0;
	color:#333;
}

button.css3button {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #171717;
	padding: 10px 20px;
	background: -moz-linear-gradient(top, #e6e6e6 0%, #a3a3a3);
	background: -webkit-gradient(linear, left top, left bottom, from(#e6e6e6), to(#a3a3a3));
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	border-radius: 6px;
	border: 1px solid #d6d6d6;
	-moz-box-shadow:0px 0px 0px rgba(000,000,000,0), inset 0px 0px 0px rgba(255,255,255,0);
	-webkit-box-shadow:0px 0px 0px rgba(000,000,000,0), inset 0px 0px 0px rgba(255,255,255,0);
	box-shadow:0px 0px 0px rgba(000,000,000,0), inset 0px 0px 0px rgba(255,255,255,0);
	text-shadow:0px 0px 0px rgba(107,107,107,0), 0px 1px 0px rgba(255,255,255,0.3);
}

input { 
   border: 1px solid #818185; 
   -moz-border-radius: 5px;
   border-radius: 5px;
   height:30px;
   width:170px;
   padding-left:8px;
   padding-right:8px;
}

input[type=checkbox] {  
   border: 1px solid #818185; 
   -moz-border-radius: 5px;
   border-radius: 5px;
   height:20px;
   width:30px;
   padding-right:8px; 
   position:relative;
   top:2px;  
   margin-right:5px;
}  

.logs {
    -moz-border-radius-topleft: 5px; 
    border-top-left-radius: 5px;
    -moz-border-radius-bottomleft: 5px; 
    border-bottom-left-radius: 5px;
    -moz-border-radius-topright: 5px; 
    border-top-right-radius: 5px;
    -moz-border-radius-bottomright: 5px; 
    border-bottom-right-radius: 5px;
    background: #000000;
    color: #ffffff;
    padding-left: 14px; 
    width: 650px; 
    }

.logs_frame {
    -moz-border-radius-topleft: 5px; 
    border-top-left-radius: 5px;
    -moz-border-radius-bottomleft: 5px; 
    border-bottom-left-radius: 5px;
    -moz-border-radius-topright: 5px; 
    border-top-right-radius: 5px;
    -moz-border-radius-bottomright: 5px; 
    border-bottom-right-radius: 5px;
    background: #000000;
    color: #ffffff;
    width:100%; 
    height:400px;
}

.files {
    -moz-border-radius-topleft: 5px; 
    border-top-left-radius: 5px;
    -moz-border-radius-bottomleft: 5px; 
    border-bottom-left-radius: 5px;
    -moz-border-radius-topright: 5px; 
    border-top-right-radius: 5px;
    -moz-border-radius-bottomright: 5px; 
    border-bottom-right-radius: 5px;
    background: #000000;
    color: #ffffff;
    padding-left: 14px; 
    width: 650px; 
}

.files_frame {
    -moz-border-radius-topleft: 5px; 
    border-top-left-radius: 5px;
    -moz-border-radius-bottomleft: 5px; 
    border-bottom-left-radius: 5px;
    -moz-border-radius-topright: 5px; 
    border-top-right-radius: 5px;
    -moz-border-radius-bottomright: 5px; 
    border-bottom-right-radius: 5px;
    background: #000000;
    color: #ffffff;
    width:100%; 
    height:200px;
}

.dbs {
    -moz-border-radius-topleft: 5px; 
    border-top-left-radius: 5px;
    -moz-border-radius-bottomleft: 5px; 
    border-bottom-left-radius: 5px;
    -moz-border-radius-topright: 5px; 
    border-top-right-radius: 5px;
    -moz-border-radius-bottomright: 5px; 
    border-bottom-right-radius: 5px;
    background: #000000;
    color: #ffffff;
    padding-left: 14px; 
    width: 650px; 
}

.dbs_frame {
    -moz-border-radius-topleft: 5px; 
    border-top-left-radius: 5px;
    -moz-border-radius-bottomleft: 5px; 
    border-bottom-left-radius: 5px;
    -moz-border-radius-topright: 5px; 
    border-top-right-radius: 5px;
    -moz-border-radius-bottomright: 5px; 
    border-bottom-right-radius: 5px;
    background: #000000;
    color: #ffffff;
    width:100%; 
    height:200px;
}

.settings_frame {
    width:100%; 
    height:650px;
}

.settings input {
   border: 1px solid #818185; 
   -moz-border-radius: 5px;
   border-radius: 5px;
   height:30px;
   width:250px;
   padding-left:8px;
   padding-right:8px;
}

#logout {
   position:relative;
   float:right;
   padding-top:10px;
}

.dev_by {
   color: #708090;
   text-align:right;
   padding-top:10px;
}

#dev_by a{
	color:#FFF;
	text-decoration:none;
   font-size:16px;
}

.version_info {
   color: #6D6D6D;
   display:inline;
   font-size:.5em;
}

/* Styles for Tooltips */

.ui-tooltip, .arrow:after {
    background: #2E2E2E;
    border: 1px solid white;
}

.ui-tooltip {
    padding: 10px 20px;
    color: white;
    border-radius: 5px;
    font: 14px "Helvetica Neue", Sans-Serif;
    box-shadow: 0 0 7px black;
}

.arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -35px;
    bottom: -16px;
}

.arrow.top {
    top: -16px;
    bottom: auto;
}
  
.arrow.left {
    left: 20%;
}

.arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    tranform: rotate(45deg);
}

.arrow.top:after {
    bottom: -20px;
    top: auto;
}

#files_continuous {
   width:300px;
}

#files_daily {
   width:300px;
}

#databases_continuous {
   width:300px;
}

#databases_daily {
   width:300px;
}

.alldivs {
   display: inline-block;
   padding-right:20px;
}

.cause_fix {
   font-weight:bold;
   font-size:1.1em;
}
</style>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>
   $(function() {
      $( document ).tooltip({
         position: {
            my: "center bottom-20",
            at: "center top",
            using: function( position, feedback ) {
               $( this ).css( position );
               $( "<div>" )
               .addClass( "arrow" )
               .addClass( feedback.vertical )
               .addClass( feedback.horizontal )
               .appendTo( this );
            }
         }
      });
  });
</script>

<script>
   function removeSpaces(string) {
   return string.split(' ').join('');
   }
</script>

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic' rel='stylesheet' type='text/css'>

</head>
<body>
<div id="wrapper">
<h1>Zipit Backup Utility Installer</h1>
<div id="tabContainer">
<div id="tabscontent"><br/>
<div style="text-align:center">
<?php if ($previous_install == "true") {echo "<em><font color='red'>Your previous installation of Zipit has been renamed to zipit_backed_up_$date to preserve any modifications that you may have made to it. You can safely remove it once installation is complete.</font></em><br /><br />"; } ?>
<br />
<form action="" method="post" name="install" id="install">
<em>Enter a new username/password for Zipit</em><br /><br />
<p>
     Zipit Username:<br />
    <input name="zipituser" type="text" id="zipituser" value="" onblur="this.value=removeSpaces(this.value);" required> <img src="https://raw.github.com/jeremehancock/zipit-backup-utility/master/images/hint.png" title="This is the username for Zipit. Alphanumeric characters only!" />
</p>
<br />
<p>
    Zipit Password:<br />
    <input name="password" type="password" id="password" onblur="this.value=removeSpaces(this.value);" required> <img src="https://raw.github.com/jeremehancock/zipit-backup-utility/master/images/hint.png" title="This is the password for Zipit. Alphanumeric characters only!" />
</p>
<br />
<em>Enter your Rackspace&reg; username/API Key</em><br /><br />
<p>
    API Username:<br />
    <input name="username" type="text" id="username" onblur="this.value=removeSpaces(this.value);" required> <img src="https://raw.github.com/jeremehancock/zipit-backup-utility/master/images/hint.png" title="This is the username for your API access. This is the same username that you use to login to manage.rackspacecloud.com." />
</p>
<br />
<p>
    API Key:<br />
    <input name="key" type="password" id="key" onblur="this.value=removeSpaces(this.value);" required> <img src="https://raw.github.com/jeremehancock/zipit-backup-utility/master/images/hint.png" title="This is your API Key." />
</p>
<br />
<p>
    <input type="checkbox" name="usage" id="usage" value="allow" checked />Help make Zipit better by providing usage feedback. <a href="http://statcounter.com/about/cookies/" target="_blank">More info... <img src="https://raw.github.com/jeremehancock/zipit-backup-utility/master/images/open_in_new_window.png"/></a>
</p>

<p>
    <input name="hash" type="hidden" id="hash" value="<?php echo $hash ?>" onblur="this.value=removeSpaces(this.value);" required>
</p>

<p>
    <input name="datacenter" type="hidden" id="datacenter" value="<?php echo $datacenter ?>" onblur="this.value=removeSpaces(this.value);" required>
</p>

<p>
    <input name="url" type="hidden" id="url" value="<?php echo $url ?>" onblur="this.value=removeSpaces(this.value);" required>
</p>
<p>
    <input name="path" type="hidden" id="path" value="<?php echo $path ?>" onblur="this.value=removeSpaces(this.value);" required>
</p>
<p>

<br />
<font color="red"><em>By installing you are agreeing to the terms of the GPL License! See: <a href="http://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank">GPL v3 <img src="https://raw.github.com/jeremehancock/zipit-backup-utility/master/images/open_in_new_window.png"/></a></em></font><br /><br />

<button type="submit" name="Submit" value="Install" class="css3button">Install</button>
</p>

</form>
<script>
   $('input').bind('keypress', function (event) {
      var regex = new RegExp("^[a-zA-Z0-9]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key) && key.charCodeAt(0) > 32) {
         event.preventDefault();
         return false;
      }
   });
</script>

</div>
</div><div class="dev_by" id="dev_by">Developed by: <a href="https://github.com/jeremehancock" target="_blank">Jereme Hancock</a></div></div>


</body>
</html>
