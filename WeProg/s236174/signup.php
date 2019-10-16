<?php 
session_start(); 
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
</head>
<body>
<script type="text/javascript">
function FormValidation()
{
	var email=document.forms["reg"]["user"].value;
	if (email == null || email=="")
	{
		alert("No email!");
		document.reg.user.focus();
		return false;
	}

	var x=document.forms["reg"]["user"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		alert("Please enter a valid e-mail address!");
		document.reg.user.focus() ;
		return false;
	}
 
	var pwd=document.forms["reg"]["pass"].value;
	if (pwd== null || pwd=="")
	{
		alert("No passwords");
		document.reg.pass.focus();
		return false;
	}
	var check_pass = /^(?=.*[a-z])((?=.*[A-Z])||(?=.*\d))\w{1,}$/;
	if (!check_pass.test(pwd)) {
		alert("Please enter the correct password.");
		document.reg.pass.focus();
		return check_pass.test(str);
		//return false;
	}
}
</script>

<?php include("header.php"); ?>
	<form method="post" name="reg" onsubmit="return FormValidation();">
	<h2>Signup for Shuttle Transportation by using Username and Password</h2>
	<br><br><br>
	<table>
	<tr><td></td><td></td><td>Username</td><td><input type="text" id="usrname" name="user" placeholder="Enter Your E-mail" required /></td><tr />
	<tr><td></td><td></td><td>Password</td><td><input type="password" id="pass" name="pass" pattern="(?=.*[a-z])((?=.*[A-Z])||(?=.*\d)).{1,}" placeholder="Enter Your Password" required /></td><tr />
	<tr><td></td><td></td><td></td><td><input type= "submit" name ="signup" value="SIGNUP"></td>
	</table>

	</form>

<?php

$error = $user = $pass ="";
if (isset($_SESSION["user"])) destroySession();

	if (isset($_POST["signup"]))
	{
		//$user = sanitizeString($_POST["user"]);
		//$pass = sanitizeString($_POST["pass"]);
		$user = $_POST["user"];
		$pass = $_POST["pass"];

		if(filter_var($user, FILTER_VALIDATE_EMAIL)==true){
			if ($user == "" || $pass == "")
			{
				echo "You haven't filled all fields. <br>";
			}
			else
			{
				$query = "SELECT * FROM travellers WHERE email='".$user."'";
	
				if (mysqli_num_rows(queryMysql($query,$conn)))
				{
					//$error = "This user is already exists!<br>";
					echo '<script language="javascript">';
					echo 'alert("This user is already exists!")';
					echo '</script>';
					$script= $_SERVER["PHP_SELF"] ;
					die("<h4>$error</h4>Please <a href=\"$script\">Sign up again with a different email!</a>");
				}
				else
				{
					$query = "INSERT INTO travellers VALUES('".$user."', '".$pass."')";
					queryMysql($query, $conn);
					echo '<script language="javascript">';
					echo 'alert("Account Created!")';
					echo '</script>';
					//die("<h4>Account Created!</h4>Now, you can proceed. . .");
				}
			}
		}
		else
			echo "The email address you entered is not valid.";  	
	}
?>
</body>
</html>

<?php
	include("footer.php"); 
?>
