<?php 
session_start(); 
if($_SERVER["SERVER_PORT"] !== 443 && (empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] === "off")) {
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit;
}
include "sessions.php";
include("header.php"); 
mysqli_query($conn, "BEGIN");
$stat=0;
$query="UPDATE booking SET status='".$stat."'";
queryMysql($query, $conn);
if (isset($_POST["submit"])) 
{	

	$departure = $_POST["departure"];
	$destination = $_POST["destination"];
	$num_travllers = $_POST["traveller"];

	if($departure!="Other" && $destination!="Other"){
		$status=0;
	}

	if($departure=="Other" && $destination!="Other"){
		$departure = $_POST["other_dep"];
		$status=1;
	}	

	if($departure!="Other" && $destination=="Other"){
		$destination = $_POST["other_dest"];
		$status=2;
	}

	if($departure=="Other" && $destination=="Other"){
		$departure = $_POST["other_dep"];
		$destination = $_POST["other_dest"];
		$status=3;
	}

	$destination = strtoupper($destination);
	$departure = strtoupper($departure);
	
	$shuttle_capacity=14;
	$space_available=1;

	if (strcmp($destination,$departure)){

		$query = "SELECT Departure, Destination, SUM(Num_of_travellers) FROM booking WHERE(Departure >= '$departure' and Destination <= '$destination') Group By Departure, Destination Order By Destination asc, Departure asc";

		$Aptrequest = mysqli_query($conn, $query);
		while($record=mysqli_fetch_array($Aptrequest)){
	
			if($record["SUM(Num_of_travellers)"] + $num_travllers > $shuttle_capacity){
				$space_available=0;
			}
		}

		$query = "SELECT max(id) FROM booking";
		$max = mysqli_fetch_array(queryMysql($query,$conn));
		$maxinID = $max[0];
		$newid=$maxinID+1;

		if($num_travllers > 0 && $space_available == 1 && $num_travllers <= $shuttle_capacity){

			$query = "INSERT INTO `booking` (`ID`, `Email`, `Departure`, `Destination`, `Num_of_travellers`, `status`) VALUES ('".$newid."', '".$user."', '".$departure."', '".$destination."', '".$num_travllers."', '".$status."')";
			mysqli_query($conn, $query);

			$query = "SELECT max(id) FROM places";
			$max = mysqli_fetch_array(queryMysql($query,$conn));
			$maxinID = $max[0];
			$newid=$maxinID+1;

			if($status==1){

				$query = "INSERT INTO `places` (`ID`, `Place`) VALUES ('".$newid."', '".$departure."')";
				mysqli_query($conn, $query);
				#$departure = $_POST["other_dep"];
				#$status=1;

			}	

			if($status==2){
				$query = "INSERT INTO `places` (`ID`, `Place`) VALUES ('".$newid."', '".$destination."')";
				mysqli_query($conn, $query);
				#$destination = $_POST["other_dest"];
				#$status=2;
			}

			if($status==3){						
				$query = "INSERT INTO `paces` (`ID`, `Place`) VALUES ('".$newid."', '".$departure."')";
				mysqli_query($conn, $query);
		
				$newid=$newid+1;
				$query = "INSERT INTO `places` (`ID`, `Place`) VALUES ('".$newid."', '".$destination."')";
				mysqli_query($conn, $query);

				#$departure = $_POST["other_dep"];
				#$destination = $_POST["other_dest"];
				#$status=3;
			}


			header("Refresh:0; https://localhost/s236174/index.php");
		}

		else if($num_travllers <= 0){

			echo "Invalid number, please try again!";
		}	

		else{
			echo "It is more than the capacity of a Shuttle!";
		}

		
	}
	else 
		echo "Enter Departure and Destination Places Correctly!";
}

mysqli_query($conn, "COMMIT");


?>
		<h2>Book Your Trip</h2>
<form method="post" name="newbooking" onsubmit="return formvalidation();">  

<?php
	$query = "SELECT Place FROM places Order By Place asc";
	$counter=1;
	$Aptrequest = mysqli_query($conn, $query );
?>
	Departure:<select name="departure" onchange="showfield(this.options[this.selectedIndex].value)">
<?php
	
		while($record=mysqli_fetch_array($Aptrequest)){
				echo "<option value='".$record["Place"]."'>" . $record["Place"] . "</option>";
			
		}
		echo "<option value='"."Other"."'>" . "Other" . "</option>";
?>
	</select>
	<div id="div1" name="div1"></div>
	<br><br>

<?php
	$query = "SELECT Place from places Order By Place asc";
	$Aptrequest = mysqli_query($conn, $query );
?>

	Destination:<select name="destination" onchange="showfield2(this.options[this.selectedIndex].value)">
<?php

		while($record=mysqli_fetch_array($Aptrequest)){
			
				echo "<option value='".$record["Place"]."'>" . $record["Place"] . "</option>";
				
			$counter=0;
				
	
		}
		echo "<option value='"."Other"."'>" . "Other" . "</option>";
?>
	</select>
	<div id="div2" name="div2"></div>
	<br><br>
	Num_of_travellers: <input type="text" name="traveller">
	<br><br>
	<input type="submit" name="submit" value="Submit">  
</form>
<script type="text/javascript">
function formvalidation(){
	
	var check_num= /^[0-9]*$/;	
	var trv=document.forms["newbooking"]["traveller"].value;
		if(trv==""){		
		alert("Enter number of travellers");
		document.newbooking.traveller.focus();
		return false;
	}
	if (!check_num.test(trv)){
		alert("Enter valid number of travellers consisting of digits up to 2");
		document.newbooking.traveller.focus();
		return false;	
	}

	var check_dep="/^[a-zA-Z]*$/";
	
	var dep=document.forms["newbooking"]["div1"]["other_dep"].value;
		if(dep==""){		
		alert("Enter Departure");
		document.newbooking.div1.other_dep.focus();
		return false;
	}
	if (!check_dep.test(dep)){
		alert("Enter valid Departure composed of alphabets only");
		document.newbooking.div1.other_dep.focus();
		return false;	
	}

	var check_dest="/^[a-zA-Z]*$/";
	
	var dest=document.forms["newbooking"]["div2"]["other_dest"].value;
		if(dest==""){		
		alert("Enter Destination composed of alphabets only");
		document.newbooking.div2.other_dest.focus();
		return false;
	}
	if (!check_dest.test(dest)){
		alert("Enter valid Destination composed of alphabets only");
		document.newbooking.div2.other_dest.focus();
		return false;	
	}
}
</script>
<script type="text/javascript">
function showfield(name){
  if(name=='Other')document.getElementById('div1').innerHTML='Other: <input type="text" pattern="[A-Za-z]+" name="other_dep" />';
  else document.getElementById('div1').innerHTML='';
}
</script>
<script>
function showfield2(name){
  if(name=='Other')document.getElementById('div2').innerHTML='Other: <input type="text" pattern="[A-Za-z]+" name="other_dest" />';
  else document.getElementById('div2').innerHTML='';
}
</script>

<?php
include("footer.php"); 
?>
