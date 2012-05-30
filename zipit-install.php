<?php
###############################################################
# Zipit Backup Utility
###############################################################
# Developed by Jereme Hancock for Cloud Sites
# Visit http://zipitbackup.com for updates
###############################################################

// grab the latest version of zipit from github
shell_exec('rm -rf zipit; wget https://github.com/jeremehancock/zipit/zipball/master --no-check-certificate -O zipit.zip; unzip zipit.zip; mv jeremehancock-zipit-* zipit; rm zipit.zip');

if (isset($_POST["Submit"])) {

$string = '<?php 
###############################################################
# Zipit Backup Utility
###############################################################
# Developed by Jereme Hancock for Cloud Sites
# Visit http://zipitbackup.com for updates
############################################################### 

// Zipit Backup Utility -- Be sure to change the password!!
$zipituser = "'. $_POST["zipituser"]. '";
$password = "'. $_POST["password"]. '";

// Cloud Files API -- Required!!
$username = "'. $_POST["username"]. '";
$key = "'. $_POST["key"]. '";

?>';

$fp = fopen("./zipit/zipit-config.php", "w");

fwrite($fp, $string);

fclose($fp);

// remove zipit install file
shell_exec("rm ./zipit-install.php");

//redirect to login
echo "<script>location.href='./zipit/zipit-files.php'</script>";

}

?>

<html>
<head>
  <title>Zipit Backup -- Install</title>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

  <style>
body {
height:100%;
background: #ddd;
margin-bottom: 1px;
}

    input { 

            border: 1px solid #818185; 
            -moz-border-radius: 15px;
            border-radius: 15px;
            height:30px;
            width:200px;
            padding-left:8px;
            padding-right:8px;
}
            
.wrapper{

        width:350px;
	position:absolute;
	left:50%;
	top:50%;
	margin:-225px 0 0 -195px;
        background-color:#eee;
        -moz-border-radius: 15px;
        border-radius: 15px;
        padding:20px;
       -moz-box-shadow: 5px 5px 7px #888;
       -webkit-box-shadow: 5px 5px 7px #888;
}

a {
color:#55688A;
}

h2 {
color:#55688A;
}


.head {
text-align:center;
font-family: Arial;
font-size:28px;
margin-bottom:10px;
}

  </style>

<script language="javascript" type="text/javascript">
function removeSpaces(string) {
 return string.split(' ').join('');
}
</script>

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>

<div class="wrapper">
<div class="head">Zipit Backup Utility</div>
  <div style="text-align:center">
<br />
<form action="" method="post" name="install" id="install">
<em>Enter a new username/password for Zipit</em>
<p>
     Backup Utility Username:<br />
    <input name="zipituser" type="text" id="zipituser" value="" onblur="this.value=removeSpaces(this.value);" required="required"> 
</p>

<p>
    Backup Utility Password:<br />
    <input name="password" type="password" id="password" onblur="this.value=removeSpaces(this.value);" required="required"> 
</p>
<br />
<em>Enter your Cloud Files username/API Key</em>
<p>
    Cloud Files Username:<br />
    <input name="username" type="text" id="username" onblur="this.value=removeSpaces(this.value);" required="required">
</p>

<p>
    Cloud Files API Key:<br />
    <input name="key" type="text" id="key" onblur="this.value=removeSpaces(this.value);" required="required">
</p>

<p>


<font color="red"><em>By installing the Zipit Backup Utility you are agreeing to the terms of the GPL License! See: <a href="http://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank">GPL v3</a></em></font><br /><br />
    <input type="submit" name="Submit" value="Install" style="background-color:#ccc; -moz-border-radius: 15px; border-radius: 15px; text-align:center; width:250px; color:#000; padding:3px;" onclick="alert( 'Zipit Backup Utility Installed Successfully!\n\nYou will now be redirected to the login page.' )">
</p>

</form>
<br />
<font size="1em">Developed by <a href="http://www.cloudsitesrock.com" target="_blank">CloudSitesRock.com</a> for Rackspace Cloud Sites</font>
</div></div>
</body>
</html>

