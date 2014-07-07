<?php
include "dblogin.php";
include "classes.php";


//funkcija koja ispisuje tabelu. potrebno je uneti $sql upit iz funkcije mysqli_query(). takodje, treba dodati da li od tabele trazimo naslove ili podatke. drugi argument je "key" za naslove ili "value" podatke.
extract($_GET);
$sql=mysqli_query($con,"SELECT *   FROM `collection`");
$sql1=mysqli_query($con,
	"SELECT mid, Artist,	Album,	MB,	Zanr,	Disk,	Trajanje  
	FROM `collection`  natural join `allin2` 
	where `Sve` like '%$search%'");

echo "<table class=\"table table-striped\">";
//<th> formatiranje zbog $key="key"
Html::mySqliTable($sql,"key");
//<td> formatiranje zbog $key="value"
Html::mySqliTable($sql1,"value");
echo "</table>";