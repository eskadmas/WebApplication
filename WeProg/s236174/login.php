<?php 
session_start();
?>
<?php
 
if($_SERVER["SERVER_PORT"] !== 443 &&(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] === "off")) {
header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
exit;
}

$error = $user = $pass = "";
include("header.php"); 
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	input {
		width: 100%;
		padding: 12px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
	}

	/* Style the submit button */
	input[type=submit] {
		background-color: #4CAF50;
		color: white;
	}

	/* Style the container for inputs */
	.container {
		background-color: #f1f1f1;
		padding: 20px;
	}

	/* The message box is shown when the user clicks on the password field */
	#message {
		display:none;
		background: #f1f1f1;
		color: #000;
		position: relative;
		padding: 20px;
		margin-top: 10px;
	}

	#message p {
		padding: 10px 35px;
		font-size: 18px;
	}
</style>

<h2>Travellers Login Page</h2>
</head>
<body>
<br><br><br><br>
<form method="post" > 
	<table>
	<tr><td></td><td></td><td>Username</td><td><input type = "text" id="usrname" name="user" placeholder="Enter Your E-mail" required /></td></tr>
	<tr><td></td><td></td><td>Password</td><td><input type ="password" id="pass" name="pass" pattern="(?=.*[a-z])((?=.*[A-Z])||(?=.*\d)).{1,}" placeholder="Enter Your Password" required /></td><tr />
	<tr><td></td><td></td><td></td><td><input type= "submit" name ="login" value="LOGIN"></td></tr>
	</table>

</form>
<?php

if (isset($_POST["login"]))
{
	$user = $_POST["user"];
	$pass = $_POST["pass"];


	if ($user == "" || $pass == "")
	{
		echo "Please enter values in all fields<br />";
	}
	else{
		queryMysql("BEGIN",$conn);
		$query = "SELECT email, pass FROM travellers
				  WHERE email='".$user."' AND pass='".$pass."'";
				  
		if (mysqli_num_rows(queryMysql($query,$conn)) == 0)
		{
			$error = "Username/Password invalid<br />";
			echo '<script language="javascript">';
			echo 'alert("You have not enter the correct user name or password.")';
			echo '</script>';
			//echo "You are not registered yet.";
		}

		else
		{
			$_SESSION["user"] = $user;
			$_SESSION["pass"] = $pass;
			$_SESSION["time"]=time();
			echo "Logged in";
			header("Location:index.php");

			die();
			
		}
	}
queryMysql("COMMIT",$conn);
}

?>

<?php 
include("footer.php"); 
?>

