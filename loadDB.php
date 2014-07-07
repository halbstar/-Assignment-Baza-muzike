<?php
$con=mysqli_connect("localhost","root","");
if($_GET['load']=='true')
{
	
	$sql = file_get_contents('bazamuzike0.sql');	
	if (!mysqli_multi_query($con,$sql))
	{
	 die('Error: ' . mysqli_error($con));
	}
	echo "
	 	<div class=\"bs-example\">
	    <div class=\"alert alert-success\">
	        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
	        <strong>Čestitamo!</strong><br> Uspešno ste napravili bazu BazaMuzike i popunili je podacima.<br>Možete započeti sa pretragama, unosima i brisanjima. <br><strong>Srećan rad.</strong>
	        <div style='padding-left:20px'><button type=\"submit\" onclick=\"location.reload()\"; class=\"btn btn-primary\">Osveži stranicu</button> </div>
	    </div>
		</div>";
}

else if ($_GET['load']=='false')
{
	$sql="DROP database bazamuzike";
	if (!mysqli_query($con,$sql))
	{
	 die('Error: ' . mysqli_error($con));
	}
	echo "
	 	<div class=\"bs-example\">
	    <div class=\"alert alert-danger\">
	        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
	        <strong>Bravo genije!</strong> Upravo si obrisao čitavu bazu!!! :/
	        <div style='padding-left:20px'><button type=\"submit\" onclick=\"location.reload()\"; id=\"reload\" class=\"btn btn-danger\">Osveži stranicu</button></div> 
	    </div>
		</div>";
}


?>