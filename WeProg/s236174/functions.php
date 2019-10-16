<?php // functions.php

$dbhost  = "localhost";    
$dbname  = "s236174"; 
$dbuser  = "s236174";     
$dbpass  = "inedenle";    
$appname = "Shuttle_booking"; 

$conn=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
mysqli_select_db($conn,$dbname);
if(!$conn) 
die(mysql_error());

function queryMysql($query,$conn)
{
	$result = mysqli_query($conn,$query) or die(mysql_error());
	return $result;
}

function destroySession()
{
	$_SESSION=array();
	
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	    setcookie(session_name(), "", time()-2592000, "/");
		
	session_destroy();
}

function sanitizeString($string)
{
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = mysql_real_escape_string($string);
    return $string;

}

function showProfile($user,$conn)
{
		
	$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
	
	if (mysqli_num_rows($conn,$result))
	{
		$row = mysqli_fetch_row($result);
		echo stripslashes($row[1]) . "<br clear=left /><br />";
	}
}
?>
