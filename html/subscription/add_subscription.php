<?php
  ini_set('display_errors', 'off');
  include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Ajouter un abonnement</title>
</head>

<body class="bodi">

<div class="container">
    <div class="">
        <center><img src="../../img/logo.png" width="200px"></center>
    </div>
    <br>
    <div class="row centered-form">
        <div class="col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><h3 class="font">Ajouter un service</h3></center>
                </div>
                <div class="panel-body">
                    <form action="verif_subscription.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12 col-xl-126">
                                <div class="form-group">
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
                                        echo "<small> *Vous avez besoin d'insérer une image ! </small><br>";
                                    }
                                   ?>
                                    <!-- Affiche -->
                                    <label class="font">Choix du fichier(png, jpg, jpeg) : </label>
                                    <input type="file" name="image" class="form-control input-md" multiple><br>
                                    <!-- Service's name -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form">
                                                <label class="font">Entrez le nom de l'abonnemment : </label>
                                                <input type="text" name="name" placeholder="Nom de l'abonnement"
                                                       class="form-control input-sm"><br>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Service's price -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form">
                                                <label class="font">Prix de l'abonnemment : </label>
                                                <input type="number" name="price" placeholder="Prix de l'abonnement"
                                                       class="form-control input-sm"><br>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Service's hours -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form">
                                                <label class="font">Nombre d'heures par mois : </label>
                                                <input type="number" name="hoursMonth" placeholder="Nombre d'heures par mois"
                                                       class="form-control input-sm" min="1"><br>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Service's hourEnd -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="md-form">
                                                <label class="font">Heure de début : </label>
                                                <input type="time" name="hourStart" placeholder="Heure de début"
                                                       class="form-control input-sm"><br>
                                            </div>
                                        </div>
                                    <!-- Service's hourStart -->
                                        <div class="col-md-6">
                                            <div class="md-form">
                                                <label class="font">Heure de fin : </label>
                                                <input type="time" name="hourEnd" placeholder="Heure de début"
                                                       class="form-control input-sm"><br>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Service's daysWeek -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form">
                                                <label class="font">Nombre de jours par semaine : </label>
                                                <input type="number" name="daysWeek" placeholder="Nombre de jours par semaine"
                                                       class="form-control input-sm" max="7"><br>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Service's description -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form">
                                                <label class="font">Description : </label>
                                                <input type="text" name="description" placeholder="Description du service"
                                                       class="form-control input-sm"><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  <center><input type="submit" value="Valider" class="btn btn-primary"></center>
                                <br>
                    </form>
                    <form action="../subscription.php" method="POST">
                        <center><input type="submit" name="" value="Retour" class="btn btn-danger"></center>
                    </form>
                </div>
            </div>
        </div>
</body>

</html>
