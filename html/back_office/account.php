<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script type="text/javascript" src="../js/jspdf.min.js"></script>
    <link rel="stylesheet" href="../../css/style.css">


    <title>Mon compte</title>
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
                            <li><a href="../subscription.php">Abonnement</a></li>
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


<?php
session_start();

include '../config.php';
$req = $bdd->prepare('SELECT * FROM subscription WHERE idUser = ?');
$req->execute(array($_SESSION['id']));
$res = $req->fetchAll(PDO::FETCH_ASSOC);

$req5 = $bdd->prepare('SELECT * FROM client WHERE id = ?');
$req5->execute(array($_SESSION['id']));
$res5 = $req5->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    if (!empty($_POST['heureSemaine']) && isset($_POST['date']) && !empty($_POST['date']) && isset($_SESSION['mail'])) {
        $insert = $bdd->prepare("INSERT INTO " . $name . "(heureSemaine,date,name,idUser)" . "VALUES (?,?,?,?)");
        $insert->execute([$_POST['heureSemaine'], $_POST['date'], $name, $_SESSION['id']]);
        $last_id = $bdd->lastInsertId();
    }

    if (!empty($_POST['heureSemaine']) && isset($_POST['dateDebut']) && isset($_POST['dateFin']) && !empty($_POST['dateFin']) && !empty($_POST['dateDebut'])) {
        $insert = $bdd->prepare("INSERT INTO " . $name . "(heureSemaine,dateDebut,dateFin,name,idUser)" . "VALUES (?,?,?,?,?)");
        $insert->execute([$_POST['heureSemaine'], $_POST['dateDebut'], $_POST['dateFin'], $name, $_SESSION['id']]);
        $last_id = $bdd->lastInsertId();
    }

    $req = $bdd->prepare("SELECT * FROM " . $name . " WHERE id =1");
    $req->execute();
    $test = $req->fetchAll(PDO::FETCH_ASSOC);
    $constprice = $test[0]['price'];
    ?>

    <?php


    foreach ($test as $rows) {

        $hour = strtotime($_POST['heureSemaine']);
        if (!empty($_POST['dateDebut']) && !empty($_POST['dateFin']) && isset($_POST['dateDebut']) && isset($_POST['dateFin'])) {
            $dateDebut = idate('w', strtotime($_POST['dateDebut']));
            $dateFin = idate('w', strtotime($_POST['dateFin']));
            $dateDif = $dateFin - $dateDebut;
        }
        if (!empty($_POST['heureSemaine']) && isset($_POST['heureSemaine'])) {
            $stockHmin = idate('H', $hour) * 60;
            $totalH = (idate('i', $hour) + $stockHmin) / 60;
            $result = 0;
        }

        if (!empty($_POST['heureSemaine']) && isset($_POST['heureSemaine'])) {
            if (isset($rows["price"])) {
                $insert = $bdd->prepare(" UPDATE " . $name . " SET price = " . $result . " WHERE id =" . $last_id);
                $insert->execute([$result]);
            }

            $req = $bdd->prepare("SELECT * FROM " . $name . " WHERE id =" . $last_id);
            $req->execute();
            $price = $req->fetchAll(PDO::FETCH_ASSOC);
            $order_number = rand(100000, 999999);
            $req = $bdd->prepare("INSERT INTO order_table(order_number,order_total_amount,idUser,serviceName) VALUES(?,?,?,?)");
            $req->execute([$order_number, $result, $_SESSION['id'], $_POST['name']]);
            $order_id = $bdd->lastInsertId();

            $req2 = $bdd->prepare("UPDATE " . $_POST['name'] . " SET order_id = " . $order_id . " WHERE id =" . $last_id);
            $req2->execute();
        }
    }
}
$req2 = $bdd->prepare('SELECT * FROM order_table WHERE idUser = ?');
$req2->execute(array($_SESSION['id']));
$res2 = $req2->fetchAll(PDO::FETCH_ASSOC);


if (!empty($_POST['heureSemaine']) && isset($_POST['heureSemaine'])) {

    $desc = $bdd->prepare(" DESCRIBE " . $name);
    $desc->execute();
    $try = $desc->fetchAll(PDO::FETCH_ASSOC);

    foreach ($try as $values) {
        if ($values['Type'] != 'int(11)' && $values['Type'] != 'double' && $values['Type'] != 'date' && $values['Type'] != 'time' && $values['Type'] != 'datetime' && $values['Type'] != 'timestamp' && $values['Type'] != 'float') {
            $_POST[$values['Field']] = "'" . $_POST[$values['Field']] . "'";
        }
        $req = $bdd->prepare(" UPDATE " . $name . " SET " . $values['Field'] . "= " . $_POST[$values['Field']] . " WHERE id = " . $last_id);
        $req->execute([$_POST[$values['Field']]]);

    }
}


?>

<main></br>
    <div class="container">
        <div class="row centered-form">
            <br>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <center><h3 class="font">Historique des commandes</h3>
                    <?php
                    if (isset($_SESSION['id'])) {
                        echo 'Bonjour Mr/Mme : <b>' . $res5[0]['firstName'] . " " . $res5[0]['lastName'] . '</b><br>';
                        foreach ($res as $abo) {
                            $req4 = $bdd->prepare('SELECT order_number FROM order_table WHERE order_id = ?');
                            $req4->execute(array($abo['order_id']));
                            $res4 = $req4->fetch(PDO::FETCH_ASSOC);

                            echo 'Abonnement actuel pour votre compte : <b>' . $abo['subscriptionType'] . '</b><br>';
                            echo 'Début le : <b>' . $abo['dateStart'] . '</b><br></center>';
                        }
                    }
                    if (isset($_GET['error']) && $_GET['error'] == 'connected') {
                        echo '<center><p style="color: red;">Il faut être connecté pour s\'abonner</p></center>';
                    }

                    if (isset($_GET['error']) && $_GET['error'] == 'subscribed') {
                        echo '<center><p style="color: red;">Vous êtes déjà abonné</p>';
                    }
                    ?>
            </div>
            <?php

            foreach ($res2 as $rows) {

                $req3 = $bdd->prepare("SELECT * FROM " . $rows['serviceName'] . " WHERE id = 1 ");
                $req3->execute();
                $res3 = $req3->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res3 as $info) {

                    $req2 = $bdd->prepare('SELECT * FROM order_table WHERE idUser = ? AND order_id = ?');
                    $req2->execute([$_SESSION['id'], $rows['order_id']]);
                    $res2 = $req2->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <div class="col-lg-4 col-sm-6 col-xs-12" id="<?= $rows['serviceName']; ?>">
                        <div class="card text-center box" style=""><br>
                            <form method="post" id="facture_from" action="facture_gen.php">

                                <center><img class="size" width="110px" height="110px"
                                             src="<?= $info['image']; ?>"></center>
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: center"><?= $info['name']; ?></h5>
                                    <h6 class="card-title" style="text-align: center">Prix de la
                                        commande: <?= $rows['order_total_amount']; ?>€ TTC</h6>
                                    <p class="card-text" style="text-align: center"><?= $info['description']; ?></p>
                                    <h6 class="card-title" style="text-align: center">Commande Numéro :</h6>
                                    <p class="card-text" style="text-align: center"><?= $rows['order_id']; ?></p>
                                    <h6 class="card-title" style="text-align: center">Numéro de transaction :</h6>
                                    <p class="card-text" style="text-align: center"><?= $rows['order_number']; ?></p>

                                    <input type="hidden" name="amount" id="amount"
                                           value="<?= $rows['order_total_amount'] ?>">
                                    <input type="hidden" name="name" id="name" value="<?= $info['name'] ?>">
                                    <input type="hidden" name="order_id" id="order_id" value="<?= $rows['order_id'] ?>">
                                    <input type="hidden" name="transac_nb" id="transac_nb"
                                           value="<?= $rows['order_number'] ?>">
                                    <input type="hidden" name="firstname" id="firstname"
                                           value="<?= $res5[0]['firstName'] ?>">
                                    <input type="hidden" name="lastname" id="lastname"
                                           value="<?= $res5[0]['lastName'] ?>">
                                    <input type="hidden" name="mail" id="mail" value="<?= $res5[0]['mail'] ?>">

                                    <input type="submit" id="button_action" class="btn btn-success btn-sm"
                                           onclick="" value="Facture"/>

                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

</main>

</body>

<footer>
    <br>
    <img src="../../img/logo.png" width="80">
    <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
        <small> Concierge Expert - All rights reserved © </small></div>
    <br>
</footer>


</html>
