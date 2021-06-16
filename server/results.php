<?php
require("common.php");
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

              <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-list fa-fw w3-margin-right"></i>Risultati dell'interrogazione</button>
              <div id="Demo1" class="w3-hide w3-container">
                <?php
                $arrayQ = [];
                $query = "SELECT id,Titolo,Autore,ISBN FROM Libri WHERE";
                $flag = false;
                if (!empty($_POST["Titolo"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Titolo LIKE ('%' || :Titolo || '%')";
                  $arrayQ[":Titolo"] = $_POST["Titolo"];
                }
                if (!empty($_POST["Autore"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Autore LIKE ('%' || :Autore || '%')";
                  $arrayQ[":Autore"] = $_POST["Autore"];
                }
                if (!empty($_POST["Editore"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Editore LIKE ('%' || :Editore || '%')";
                  $arrayQ[":Editore"] = $_POST["Editore"];
                }
                if (!empty($_POST["Genere"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Genere LIKE ('%' || :Genere || '%')";
                  $arrayQ[":Genere"] = $_POST["Genere"];
                }
                if (!empty($_POST["ISBN"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " ISBN LIKE ('%' || :ISBN || '%')";
                  $arrayQ[":ISBN"] = $_POST["ISBN"];
                }
                if (!empty($_POST["Inventario"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Inventario LIKE ('%' || :Inventario || '%')";
                  $arrayQ[":Inventario"] = $_POST["Inventario"];
                }
                if (!empty($_POST["Serie"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Serie LIKE ('%' || :Serie || '%')";
                  $arrayQ[":Serie"] = $_POST["Serie"];
                }
                if (!empty($_POST["Lingua"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Lingua LIKE ('%' || :Lingua || '%')";
                  $arrayQ[":Lingua"] = $_POST["Lingua"];
                }
                if (!empty($_POST["Argomento"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Argomento LIKE ('%' || :Argomento || '%')";
                  $arrayQ[":Argomento"] = $_POST["Argomento"];
                }
                if ($_POST["Prestito"] == "P") {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Prestito='P'";
                } elseif ($_POST["Prestito"] == "NP") {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " Prestito!='P'";
                }
                if (!empty($_POST["NPag"])) {
                  if (!$flag) {
                    $flag = true;
                  } else {
                    $query .= " AND ";
                  }
                  $query .= " NPag =:NPag";
                  $arrayQ[":NPag"] = $_POST["NPag"];
                }

                if (!$flag) $query .= " 1=1";
                $query .= " ORDER BY Titolo ASC";
                $query .= " LIMIT " . (10) . " OFFSET " . ($pageN * 10);
                $stmt = $pdo->prepare($query);
                $stmt->execute($arrayQ);
                $i = 0;
                while ($data = $stmt->fetch()) {
                  $ak = array_keys($data);
                  for ($i = 0; $i < count($ak); $i++) {
                    $data[$ak[$i]] = iconv('iso-8859-1', 'UTF-8//IGNORE',  $data[$ak[$i]]);
                  }
                ?>
                  <div class="resultD w3-panel w3-card">
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
                        <td><?php echo htmlentities($data["ISBN"]); ?></td>
                      </tr>
                    </table>
                    <form action="bookDetail.php" method="GET">
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
                  $p = (int)$_POST["page"];
                  unset($_POST["page"]);
                  if ($p != 0) {
                  ?>
                    <div class="w3-third">
                      <form method="POST">
                        <?php

                        foreach ($_POST as $key => $val) {
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
                    if ($i != 0) {
                    ?>
                      <form method="POST">
                        <?php
                        foreach ($_POST as $key => $val) {
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
      myFunction('Demo1')
    </script>

  </body>

  </html>

<?php
}

$dbh = new PDO('sqlite:db');
main($dbh, $_POST["page"] ?: 0);
?>
