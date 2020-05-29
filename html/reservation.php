<?php
session_start();
include 'config.php';
$name = $_POST['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Réservation</title>
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

<?php
$req2 = $bdd->prepare("SELECT * FROM " . $name);
$req2->execute();
?>

<div class="container">
    <div class="row" id="parent">
        <?php if ($req2->rowCount() > 0) { ?>
            <?php while ($row = $req2->fetch(PDO::FETCH_ASSOC)) { ?>
                <!-- Ajout d'une nouvelle catégorie -->

                <div class="col-lg-4 col-sm-6 col-xs-12" id="<?= $row['name'] ?>">
                    <div class="card text-center box" style="width: 15rem;">
                        <center><img class="size" width="100px" height="100px"
                                     src="<?= 'back_office/' . $row['image']; ?>"></center>
                        <div class="card-body">
                            <h5 class="card-title"><?= '<h3><b>' . str_replace('_', ' ', $row['name']) . '</b></h3>'; ?></h5>
                            <div>
                                <form action="subcategory.php" method="post">
                                    <input type="hidden" name="categorie" value="<?= $name ?>">
                                    <input type="hidden" name="name" value=<?= $row['name'] ?>>
                                    <?php
                                    $connected = isset($_SESSION['mail']) ? true : false;
                                    if ($connected) { ?>
                                        <input type="submit" value="Réserver" class="btn btn-success">
                                    <?php } else { ?>
                                        <a href="connection.php" class="btn btn-success">Connectez-vous</a>
                                    <?php } ?>

                                    <?php

                                    $connected = isset($_SESSION['mail']) && $_SESSION['mail'] == 'concierge_expert@gmail.com' ? true : false;
                                    if ($connected) {
                                        ?>
                                        <input type="button" value="X" class="btn btn-danger"
                                               onclick="sub_delete('<?= $row['name'] ?>','<?= $name ?>')">
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php
$connected = isset($_SESSION['mail']) && $_SESSION['mail'] == 'concierge_expert@gmail.com' ? true : false;
if ($connected) {
    ?>
    <center>
        <form action="back_office/reservation_back.php?service=<?= $name; ?>" method="post">
            <input type="hidden" name="name" value=<?= $name ?>>
            <input type="submit" value="Ajouter" class="btn btn-success">
        </form>
    </center><br>
<?php } ?>

<form action="../index.php" method="POST">
    <center><input type="submit" name="" value="Retour" class="btn btn-danger"></center>
</form>
<script type="text/javascript" src="subcategory.js"></script>

<br>
<footer>
    <br>
    <img src="../img/logo.png" width="80">
    <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
        <small> Concierge Expert - All rights reserved © </small></div>
    <br>
</footer>
</body>


</html>
