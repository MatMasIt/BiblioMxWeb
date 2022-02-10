<?php
require("common.php");
//require("isbnImage.php");
function main($pdo, $pageN)
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
        <a href="./" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-book w3-margin-right"></i>Biblioteca | <?php echo  $GLOBALS["place"]; ?></a>

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
              <h4 class="w3-center">Interrogazione completata</h4>
            </div>
          </div>
          <br>

          <!-- Accordion -->
          <div class="w3-card w3-round">
            <div class="w3-white">

              <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-list fa-fw w3-margin-right"></i>Risultati dell&apos;interrogazione</button>
              <div id="Demo1" class="w3-hide w3-container">
                <?php
                $arrayQ = [];
                $mainQuery = "SELECT id,Titolo,Autore,ISBN,Dewey FROM Libri WHERE ";
                $lQuery = " SELECT DISTINCT upper(SUBSTR(Titolo,1,1)) AS letter FROM Libri ORDER BY letter";
                $query = "";
                $flag = false;
                if (!empty($_GET["Titolo"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Titolo)) LIKE ('%' || trim(lower(:Titolo)) || '%')";
                  $arrayQ[":Titolo"] = $_GET["Titolo"];
                }
                if (!empty($_GET["Letter"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Titolo)) LIKE ( trim(lower(:Letter)) || '%')";
                  $arrayQ[":Letter"] = $_GET["Letter"];
                }
                if (!empty($_GET["Autore"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Autore)) LIKE ('%' || trim(lower(:Autore)) || '%')";
                  $arrayQ[":Autore"] = $_GET["Autore"];
                }
                if (!empty($_GET["Editore"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Editore)) LIKE ('%' || trim(lower(:Editore)) || '%')";
                  $arrayQ[":Editore"] = $_GET["Editore"];
                }
                if (!empty($_GET["Genere"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Genere)) LIKE ('%' || trim(lower(:Genere)) || '%')";
                  $arrayQ[":Genere"] = $_GET["Genere"];
                }
                if (!empty($_GET["ISBN"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(ISBN)) LIKE ('%' || trim(lower(:ISBN)) || '%')";
                  $arrayQ[":ISBN"] = $_GET["ISBN"];
                }
                if (!empty($_GET["Inventario"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Inventario)) LIKE ('%' || trim(lower(:Inventario)) || '%')";
                  $arrayQ[":Inventario"] = $_GET["Inventario"];
                }
                if (!empty($_GET["Serie"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Serie)) LIKE ('%' || trim(lower(:Serie)) || '%')";
                  $arrayQ[":Serie"] = $_GET["Serie"];
                }
                if (!empty($_GET["Lingua"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= "trim(lower(Lingua)) LIKE ('%' || trim(lower(:Lingua)) || '%')";
                  $arrayQ[":Lingua"] = $_GET["Lingua"];
                }  
               if (!empty($_GET["Dewey"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= "trim(lower(Dewey)) LIKE ('%' || trim(lower(:Dewey)) || '%')";
                  $arrayQ[":Dewey"] = $_GET["Dewey"];
                }
                if (!empty($_GET["Argomento"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " trim(lower(Argomento)) LIKE ('%' || trim(lower(:Argomento)) || '%')";
                  $arrayQ[":Argomento"] = $_GET["Argomento"];
                }
                if ($_GET["Prestito"] == "P") {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Prestito='P'";
                } elseif ($_GET["Prestito"] == "NP") {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Prestito!='P'";
                }
                if (!empty($_GET["NPag"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " NPag =:NPag";
                  $arrayQ[":NPag"] = $_GET["NPag"];
                }

                if (!$flag) $query .= " 1=1";
                $query .= " ORDER BY Titolo ASC";
                $newPage = $mainQuery.$query." LIMIT 10 OFFSET  ".(($pageN+1)*10);
                $query .= " LIMIT " . (10) . " OFFSET " . ($pageN * 10);
                $mainQuery .= $query;
                $stmt = $pdo->prepare($lQuery);
                $stmt->execute();
                $np = $pdo->prepare($newPage);
                $np->execute($arrayQ);
                $hasNewPage = count($np->fetchAll()) > 0;
                ?>
                <div class="resultD w3-panel w3-card">
                
                <?php
                $test = $_GET;
                unset($test["Letter"]);
                unset($test["page"]);
                unset($test["first"]);
                $test["Numero di Pagine"] = $test["NPag"];
                unset($test["NPag"]);
                
                if(count($test)){
                ?>
                <p>Parametri di ricerca</p>
                  <table class="w3-table w3-bordered">
                  <thead>
                  <tr>
                  <?php
                   foreach(array_keys($test) as  $key){
                   		if(!strlen($test[$key])) continue;
                		echo "<th>".htmlentities($key)."</th>";
                  }
                  ?>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                  <?php
                   foreach(array_values($test) as  $val){
                   		if(!strlen($val)) continue;
                		echo "<td>".htmlentities($val)."</td>";
                  }
                  ?>
                  </tr>
                </tbody>
                </table>
                <br /><br />
                <form method="POST" action="results.php">
                <button class="w3-btn w3-left w3-orange"><i class="fa fa-book fa-fw w3-margin-right"></i>Sfoglia senza restrizioni</button>
                </form>
                <form method="POST" action="dewey.php">
                <button class="w3-btn w3-left w3-blue-grey"><i class="fa fa-book fa-fw w3-margin-right"></i>Sfoglia catalogo dewey</button>
                </form>
                </div>
                <div class="resultD w3-panel w3-card">
                <?php
                }
                ?>
                    <form method="POST" style="display:inline;">
                    <input type="hidden" name="Letter" value="" />                                                                                         
                    <button class="w3-btn w3-red">&times;</button>
                    </form>&nbsp;&nbsp;
                <?php
                while ($data = $stmt->fetch()) {
                	$letter = $data["letter"];
                    ?>
                    <form method="POST" style="display:inline;">
                     <?php
                     $p = $_GET["page"];
                     unset($_GET["page"]);
                        foreach ($_GET as $key => $val) {
                        ?><input type="hidden" name="<?php echo htmlentities($key); ?>" value="<?php echo htmlentities($val); ?>" /><?php
                                                                                                                                  }
                    ?>
                    <input type="hidden" name="Letter" value="<?php echo htmlentities($letter); ?>" />                                                                                         
                    <button class="w3-btn w3-blue-grey"><?php echo htmlentities($letter); ?></button>
                    </form>
                    <?php
                    $_GET["page"] = $p;
                }
                ?>
                </div>
                <?php
                $stmt = $pdo->prepare($mainQuery);
                $stmt->execute($arrayQ);
                $i = 0;
                while ($data = $stmt->fetch()) {
                  $ak = array_keys($data);
                  for ($i = 0; $i < count($ak); $i++) {
                    $data[$ak[$i]] = iconv('iso-8859-1', 'UTF-8//IGNORE',  $data[$ak[$i]]);
                  }
                ?>
                  <div class="resultD w3-panel w3-card">
         <!--      <img src="<?php
               //echo isbnImage($data["ISBN"]);
               ?>books.png" style="width:10vw;" /> --->
                    <table>
                      <tr>
                        <th>Titolo</th>
                        <td><?php echo htmlentities($data["Titolo"]); ?></td>
                      </tr>
                      <tr>
                        <th>Autore</th>
                        <td><?php echo htmlentities($data["Autore"]); ?></td>
                      </tr>
                      <tr>
                        <th>ISBN</th>
                        <td><?php echo htmlentities(strlen(trim($data["ISBN"]))?$data["ISBN"]:"-"); ?></td>
                      </tr>
                      <tr>
                        <th>Dewey</th>
                        <td><?php echo htmlentities(strlen(trim($data["Dewey"]))?$data["Dewey"]:"-"); ?></td>
                      </tr>
                    </table>
                    <form action="bookDetail.php" method="GET"  target="_blank">
                      <input name="id" type="hidden" value="<?php echo $data["id"]; ?>" />
                      <button class="w3-btn w3-right w3-blue-grey"><i class="fa fa-arrow-circle-right fa-fw w3-margin-right"></i>Vedi</button>
                    </form>
                  </div>
                <?php
                  $i++;
                }
                if ($i == 0) {
                  echo '<h4 class="w3-center">Nessun risultato</h4>';
                }
                ?>
                <div class="w3-row">
                  <?php
                  $p = (int)$_GET["page"];
                  unset($_GET["page"]);
                  if ($p != 0) {
                  ?>
                    <div class="w3-third">
                      <form method="POST">
                        <?php

                        foreach ($_GET as $key => $val) {
                        ?><input type="hidden" name="<?php echo htmlentities($key); ?>" value="<?php echo htmlentities($val); ?>" /><?php
                                                                                                                                  }
                                                                                                                                    ?>
                        <input type="hidden" name="page" value="<?php echo $p - 1; ?>">
                        <button class="w3-btn  w3-left w3-blue-grey"> <i class="fa fa-arrow-left fa-fw w3-margin-right "></i>Pagina precedente</button>
                      </form>
                    </div>
                  <?php

                  } else {
                  ?><div class="w3-third"></div><?php
                                              }

                                                ?>
                  <div class="w3-third">
                    <?php if ($i != 0) { ?> <h4 class="w3-center">Pagina <?php echo $pageN + 1; ?></h4> <?php } ?>
                  </div>
                  <div class="w3-third">
                    <?php
                    if ($i != 0 && $hasNewPage) {
                    ?>
                      <form method="GET">
                        <?php
                        foreach ($_GET as $key => $val) {
                        ?><input type="hidden" name="<?php echo htmlentities($key); ?>" value="<?php echo htmlentities($val); ?>" /><?php
                                                                                                                                  }
                                                                                                                                    ?>
                        <input type="hidden" name="page" value="<?php echo $p + 1; ?>">
                        <button class="w3-btn  w3-right w3-blue-grey"> Pagina successiva<i class="fa fa-arrow-right fa-fw w3-margin-left"></i></button>
                      </form>
                    <?php
                    }
                    ?>
                  </div>
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
      myFunction('Demo1')
    </script>

  </body>

  </html>

<?php
}

$dbh = new PDO('sqlite:db');
main($dbh, $_GET["page"] ?: 0);
?>
