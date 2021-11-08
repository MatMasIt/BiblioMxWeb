<?php
require("common.php");
require("isbnImage.php");
function bookDisplay($pdo, $id)
{
  
/*  if(isset($_GET["duid"])){
    $ex=base64url_decode($_GET["duid"]);
    $stmt = $pdo->prepare("SELECT * FROM Libri WHERE Titolo=:titolo AND ISBN=:isbn");
 
    $stmt->execute([":isbn"=>$ex]);//TODO
  }
  else{*/
    $stmt = $pdo->prepare("SELECT * FROM Libri WHERE id=:id");
  $stmt->execute([':id' => $id]);
 // }
  $data = $stmt->fetch();
  $ak=array_keys($data);
  for($i=0;$i<count($ak);$i++){
    $data[$ak[$i]]=iconv('iso-8859-1', 'UTF-8//IGNORE',  $data[$ak[$i]]);
  }
?>
  <!DOCTYPE html>
  <html>
  <title><?php echo htmlentities($data["Titolo"]); ?> | <?php echo  $GLOBALS["place"]; ?></title>
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
       <a href="./" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Biblioteca  | <?php echo  $GLOBALS["place"]; ?></a>

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
              <h4 class="w3-center"><?php echo htmlentities($data["Titolo"]); ?></h4>
              <?php 
                 $image = isbnImage($data["ISBN"]);
              ?>
              <center><a href="<?php 
                 if($image=="books.png"){
                 	echo "#";
                 }
                 else{
                 	echo $image;
                 }
              ?>"><img style="width:10vw" src="<?php echo $image; ?>" /></a></center>
              <hr>
              <?php
              if ($data["Autore"]) {
              ?>

                <p><i class="fa fa-user fa-fw w3-margin-right w3-text-theme"></i> <?php echo htmlentities($data["Autore"]); ?></p>
              <?php
              }
              ?>
              <?php
              if ($data["Editore"]) {
              ?>

                <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> <?php echo htmlentities($data["Editore"]); ?></p>
              <?php
              }
              if ($data["ISBN"]) {
              ?>

                <p><i class="fa fa-hashtag fa-fw w3-margin-right w3-text-theme"></i> ISBN: <?php echo htmlentities($data["ISBN"]); ?></p>
              <?php
              }
              if ($data["Descrizione"]) {
              ?>

                <p><i class="fa fa-book fa-fw w3-margin-right w3-text-theme"></i><?php echo htmlentities($data["Descrizione"]); ?></p>
              <?php
              }
              ?>
            </div>
          </div>
          <br>

          <!-- Accordion -->
          <div class="w3-card w3-round">
            <div class="w3-white">
              <?php
            if($GLOBALS["availability"]){
              if ($data["Prestito"] == "P") {
              ?>
                <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align" style="background-color:red!important"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> In prestito</button>
                <div id="Demo1" class="w3-hide w3-container">
                  <p>Il libro risulta essere in prestito in base agli ultimi dati disponibili</p>
                </div>
              <?php
              } else {
              ?>
                <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align" style="background-color:green!important"><i class="fa fa-check fa-fw w3-margin-right"></i>Disponibile</button>
                <div id="Demo1" class="w3-hide w3-container">
                  <p>Il libro risulta essere disponibile al prestito in base agli ultimi dati disponibili</p>
                </div>
              <?php
              }
              }
              ?>


              <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-info fa-fw w3-margin-right"></i>Informazioni dettagliate</button>
              <div id="Demo2" class=" w3-hide w3-container">
                <table  class="w3-table-all"> 
                      <?php if ($data["Genere"]) { ?><tr class="w3-light-grey"><th>Genere</th>  <td><?php echo htmlentities($data["Genere"]); ?> </td> </tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Titolo"]) { ?><tr class="w3-light-grey"><th>Titolo</th> <td><?php echo htmlentities($data["Titolo"]); ?></td> </tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Autore"]) { ?><tr class="w3-light-grey"><th>Autore</th><td><?php echo htmlentities($data["Autore"]); ?></td> </tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Editore"]) { ?><tr class="w3-light-grey"><th>Editore</th><td><?php echo htmlentities($data["Editore"]); ?></td> </tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Serie"]) { ?><tr class="w3-light-grey"><th>Serie</th><td><?php echo htmlentities($data["Serie"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Lingua"]) { ?><tr class="w3-light-grey"><th>Lingua</th><td><?php echo htmlentities($data["Lingua"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Argomento"]) { ?><tr class="w3-light-grey"><th>Argomento</th><td><?php echo htmlentities($data["Argomento"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["ISBN"]) { ?><tr class="w3-light-grey"><th>ISBN</th><td><?php echo htmlentities($data["ISBN"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Note1"] || $data["Note2"]) { ?><tr class="w3-light-grey"><th>Note</th><td><?php echo htmlentities($data["Note1"])."<br />".htmlentities($data["Note2"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Posizione"]) { ?><tr class="w3-light-grey"><th>Posizione</th><td><?php echo htmlentities($data["Posizione"]); ?></td> </tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Data"]) { ?><tr class="w3-light-grey"><th>Data</th><td><?php echo htmlentities($data["Data"]); ?></td> </tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Inventario"]) { ?><tr class="w3-light-grey"><th>Inventario</th><td><?php echo htmlentities($data["Inventario"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["NPag"]) { ?><tr class="w3-light-grey"><th>Numero di Pagine</th><td><?php echo htmlentities($data["NPag"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Lvlbibliogr"]) { ?><tr class="w3-light-grey"><th>Livello Bibliografico</th><td><?php echo htmlentities($data["Lvlbibliogr"]); ?></td> </tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Dewey"]) { ?><tr class="w3-light-grey"><th>Dewey</th><td><?php echo htmlentities($data["Dewey"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Paesepubblicaz"]) { ?><tr class="w3-light-grey"><th>Paese di pubblicazione</th><td><?php echo htmlentities($data["Paesepubblicaz"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Luogoeditore"]) { ?><tr class="w3-light-grey"><th>Luogo editore</th><td><?php echo htmlentities($data["Luogoeditore"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Curatore"]) { ?><tr class="w3-light-grey"><th>Curatore</th><td><?php echo htmlentities($data["Curatore"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Tipo"]) { ?><tr class="w3-light-grey"><th>Tipo</th><td><?php echo htmlentities($data["Tipo"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Traduzione"]) { ?><tr class="w3-light-grey"><th>Traduzione</th><td><?php echo htmlentities($data["Traduzione"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Descrizione"]) { ?><tr class="w3-light-grey"><th>Descrizione</th><td><?php echo htmlentities($data["Descrizione"]); ?></td></tr class="w3-light-grey"><?php } ?>
                      <?php if ($data["Identificativo"]) { ?><tr class="w3-light-grey"><th>Identificativo</th><td><?php echo htmlentities($data["Identificativo"]); ?></td></tr class="w3-light-grey"><?php } ?>
                </table>
             <!--   <div class="resultD w3-panel w3-card">
               Url permanente: <?php 
              $uri='http://'. $_SERVER['HTTP_HOST'] 
               . explode('?', $_SERVER['REQUEST_URI'], 2)[0];
              $lur=$uri."?duid=".base64url_encode($data["ISBN"]);
               echo "<a href=\"$lur\">".htmlentities($lur)."</a>"; 
               
               ?>
              </div>-->
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
      <p>Repo <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">github</a></p>
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
      myFunction('Demo2')
    </script>

  </body>

  </html>

<?php
}

$dbh = new PDO('sqlite:db');
bookDisplay($dbh, $_GET["id"]);
?>
