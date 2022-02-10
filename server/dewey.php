<?php
require("common.php");
$pdo = new PDO('sqlite:db');

?>
  <!DOCTYPE html>
  <html>
  <title>Biblioteca | <?php echo  $GLOBALS["place"]; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    html,
    body,
    h1,
    h2,
    h3,
    h4,
    h5 {
      font-family: "Open Sans", sans-serif
    }
  </style>

  <body class="w3-theme-l5">

    <!-- Navbar -->
    <div class="w3-top">
      <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
        <a href="./" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-book w3-margin-right"></i>Biblioteca |<?php echo  $GLOBALS["place"]; ?></a>

      </div>
    </div>


    <!-- Page Container -->
    <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
      <!-- The Grid -->
      <div class="w3-row">
        <!-- Left Column -->
        <div class="w3-content">
          <!-- Profile -->
          <div class="w3-card w3-round w3-white">
            <div class="w3-container">
              <h3 class="w3-center">Biblioteca online</h3>
              <h4 class="w3-center"><?php echo  $GLOBALS["place"]; ?></h4>
              <center><h3><i>Catalogo Dewey</i></h3></center>
              <center><img style="width:45vw" src="bookshelf.svg" /></center>
              <hr>


              <p><i class="fa fa-book fa-fw w3-margin-right w3-text-theme"></i> <?php

                                                                                $stmt = $pdo->prepare("SELECT COUNT(*) as n FROM Libri");
                                                                                $stmt->execute();
                                                                                $data = $stmt->fetch();
                                                                                
                                                                                $vols =  $data["n"];
                                                                                
                                                                                 $stmt = $pdo->prepare("SELECT COUNT(*) as n FROM Libri WHERE length(Dewey)>0");
                                                                                $stmt->execute();
                                                                                $data = $stmt->fetch();
                                                                                $dewey = $data["n"];
                                                                                echo "Volumi: " . $vols.", di cui <b>".$dewey." (".round($dewey/$vols*100)."%) collocati nella calssificazione dewey</b>";
                                                                                    
                                                                                $vols =  $data["n"];
                                                                                ?></p>


              <p><i class="fa fa-user fa-fw w3-margin-right w3-text-theme"></i> <?php

                                                                                $stmt = $pdo->prepare("SELECT COUNT(DISTINCT Autore) as n FROM Libri");
                                                                                $stmt->execute();
                                                                                $data = $stmt->fetch();

                                                                                echo "Autori: " . $data["n"];

                                                                                ?></p>


              <p><i class="fa fa-clock-o fa-fw w3-margin-right w3-text-theme"></i> <?php

                                                                                    $f = date("d/m/Y H:i:s", file_get_contents("lastupdate.dat"));

                                                                                    echo "Ultimo aggiornamento: " . $f;

                                                                                    ?></p>

            </div>
          </div>
          <br>


        
          <!-- Accordion -->
          <div class="w3-card w3-round">
            <div class="w3-white">

              <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-book fa-fw w3-margin-right"></i>Accesso rapido</button>
              <div id="Demo1" class="w3-hide w3-container">
                <div class="resultD w3-panel w3-card">
<style>
.dewey{
    color: green;
   font-weight: bold;
}
.autore{
   font-style: italic;
   color: red;
}
</style>
<?php
$dFile = file("dewey.txt");
$dMap =[];
foreach($dFile as $dr){
    $dew = explode("|",$dr)[0];
    $dMap[$dew[0]][$dew[1]][$dew[2]]= explode("|",$dr)[1];
}
$lastNum="AAA";
$tocA = 0;
$tocB = 0;
$tocC = 0;
$out = "";
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q=$pdo->prepare("SELECT Titolo, id, Autore, Dewey FROM Libri WHERE length(Dewey)>0 GROUP BY Titolo ORDER BY Dewey ASC");
	$q->execute();
	$map = [];
    foreach($q->fetchAll(PDO::FETCH_ASSOC) as $e){
        $map[$e["Dewey"][0]][$e["Dewey"][1]][$e["Dewey"][2]].=  "<a class=\"dewey\" name=\"L".$e["id"]."\" href=\"results.php?Dewey=".htmlentities($e["Dewey"])."\" target=\"_blank\">".htmlentities($e["Dewey"])."</a> <b>-</b> <a href=\"bookDetail.php?id=".htmlentities($e["id"])."\" target=\"_blank\"> ".htmlentities($e["Titolo"])."</a> <a class=\"autore\" href=\"results.php?Autore=".htmlentities($e["Autore"])."\" target=\"_blank\"> ".htmlentities($e["Autore"])."</a><br />";
    
    }
    $out="";
    $toc = "<ul data-level=\"1\">";
    foreach($map as $d1=>$ard2){
        $out.="\n    <a name=\"D".$d1."00\"><h2>".$d1."00 <b> - </b>".trim(htmlentities($dMap[$d1][0][0]))."</h2></a>";
        $toc.="\n".'    <li>';
        $toc.="\n".'        <p><a href="#D'.$d1.'00"> '.$d1.'00  <b>-</b> '.trim(htmlentities($dMap[$d1][0][0]))."</a></p>";
        $toc.="\n".'        <ul data-level="2">';
        foreach($map[$d1] as $d2=>$ard3){
        if($d2!=0)    $out.="\n        <a name=\"D".$d1.$d2."0\"><h3>".$d1.$d2."0 <b> - </b>".trim(htmlentities($dMap[$d1][$d2][0]))."</h3></a>";
        if($d2!=0) $toc.="\n".'        <li>';
        if($d2!=0)    $toc.="\n".'            <p><a href="#D'.$d1.$d2.'0">'.$d1.$d2.'0  <b>-</b> '.trim(htmlentities($dMap[$d1][$d2][0]))."</a></p>";
        if($d2!=0) $toc.="\n".'            <ul data-level="3">';
        foreach($map[$d1][$d2] as $d3=>$text){
            if($d3!=0)    $out.="\n            <a name=\"D".$d1.$d2.$d3."\"><h4>".$d1.$d2.$d3." <b> - </b>".trim(htmlentities($dMap[$d1][$d2][$d3]))."</h4></a>";
            $out.="\n               ".$text;
            if($d3!=0 && $d2!=0) {
                $toc.="\n".'        <li>';
                $toc.="\n".'            <p><a href="#D'.$d1.$d2.$d3.'"> '.$d1.$d2.$d3.'  <b>-</b> '.trim(htmlentities($dMap[$d1][$d2][$d3]))."</a></p>";
                $toc.="\n".'        </li>';
            }
        }
        if($d2!=0) $toc.="\n".'            </ul>';
        if($d2!=0) $toc.="\n".'        </li>';
        }
        $toc.="\n".'        </ul>';
        $toc.="\n".'    </li>';
    }
    $toc .= "</ul>";
   
    echo $toc;
    
    ?>
                </div>
                </div>
                
              
            </div>
          </div>
          
           <div class="w3-card w3-round">
            <div class="w3-white">

              <a class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-book fa-fw w3-margin-right"></i>Elenco</a>
              <div id="Demo2" class="w3-container">
                <div class="resultD w3-panel w3-card">
               
              <?php
             
                echo $out;
                ?>
                 </div>
                </div>
                
            </div>
          </div>
          <br>

          <!-- Interests -->


          <!-- End Left Column -->
        </div>




        <!-- End Grid -->
      </div>

      <!-- End Page Container -->
    </div>
    <br>

    <!-- Footer -->
    <footer class="w3-container w3-theme-d3 w3-padding-16">
      <h5>Mattia Mascarello, MIT License, 2021</h5>
    </footer>

    <footer class="w3-container w3-theme-d5">
      <p>Repo <a href="<?php echo $GLOBALS["repoUrl"]; ?>" target="_blank">github</a> |   <a href="open.php"> Scarica i dati</a></p>
    </footer>

    <script>
      // Accordion
      function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " w3-theme-d1";
        } else {
          x.className = x.className.replace("w3-show", "");
          x.previousElementSibling.className =
            x.previousElementSibling.className.replace(" w3-theme-d1", "");
        }
      }

      // Used to toggle the menu on smaller screens when clicking on the menu button
      function openNav() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
        } else {
          x.className = x.className.replace(" w3-show", "");
        }
      }
      //myFunction('Demo2')
      myFunction('Demo1')
    </script>

  </body>

  </html>

