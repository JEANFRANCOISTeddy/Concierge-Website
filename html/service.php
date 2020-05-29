<?php
session_start();
include 'config.php';
include 'searchSubcategories.php';
include 'delay.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Concierge Expert</title>
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-11 col-xs-12">
                <nav>
                    <div class="align">
                        <ul>
                            <li><a href="../index.php">Accueil</a></li>
                            <li><a href="service.php">Services</a></li>
                            <a href="../index.php" id="logo"><img src="../img/logo.png" width="150px" alt="logo"></a>
                            <li><a href="subscription.php">Abonnement</a></li>
                            <?php
                            $connected = isset($_SESSION['mail']) ? true : false;
                            if ($connected) { ?>
                                <li><a href="deconnection.php">
                                        <button type="button" class="btn btn-primary">Déconnexion</button>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li><a href="connection.php">
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

<br>
<center>
    <center>
        <a href="webGL/exemple/projet.html">
            <button class="btn btn-primary"> Visualisation de service en 3D</button>
        </a>
    </center>
    <br>
    <input class="form-control col-md-3" id="searchService" type="text" placeholder="Chercher un service"
           aria-label="Search">
    <br>
    <button class="btn btn-warning" onclick="search()">Rechercher</button>
    <br></center>
<br>

<div id="searchSection">
    <div class="container">
        <div class="row">
            <?php
            $sc = searchSubcategories();
            for ($i = 0; $i < sizeof($sc); $i++) {
                echo '<div class="col-lg-3 col-sm-6 col-xs-12">';
                echo '<div class="card text-center box" style="width: 15rem;">';
                echo '<center><img class="size" width="100px" height="100px" src="back_office/' . $sc[$i][1] . '"></center>';
                echo '<br>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title"><h4><b>' . str_replace('_', ' ', $sc[$i][0]) . '</h4></b></h5>';
                echo '<form style="text-align: center" action="subcategory.php" method="post">';
                echo '<input type="hidden" name="categorie" value="' . $sc[$i][2] . '">';
                echo '<input type="hidden" name="name" value="' . $sc[$i][0] . '">';
                $connected = isset($_SESSION['mail']) ? true : false;
                if ($connected) {
                    echo '<input type="submit" value="Réserver" class="btn btn-success">';
                } else {
                    echo '<a href="connection.php" class="btn btn-success">Connectez-vous</a>';
                }
                echo '</form>';
                echo '<br>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<br>
<script src="search.js"></script>

</body>

<footer>
    <br>
    <img src="../img/logo.png" width="80">
    <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
        <small> Concierge Expert - All rights reserved © </small></div>
    <br>
</footer>
</html>
