<?php session_start();
include 'html/config.php';
include 'html/delay.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Concierge Expert</title>
</head>
<body>
<div id="accept"></div>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-11 col-xs-12">
                <nav>
                    <div class="align">
                        <ul>
                            <?php
                            $connected = isset($_SESSION['mail']) ? true : false;
                            if ($connected) { ?>
                                <li><a href="html/back_office/account.php">Historique</a></li>
                            <?php } else { ?>
                                <li><a href="index.php">Accueil</a></li>
                            <?php } ?>
                            <li><a href="html/service.php">Services</a></li>
                            <a href="index.php" id="logo"><img src="img/logo.png" width="150px" alt="logo"></a>
                            <li><a href="html/subscription.php">Abonnement</a></li>
                            <?php
                            $connected = isset($_SESSION['mail']) ? true : false;
                            if ($connected) { ?>
                                <li><a href="html/deconnection.php">
                                        <button type="button" class="btn btn-primary">Déconnexion</button>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li><a href="html/connection.php">
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

<main>
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/background.jpg" class="d-block w-100" class="background">
            </div>
        </div>

    </div>

    </br>
    <center><h1 class="font">Nos catégories de services les plus demandées</h1></center>

    <?php
    $req2 = $bdd->prepare("SELECT * FROM SERVICE WHERE add_index = 'yes'");
    $req2->execute();
    ?>

    <div class="container">
        <div class="row" id="parent">
            <?php if ($req2->rowCount() > 0) { ?>
                <?php while ($row = $req2->fetch(PDO::FETCH_ASSOC)) { ?>
                    <!-- Ajout d'un service sur l'écran d'accueil -->

                    <div class="col-lg-3 col-sm-6 col-xs-12" id="<?= $row['name']; ?>">
                        <div class="card text-center box" style="width: 15rem;">
                            <center><img class="size" width="100px" height="100px"
                                         src="<?= 'html/back_office/' . $row['image']; ?>"></center>
                            <div class="card-body">
                                <h5 class="card-title"><?= '<h3><b>' . str_replace('_', ' ', $row['name']) . '</b></h3>'; ?></h5>
                                <form action="html/reservation.php" method="post">
                                    <input type="hidden" name="name" value="<?= $row['name']; ?>">
                                    <?php
                                    $connected = isset($_SESSION['mail']) ? true : false;
                                    if ($connected) { ?>
                                        <input type="submit" value="Visionner" class="btn btn-primary">
                                    <?php } else { ?>
                                        <a href="html/connection.php" class="btn btn-success">Connectez-vous</a>
                                    <?php } ?>

                                    <?php
                                    $connected = isset($_SESSION['mail']) && $_SESSION['mail'] == 'concierge_expert@gmail.com' ? true : false;
                                    if ($connected) {
                                        ?>
                                        <input type="button" value="X" class="btn btn-danger"
                                               onclick="deleteService('<?= $row['name'] ?>')">
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <br>
    <?php
    $connected = isset($_SESSION['mail']) && $_SESSION['mail'] == 'concierge_expert@gmail.com' ? true : false;
    if ($connected) {
        ?>
        <center><a href="html/back_office/add_service.php">
                <button type="button" class="btn btn-primary">Ajouter un service</button>
            </a></center>
        <br>
    <?php } ?>

    <section class="presentation">
        <div class="container">
            <div class="row" id="grey_box">
                <div class="col-lg-5">
                    <div class="md-form">
                        <img src="img/description.jpg" width="400px" class="costumer" class="col-lg-4 col-md-12">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="md-form" id="textarea">
                        <h2 id="bio">L'excellence avant tout !</h2></br>
                        <p id="description">Depuis plus de 40 ans, notre société tend à se perfectionner pour
                            vous proposer les meilleurs services d'une qualité toujours exemplaire.</p></br>
                        <center><a href="html/devis.php">
                                <button type="button" class="btn btn-success">Demandez votre devis</button>
                            </a></center>
                        </br>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="md-form">
                        <center><h2 id="title">Pourquoi choisir <b>Concierge Expert</b> ?</h2></br></center>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="md-form">
                        <center><img src="img/character.png" width="150px"><br>
                            <p class="text">Des expert(e)s confirmé(e)s </br>& certifié(e)s</p></center>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="md-form">
                        <center><img src="img/euros.png" width="190px"><br>
                            <p class="text">Des prix défiants </br>toute concurrence</p></center>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="md-form">
                        <center><img src="img/client.png" width="160px"><br>
                            <p class="text">Un service client </br>des plus réactifs</p></center>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>

<script type="text/javascript" src="index.js"></script>

<footer>
    <br>
    <img src="img/logo.png" width="80">
    <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
    <small> Concierge Expert - All rights reserved © </small></div>
    <br>
</footer>
</body>

</html>
