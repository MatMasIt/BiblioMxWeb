<?php
require("common.php");
function human_filesize($size, $precision = 2) {
    for($i = 0; ($size / 1024) > 0.9; $i++, $size /= 1024) {}
    return round($size, $precision).['B','kB','MB','GB','TB','PB','EB','ZB','YB'][$i];
}
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
              <center><h3><i>Dati Aperti</i></h3></center>
              <center><img style="width:45vw" src="bookshelf.svg" /></center>
              <hr>


              <p><i class="fa fa-book fa-fw w3-margin-right w3-text-theme"></i> <?php

                                                                                $stmt = $pdo->prepare("SELECT COUNT(*) as n FROM Libri");
                                                                                $stmt->execute();
                                                                                $data = $stmt->fetch();

                                                                                echo "Volumi: " . $data["n"];
                                                                                    
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

              <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-book fa-fw w3-margin-right"></i>Banche Dati</button>
              <div id="Demo1" class="w3-hide w3-container">
                <div class="resultD w3-panel w3-card">
                    <table>
                      <tbody><tr>
                        <th>Tipo</th>
                        <td>Foglio CSV</td>
                      </tr>
                      <tr>
                        <th>Nome</th>
                        <td>current.csv</td>
                      </tr>
                      <tr>
                        <th>Dimensione</th>
                        <td><?php echo human_filesize(filesize("data/current.csv")); ?> </td>
                      </tr>
                       
                    </tbody></table>
                      <a href="data/current.csv" class="w3-btn w3-right w3-blue-grey"><i class="fa fa-download"></i>Scarica</a>
                    </div>
                    <div class="resultD w3-panel w3-card">
                    <table>
                      <tbody><tr>
                        <th>Tipo</th>
                        <td>Foglio di Microsoft Excel</td>
                      </tr>
                      <tr>
                        <th>Nome</th>
                        <td>current.xlsx</td>
                      </tr>
                      <tr>
                        <th>Dimensione</th>
                        <td><?php echo human_filesize(filesize("data/current.xslx")); ?> </td>
                      </tr>
                      
                    </tbody></table>
                      <a href="data/current.xlsx" class="w3-btn w3-right w3-blue-grey"><i class="fa fa-download" aria-hidden="true"></i>Scarica</a>
                  </div>
                  <div class="resultD w3-panel w3-card">
                    <table>
                      <tbody><tr>
                        <th>Tipo</th>
                        <td>Foglio di calcolo di LibreOffice</td>
                      </tr>
                      <tr>
                        <th>Nome</th>
                        <td>current.ods</td>
                      </tr>
                      <tr>
                        <th>Dimensione</th>
                        <td><?php echo human_filesize(filesize("data/current.ods")); ?> </td>
                      </tr>
                      
                    </tbody></table>
                      <a href="data/current.ods" class="w3-btn w3-right w3-blue-grey"><i class="fa fa-download" aria-hidden="true"></i>Scarica</a>
                  </div>
                    <div class="resultD w3-panel w3-card">
                    <table>
                      <tbody><tr>
                        <th>Tipo</th>
                        <td>Database sqllite</td>
                      </tr>
                      <tr>
                        <th>Nome</th>
                        <td>db</td>
                      </tr>
                      <tr>
                        <th>Dimensione</th>
                        <td><?php echo human_filesize(filesize("db")); ?> </td>
                      </tr>
                       
                    </tbody></table>
                      <a href="db" class="w3-btn w3-right w3-blue-grey"><i class="fa fa-download" aria-hidden="true"></i>Scarica</a>
                  </div>
                  
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

<?php
}

$dbh = new PDO('sqlite:db');
main($dbh);
?>
