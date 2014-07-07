<?php 

//Connect

$con=mysqli_connect("localhost","root","","bazamuzike");
// Check connection
if (mysqli_connect_errno())
  {
  echo "<div class=\"alert alert-warning\"><p>Ako to još uvek niste učinili sada je pravi trenutak da</p> <button type=\"submit\" class=\"btn btn-primary\" onclick=\"load('true'); return false;\">Napravite bazu sa podacima</button>
		<p class=\"text-muted\">Očekuju se podrazumevana podešavanja za bazu: 'localhost', 'root', ' '.<br> Vrednosti možete promeniti u dblogin.php i loadDB.php</p> 
  		</div> ";
  }
//set charset
mysqli_set_charset($con, "utf8");




 ?> 
 