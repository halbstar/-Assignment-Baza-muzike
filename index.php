<!DOCTYPE html>
<html lang="sr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baza muzičkih albuma</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/muzColl.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    //modal - jquery plugin za konfirmaciju (funkcionalnost ajax-a je preneta na modal)
    $(document).ready(function(){
      $("#conf").click(function(){
        $("#myModal").modal('show');
      });
    });

    //modal - za potvrdu brisanja (funkcionalnost ajax-a je preneta na modal)
    $(document).ready(function(){
      $("#confDel").click(function(){
        $("#myModalDel").modal('show');
      });
    });


    //modal za brisanje citave baze
    $(document).ready(function(){
      $("#dbDel").click(function(){
        $("#myModaldbDel").modal('show');
      });
    });

    </script>

  </head>


  <body>
  <nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button onsubmit="return false;">
      <a class="navbar-brand" onclick="location.reload();" href="#">Baza Muzike</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <form class="navbar-form navbar-left" role="search" onsubmit="look(this.elements[0].value); return false;">
        <div class="form-group">
          <input type="text" class="form-control" id="search" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Opšta pretraga</button>
      </form>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<!-- main body -->
<div class="wrap">
 
  <!-- .left input -->
  
  <div class="left">
    <form  id="form"  method="GET" onsubmit="return false;">
 <?php
  //database connection with utf support
  echo "<div class='well'>";
  echo "<strong> Dobrodošli</strong><br>Ovo je aplikacija za pretragu muzičke baze<br>";
  @include "dblogin.php";
  include "classes.php";
  echo "</div>";
  //proveravamo da li baza postoji
  //if(strpos((string) $con,'Failed'))
  if(is_object($con))
  {
    

    //query koji pravi niz $nazivi koji ce ispisati nazive kolona koje se trebaju popuniti prilikom unosa u bazu
  $sql=mysqli_query($con,"SELECT *   FROM `collection`");

  //inicijalizacija $nazivi
  $nazivi=array();
  //assoc nam donosi key=>value niz. trenutno nam je potreban samo niz naslova columni
  //(obratiti paznju da smo index citaca tabele pomerili za jedan!!!)
  foreach(mysqli_fetch_assoc($sql) as $key=>$value) 
  {
    //preskacemo PK mID
    if ($key!='mID')
    //punimo matricu $nazivi
    array_push($nazivi, $key);
  }
  
  
  //pravimo loop koji ce uz pomoc static funkcija klase HTML napraviti text inpute za unos podataka u bazu
  //svaka funkcija ima oblika Funkcija(imeZaIspis, CSS-klasa)
  foreach ($nazivi as $value) {
    print(Html::Div(
      (
        //ukrasni span iz bootstrapa
        Html::span("@","input-group-addon").
        Html::InputText($value,"form-control")
      )
      ,"input-group"));
  }
  
  
  ?>
      <div class="well btn-block">
      <!--div class="btn-group-vertical"-->
        <?php
        print(Html::button("Pretraga","btn btn-primary  btn-block", "onclick=\"show(form.value); return false;\""));
        print(Html::button("Unos","btn btn-success  btn-block", "id=\"conf\""));
        print(Html::button("Brisanje","btn btn-danger btn-block", "id=\"confDel\""));
        echo "<div class='well well-sm'>";
        echo "<small><strong>Uputstvo</strong><br>Bazu možete pretraživati po bilo kom kriterijumu. Počnite od jednostavnijih pretraga (dva-tri slova) pa rafinirajte izbor.<br>Sve što unesete u polja možete uneti i u bazu pritiskom na dugme unos, bez ikakve provere. Jedino ograničenje je da  MB (broj megabajta) i Disk moraju biti brojevi, inače ih baza neće prihvatiti.<br>Sve što ste dobili kao rezultat pretrage možete i da obrišete. Jedini izuzetak su rezulatai Opšte pretrage. Ako su polja prazna brišu se svi unosi<br>I na kraju, jedno prilično nemoguće dugme, na dnu, koje brisaše čitavu bazu. Naravno, tu je radi eksperimenta...</small>";
  
    echo "</div>";
        ?>
      
      </div>
      
      <!--  Modali koji se pojavljuju za potvrdu (kao zastita od nezeljenog pritiska na dugme) -->
      <!-- Modal HTML -->
      <div id="myModal" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Potvrda</h4>
                  </div>
                  <div class="modal-body">
                      <p>Podaci koje ste upisali biće uneti u bazu</p>
                      <p class="text-warning" id="text-warning"><small>Proverite podatke i nastavite sa unosom</small></p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                      <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="insert(form.value);">Nastavi unošenje</button>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal za brisanjeHTML -->
      <div id="myModalDel" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Oprez</h4>
                  </div>
                  <div class="modal-body">
                      <p>Podaci koje ste dobili kao rezultat pretrage biće izbrisani iz baze</p>
                      <p class="text-warning" id="text-warning"><small>Ako niste uneli ni jedan podatak, svi podaci će biti izbrisani</small></p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Odustani</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="del(form.value);return false">Obriši</button>
                  </div>
              </div>
          </div>
      </div>
    </form>
  




  <!-- load delete Database -->
  <form onsubmit="return false">
    <div class='well'>
    <div id='obrisi'>
    <?php
        print(Html::button("Obriši čitavu bazu","btn btn-danger btn-block", "id=\"dbDel\""));
        
        ?>
    </div>
    </div>

    <!-- Modal za brisanje baze -->
      <div id="myModaldbDel" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Oprez</h4>
                  </div>
                  <div class="modal-body">
                      <p>Nastavak Vas vodi u brisanje čitave baze!</p>
                      <p class="text-warning" id="text-warning"><small></small></p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Odustani</button>
                      <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="load('false')" >Obriši čitavu bazu</button>
                  </div>
              </div>
          </div>
      </div>


  </form>
<?php
//zavrsetak dela koji se ucitava postoji baza bazamuzike
} ?>

  </div>



  <!-- /.left input -->
  
  
  <!--middle result -->
  
    <div  class="panel panel-default">

      <!-- Default panel contents -->
      <div class="panel-heading">Rezultati pretrage</div>
      <div class="middle_list">
      <div id="txtHint" class="panel-body">        
      </div>      
      <!-- Table -->
      <script type="text/javascript">//document.write()</script>  
    </div>
    
    <div class="push"></div>
  </div>
  <!--/.middle result -->
  
  
  <!-- right lists -->
  <div class="right">

    <div class="list-group">
      <div class="well">Top 10 artists</div>
    <?php
    if(is_object($con))
  {    
    $sql=mysqli_query($con,"SELECT *   FROM `top10artist`");
    Html::badges($sql,"list-group-item");
  }
    ?>
  
    </div>
    <div class="list-group">
      <div class="well">Top 10 žanrova</div>
    <?php
    if(is_object($con))
  {    
    $sql=mysqli_query($con,"SELECT *   FROM `top10zanrs`");
    Html::badges($sql,"list-group-item");
  }   
    ?>
    </div>
  </div>

  
  <!-- /right lists -->

</div>
<div id="footer">
      <div class="container">
        <p class="text-muted">Stari katalog muzike, koji sam još za studentskih dana vodio u Excell-u, poslužio je kao baza za ovu priliku. Baza je jednostavna, od jedne tabele, i nekoliko simboličnih VIEW-a. Nisam previse vodio računa o podacima, tako da se na listi autora sa najviše albuma vidi Prokofiev i Prokofjev.<br>Najviše vremena, naravno posvetio sam aplikaciji. Plan je bio da se što više posvetim izradi klasa, ali ipak, na kraju, klase su ostale relativno nerazvijene, dok je na funkcionalnost i AJAX otišlo najviše vremena. Klase ostaju za razradu. <br>Nadam se da sam pogodio temu:)</p>
      </div>
</div>





<!-- /main body -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="ajax.js"></script>
  </body>
</html>