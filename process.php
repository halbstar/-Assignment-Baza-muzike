<?php
include "dblogin.php";
include "classes.php";

//PRETRAGA
//ako postoji nesto u get. isarray ne funkcionise u ovom slucaju
if(count($_GET)>0)
{	
	//ekstrahujemo sve promenljive koji nosi GET
	extract($_GET);
	//upit za naslove kolona tabele
	$sql=mysqli_query($con,"SELECT *   FROM `collection`");
	
	//mozda nije najbolje resenje, ali jedino koje je uspelo da resetuje kursor u mysqli_fetch_assoc (dva paralelna queryja)
	//pretraga bi takodje trebala da se rafinise, ali ova daje solidne rezultate za bazu ovog tipa
	$sql1=mysqli_query($con,"SELECT *   
		FROM `collection` 
		where 
		Artist like '%$Artist%' and 
		Album like '%$Album%' and
		MB like '%$MB%' and
		Zanr like '%$Zanr%' and
		Disk like '%$Disk%' and
		Trajanje like '%$Trajanje%'");
	
	echo "<table class=\"table table-striped\">";
	//funkcija koja ispisuje tabelu. potrebno je uneti $sql upit iz funkcije mysqli_query(). takodje, treba dodati da li od tabele trazimo naslove ili podatke. drugi argument je "key" za naslove ili "value" podatke.
	//<th> formatiranje zbog $key="key"
	Html::mySqliTable($sql,"key");
	
	//<td> formatiranje zbog $key="value"
	Html::mySqliTable($sql1,"value");
	echo "</table>";
}
//BRISANJE PODATAKA
//slicno kao pretraga. ovoga puta metod prenosa je post. Ideja je da se rafinisanjem pretrage dolazi do onoga sto se brise
else if (count($_POST)>0)
{
	extract($_POST);
	//u slucaju brisanja dodata je jos jedna kontrolna varijabla $del. Ako je nema prelazimo na insert.
	if(isset($del)){
		$sql="delete 
		from collection 
		where 
    	Artist like '%$Artist%' and 
    	Album like '%$Album%' and
    	MB like '%$MB%' and
    	Zanr like '%$Zanr%' and
    	Disk like '%$Disk%' and
    	Trajanje like '%$Trajanje%'";
		if (!mysqli_query($con,$sql))
		  {
		  die('Error: ' . mysqli_error($con));
		  }
		  //poruka koja se vraca ako je brisanje proslo dobro
			echo "
		  	<div class=\"bs-example\">
			    <div class=\"alert alert-danger

			    \">
			        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
			        <strong>Nadam se da ste dobro postupili!</strong> <br>Proverite da li su podaci obrisani ponovnim pritiskom na dugme <strong>Pretraga</strong>
			    </div>
			</div>";
	}

	//UNOS NOVIH PODATAKA
	//unosi se po principu sta je stiglo
	else
	{
		$sql="Insert into collection (Artist, Album, MB, Zanr, Disk, Trajanje) values (\"$Artist\", \"$Album\", \"$MB\", \"$Zanr\", \"$	Disk\", \"$Trajanje\")";
		
		if (!mysqli_query($con,$sql))
		  {
		  die('Error: ' . mysqli_error($con));
		  }
		  //poruka o uspesnom unosu
			echo "
		  	<div class=\"bs-example\">
			    <div class=\"alert alert-success\">
			        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
			        <strong>Čestitamo!</strong> Uspešno ste uneli podatke u bazu. <br>Proverite da li su podaci uneti ponovnim pritiskom na dugme <strong>Pretraga</strong>
			    </div>
			</div>";
	}
	
}



?>