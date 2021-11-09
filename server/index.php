<?php
require("common.php");
function main($pdo)
{

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
        <a href="#" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-book w3-margin-right"></i>Biblioteca |<?php echo  $GLOBALS["place"]; ?></a>

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
              <center><img style="width:45vw" src="bookshelf.svg" /></center>
              <hr>


              <p><i class="fa fa-book fa-fw w3-margin-right w3-text-theme"></i> <?php

                                                                                $stmt = $pdo->prepare("SELECT COUNT(*) as n FROM Libri");
                                                                                $stmt->execute();
                                                                                $data = $stmt->fetch();

                                                                                echo "Volumi: " . $data["n"];

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

              <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-search fa-fw w3-margin-right"></i>Interroga l'archivio</button>
              <div id="Demo1" class="w3-hide w3-container">
                <form method="POST" action="results.php">
                  <div class="w3-row">
                    <p class="w3-third"><label>Titolo</label>
                      <input class="w3-input w3-border" name="Titolo" type="text">
                    </p>

                    <p class="w3-third"><label>Autore</label>
                      <input class="w3-input w3-border" name="Autore" type="text">
                    </p>

                    <p class="w3-third"><label>Genere</label>
                      <input class="w3-input w3-border" name="Genere" type="text">
                    </p>
                  </div>

                  <div class="w3-row">
                    <p class="w3-third"><label>Editore</label>
                      <input class="w3-input w3-border" name="Editore" type="text">
                    </p>

                    <p class="w3-third"><label>ISBN</label>
                      <input class="w3-input w3-border" name="ISBN" type="number">
                    </p>

                    <p class="w3-third"><label>Inventario</label>
                      <input class="w3-input w3-border" name="Inventario" type="text">
                    </p>

                  </div>

                  <div class="w3-row">

                    <p class="w3-third"><label>Serie</label>
                      <input class="w3-input w3-border" name="Serie" type="text">
                    </p>

                    <p class="w3-third"><label>Lingua</label>
                      <input class="w3-input w3-border" name="Lingua" type="text">
                    </p>

                    <p class="w3-third"><label>Argomento</label>
                      <input class="w3-input w3-border" name="Argomento" type="text">
                    </p>

                  </div>

                  <div class="w3-row">
			<?php
            if($GLOBALS["availability"]){
            ?>
                    <p class="w3-third"><label>In prestito</label>
                      <select class="w3-select" name="Prestito"> 
                      <option value="P">Sì</option>
                      <option value="NP">No</option>
                      <option selected value="IGNORE">Ignora</option>
                      </select>
                    </p>
            <?php
            }
            ?>

                    <p class="w3-third"><label>Dewey</label>
                      <input class="w3-input w3-border" name="first" type="Dewey">
                    </p>

                    <p class="w3-third"><label>Numero di pagine</label>
                      <input class="w3-input w3-border" name="NPag" type="number">
                    </p>

                  </div>

                  <button class="w3-btn w3-right w3-blue-grey"><i class="fa fa-search fa-fw w3-margin-right"></i>Interroga</button>
                 
                </form>
                <form method="POST" action="results.php">
                <button class="w3-btn w3-left w3-blue-grey"><i class="fa fa-book fa-fw w3-margin-right"></i>Sfoglia catalogo</button>
                </form>
				<br />
                  <br />

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
      <p>Repo <a href="<?php echo $GLOBALS["repoUrl"]; ?>" target="_blank">github</a></p>
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

<?php
}

$dbh = new PDO('sqlite:db');
main($dbh);
?>
