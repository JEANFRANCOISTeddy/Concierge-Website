<?php
  session_start();
  include '../config.php';
  $name = $_GET['service'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Reservation Back</title>
</head>

<body>
  <header>
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-12 col-md-11 col-xs-12">
                  <nav>
                      <div class="align">
                          <ul>
                              <li><a href="../../index.php">Accueil</a></li>
                              <li><a href="../service.php">Services</a></li>
                              <a href="../../index.php" id="logo"><img src="../../img/logo.png" width="150px" alt="logo"></a>
                              <li><a href="subscription.php">Abonnement</a></li>
                              <?php
                                      $connected = isset($_SESSION['mail']) ? true : false;
                                      if ($connected) { ?>
                              <li><a href="../deconnection.php">
                                      <button type="button" class="btn btn-primary">Déconnexion</button>
                                  </a>
                              </li>
                              <?php } else { ?>
                                  <li><a href="../connection.php">
                                          <button type="button" class="btn btn-primary">Espace Client</button>
                                      </a>
                                  </li>
                              <?php } ?>
                          </ul>
                      </div>
                  </nav>
              </div>
          </div>
      </div>
  </header>
<div id="accept"></div>
<center>
    <br><h1 class="font">Prévisualisation de votre nouveau service</h1></br>
    <form action="new_service.php?service=<?= $name; ?>" id="addOption" method="post" enctype="multipart/form-data">
        <?php
          if (isset($_GET['error']) && $_GET['error'] === 'size') {
              echo '<small> *Le fichier est trop volumineux ! </small><br>';
          }
          if (isset($_GET['error']) && $_GET['error'] === 'corrupted') {
              echo '<small> *Le fichier est corrompu ! </small><br>';
          }
          if (isset($_GET['error']) && $_GET['error'] === 'type') {
              echo '<small> *Vous ne pouvez pas envoyer des fichiers de ce type ! </small><br>';
          }
          if (isset($_GET['error']) && $_GET['error'] === 'empty') {
              echo "<small> *Vous avez besoin de remplir tous les champs ! </small><br>";
          }
         ?>
        <label class="font">Choix du fichier(png, jpg, jpeg) : </label></br>
        <input type="file" name="image" multiple><br>
        <label class="font">Entrez le nom du service : </label></br>
        <input type="text" name="columName" placeholder="Nom du service"></br>
        <label class="font">Prix unitiare (pour 1heure) : </label></br>
        <input type="number" name="price" placeholder="Prix"></br>
        <label class="font">Description du service : </label></br>
        <input type="text" name="description" placeholder="Entrez la description du service" style="width:180px; height:100px;"></br>
        <label class="">Heure par semaine: </label></br>
        <input type="time" name="heureSemaine" placeholder="heureSemaine"></br>
        <div id="newInput2"></div>
      </br><input type="submit" value="Créer le service" class="btn btn-primary">
      </form>

    </form>
    <br></center>

<center>
    <form name="formulaire">
        <table class="">
            <tr>
                <td align="center">Champs de saisie </br>à supprimer</br>
                    <select align=top id="liste3" size=8 style="width:200px; height:200px;">
                    </select>
                </td>
                <td align="center">Champs de saisie </br>supplémentaires<br>
                    <select name="liste1" size=8 style="width:200px; height:200px;">
                        <?php
                        $i=0;
                        $req2 = $bdd->prepare("DESCRIBE " . $name);
                        $req2->execute();

                        if ($req2->rowCount() > 0) { ?>
                            <?php while ($row = $req2->fetch(PDO::FETCH_BOTH)) { ?>
                                <?php $i++; if($i > 4){ ?>
                                  <option value="<?= $row[0]; ?>" id="<?= $row[0]; ?>"><?= $row[0] . " " . $row[1]; ?></option>
                                  <?php } ?>
                            <?php } ?>
                        <?php } ?>
                </td>

                <div id="moveBox">
                    <td align="center">Champs de saisie que</br> vous allez rajouter<br>
                        <select align=top id="liste2" size=8 style="width:200px; height:200px;">
                        </select>
                    </td>
                </div>
            </tr>
        </table>
        </br>
        </div>

        <tr>
            <td>
                <input type="button" value="Supprimer" onClick="deplacer(form.liste1,form.liste3)"
                       class="btn btn-danger">
            </td>
            <td>
                <input type="button" value="Ajouter >>" onClick="deplacer(form.liste1,form.liste2)"
                       class="btn btn-success" id="moveL">
            </td>
            <td>
                <input type="button" value="<< Retirer" onClick="deplacer(form.liste2,form.liste1)"
                       class="btn btn-warning" id="moveR">
            </td>
        </tr>
        </br></br>
        <button type="button" class="btn btn-primary" onClick="traitement()">Démarrer les traitements</button>
    </form>
</center>

</br>
<center>
    <form  action="verif_reservation.php?service=<?= $name; ?>" method="POST" enctype="multipart/form-data" id="column">
        <label>Ajouter une colonne :</label></br>
        <div id="error"></div>
        <input type="text" id="columnName" name="columnName" placeholder="Entrez le nom de la colonne à rajouter"
               onblur="verifyColumn()">
        <select name="type" id="choice" onchange="verify()">
            <option value="INT" selected>INT</option>
            <option value="DOUBLE">DOUBLE</option>
            <option value="DATE">DATE</option>
            <option value="TIME">TIME</option>
            <option value="CHAR">CHAR</option>
            <option value="VARCHAR">VARCHAR</option>
            <option value="TEXT">TEXT</option>
        </select>
        <input type="hidden" name="nameCategorie" value="<?= $name ?>" id="inputHidden">
        <div id="newInput"></div>
      </br><input type="submit" value="Ajouter" class="btn btn-primary" onclick="inputNumber()">
    </form><br>
</center>

<script type="text/javascript" src="input.js"></script>

</body>
<br><footer>
    <br>
    <img src="../../img/logo.png" width="80">
    <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
        <small> Concierge Expert - All rights reserved © </small></div>
    <br>
</footer>

</html>
