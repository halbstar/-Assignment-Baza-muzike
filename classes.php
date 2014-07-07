<?php
class Html
{
	public static $name;
	public static $class;

	function __construct()
	{
		$this->name=self::$name;
		$this->class=self::$class;
	}

	#ispisuje div. 
	public static function Div($name, $class){
		return "<div class=\"$class\">$name</div>";
	}

	public static function InputText($name, $class){
		return "<input type=\"text\" class=\"$class\" name=\"$name\" placeholder=\"$name\">";
	}

	public static function span($name, $class){
		return "<span class=\"$class\">$name</span>";
	}
	public static function button($name,$class,$additionalAtt)
	{
		return "<button type=\"submit\" class=\"$class\" $additionalAtt >$name</button>";
	}
	


	//funkcija koja ispisuje tabelu. potrebno je uneti $sql upit iz funkcije mysqli_query(). takodje, treba dodati da li od tabele trazimo naslove ili podatke. drugi argument je "key" za naslove ili "value" podatke.
	public static function mySqliTable($sql,$key)
	{		
		while($row = mysqli_fetch_assoc($sql))			
		  {		  	
		  	echo "<tr>";
			foreach ($row as $head=>$data) 
			{
				if($key=="key")
				{
					echo "<th>$head</th>";							
				}
				else if($key=="value")
				{
					echo "<td>$data</td>";
				}			
			}
			echo "</tr>";		
			if($key=="key") break;
		  }
	}


	public static function badges($sql,$class)
	{
		while($row = mysqli_fetch_array($sql))			
		{		  	
		  	echo "<a href=\"#\" class=\"$class\">
      		<span class=\"badge\">$row[1]</span>
      		$row[0]
      		</a>";
		}
	}


		

	


}