
<?php // header.php
include "functions.php";
if (isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
	$loggedin = TRUE;
}
else $loggedin = FALSE;

echo "<html><head><title>$appname";
if ($loggedin) echo " ($user)";

echo "</title></head><body><font face='verdana' size=4>";
?>

<html>
<head>
<title>HTML Test</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
		.head {color:white; text-align:center;background:#556B2F;height:130px}
		.page {color:#990000; text-align:center;background:white}
		.main {color:#008080; text-align:center;background:white;height: 100%;text-align:center}
		.footer {clear: both;position: relative;z-index: 10;height: 3em;margin-top: -3em}
		.footer1 {position: fixed;bottom: 0;left: 0;right: 0;height: 50px}
		.leftnav {color:#008080; text-align:center;background:#9ACD32;float:left;width:220px; border-right: 2px solid black;
		height: 100%;}
		.content {color:#008080; text-align:center;background:white}
	</style>

<title>Shuttle Booking Management Website</title>
<script type="text/javascript">
function checkCookie(){
	var cookieEnabled=(navigator.cookieEnabled)? true : false   
	if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled){ 
		document.cookie="testcookie";
		cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? true : false;
	}
	return (cookieEnabled)?true:showCookieFail();
}

function showCookieFail(){
	document.write("<style type="text/css"> .page1 {display:none;}</style><div class="noscriptmsg"><center><p><h3>You do not have cookies enabled. Access to the site blocked for it may not work properly!</h3></p></center></div>");
}
checkCookie();
</script>
<!-- check if java script is disabled and block the site content if so -->
<noscript>
	<style type="text/css">
        	.page1 {display:none;}
	</style>
	<div class="noscriptmsg">
		<center><p><h3>You don"t have javascript enabled. Access to the site blocked for it may not work properly!</h3></p></center>
	</div>
</noscript>

<script type="text/javascript">
function hideHint(box)
{
	document.getElementById(box).style.visibility="hidden";
}
function showHint(box)
{
	document.getElementById(box).style.visibility="visible";
}
</script>
</head>

<body>
  <div id="logo" class="head" align=center>			
				<font color=white><h1>Well Come for Booking a Shuttle</h1></font>
</div><!-- logo -->
<div class="page1">
<hr size="5"/>
<div class="page">
	<div class="leftnav"><br/>							
	<?php
	if ($loggedin)
	{
		echo "<b>$user</b>:<br/>";
		echo "<br><br><br><br><br><br><br><br><br><br>";
	?>						
		<a href="booking.php">Book here</a><br/>
		<a href="logout.php">Logout</a><br/>
	<?php
	}  
	else { ?>
		<a href="index.php" > <span style="font-weight:bold">HOME</span></a><br/><br/>				   
		<a href="login.php" > <span style="font-weight:bold">LOG IN</span></a><br/><br/>
		<a href="signup.php" ><span style="font-weight:bold">SIGN UP</span> </a><br/><br/>
	<?php
	} ?>
	</div>
		
	<div id="content" class="content">

		  
