<?php session_start();
include 'config.php';
$name = $_POST['name'];
$constprice = 0;

$today = getdate();

if (!empty($_POST['heureSemaine']) && isset($_POST['date']) && !empty($_POST['date']) && isset($_SESSION['mail'])) {
    /*$date = date('d', strtotime($_POST['date']));
    $datem = date('m', strtotime($_POST['date']));
    $datey = date('Y', strtotime($_POST['date']));
    $verifJ = $today['mday'] - $date;
    $verifM = $today['mon'] - $datem;

    if (abs($verifJ) > 0 && abs($verifM) > 0) {
        header('location: ../index.php?erreur=erreurdate');
        exit;
    }*/

    $insert = $bdd->prepare("INSERT INTO " . $name . "(heureSemaine,date,name,idUser)" . "VALUES (?,?,?,?)");
    $insert->execute([$_POST['heureSemaine'], $_POST['date'], $name, $_SESSION['id']]);
    $last_id = $bdd->lastInsertId();
    $_POST['id'] = $last_id;
}


/*if (!empty($_POST['heureSemaine']) && isset($_POST['dateDebut']) && isset($_POST['dateFin']) && !empty($_POST['dateFin']) && !empty($_POST['dateDebut'])) {
    $dateDebut = date('d', strtotime($_POST['dateDebut']));
    $dateDebutm = date('m', strtotime($_POST['dateDebut']));
    $dateDebuty = date('Y', strtotime($_POST['dateDebut']));


    $dateFin = date('d', strtotime($_POST['dateFin']));
    $dateFinm = date('m', strtotime($_POST['dateFin']));
    $dateFiny = date('Y', strtotime($_POST['dateFin']));
    //debug($today['mon']);
    $verifdJ = $today['mday'] - $dateDebut;
    $verifdM = $today['mon'] - $dateDebutm;

    $veriffJ = $today['mday'] - $dateFin;
    $veriffM = $today['mon'] - $dateFinm;


    if (abs($verifdJ) > 0 && abs($verifdM) > 0) {
        header('location: ../index.php?erreur=erreurdateDebut');
        exit;
    }

    if (abs($veriffJ) > 0 && abs($veriffM) > 0) {
        header('location: ../index.php?erreur=erreurdatefin');
        exit;
    }
}*/

if (!empty($_POST['heureSemaine']) && isset($_POST['dateDebut']) && isset($_POST['dateFin']) && !empty($_POST['dateFin']) && !empty($_POST['dateDebut'])) {

    $insert = $bdd->prepare("INSERT INTO " . $name . "(heureSemaine,dateDebut,dateFin,name,idUser)" . "VALUES (?,?,?,?,?)");
    $insert->execute([$_POST['heureSemaine'], $_POST['dateDebut'], $_POST['dateFin'], $name, $_SESSION['id']]);
    $last_id = $bdd->lastInsertId();
    $_POST['id'] = $last_id;
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
        $dateDebut = date('d', strtotime($_POST['dateDebut']));
        $dateFin = date('d', strtotime($_POST['dateFin']));
        $dateDif = $dateFin - $dateDebut;
    }

    /*
     * Conversion heure en int pour le multiplier avec le prix par heures
     * 10:25 --> mettre 10h en minutes, y ajouter les 25 mins, reconversion du tout en heure * le prix unitaire
     */
    if (!empty($_POST['heureSemaine']) && isset($_POST['heureSemaine'])) {
        $stockHmin = idate('H', $hour) * 60;
        $totalH = (idate('i', $hour) + $stockHmin) / 60;
        $result = $totalH * $rows['price'];
    }

    if (!empty($_POST['heureSemaine']) && isset($_POST['heureSemaine'])) {
        if (isset($rows["price"])) {

            $insert = $bdd->prepare(" UPDATE " . $name . " SET price = " . $result . " WHERE id =" . $last_id);
            $insert->execute([$result]);

            $vide = 'image_vide';
            $_POST['price'] = $result;
            $_POST['idUser'] = $_SESSION['id'];
            $_POST['description'] = "reservation";
            $_POST['image'] = $vide;
            $_POST['order_id'] = 0;
        }

        $req = $bdd->prepare("SELECT * FROM " . $name . " WHERE id =" . $last_id);
        $req->execute();
        $price = $req->fetchAll(PDO::FETCH_ASSOC);
    }
}

/*
 * Insertion des champs inconnus
 */

$desc = $bdd->prepare(" DESCRIBE " . $name);
$desc->execute();
$try = $desc->fetchAll(PDO::FETCH_ASSOC);

foreach ($try as $values) {
    if ($values['Type'] != 'int(11)' && $values['Type'] != 'double' && $values['Type'] != 'date' && $values['Type'] != 'time' && $values['Type'] != 'datetime' && $values['Type'] != 'timestamp' && $values['Type'] != 'float') {
        // Concaténation pour que ça passe en string
        $_POST[$values['Field']] = "'" . $_POST[$values['Field']] . "'";
    }
    $req = $bdd->prepare(" UPDATE " . $name . " SET " . $values['Field'] . "= " . $_POST[$values['Field']] . " WHERE id = " . $last_id);
    $req->execute([$_POST[$values['Field']]]);
}

if (!empty($_POST['heureSemaine']) && isset($_POST['heureSemaine'])) {
    $total_price = 0;
    $item_details = '';
    $order_details = '
      <div class="table-responsive" id="order_table">
       <table class="table table-bordered table-striped">
          <tr>
            <th>Nom Service</th>
            <th>Nombre Heures Au Jour</th>
            <th>Prix Horaire</th>
            <th>Total</th>
          </tr>
     ';

    if (!empty($price)) {
        foreach ($price as $rows) {
            $order_details .= '
              <tr>
               <td>' . $rows["name"] . '</td>
               <td>' . $rows["heureSemaine"] . '</td>
               <td align="right"> ' . $constprice . '€</td>
               <td align="right"> ' . number_format($rows["price"], 2, '.', '') . '€</td>
              </tr>

            ';
        }

    }
    $result_cmd = number_format($rows["price"], 2, '.', '');
    $item_details = $rows["name"];
    $order_details .= '</table></div>';

}

if (!empty($_POST['dateDebut']) && !empty($_POST['dateFin']) && isset($_POST['dateDebut']) && isset($_POST['dateDebut']) && !empty($_POST['heureSemaine']) && isset($_POST['heureSemaine'])) {
    $total_price = 0;
    $item_details = '';
    $order_details = '
        <div class="table" id="order_table">
         <table class="table table-bordered table-striped">
              <tr>
                <th>Nom Service</th>
                <th>Nombre Heures Semaine</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Nombre de Jour de service</th>
                <th>Prix horaire</th>
                <th>Total</th>
            </tr>
     ';

    if (!empty($price)) {
        foreach ($price as $rows) {
            $order_details .= '
              <tr>
               <td>' . $rows["name"] . '</td>
               <td>' . $rows["heureSemaine"] . '</td>
               <td>' . $rows["dateDebut"] . '</td>
               <td>' . $rows["dateFin"] . '</td>
               <td>' . abs($dateDif) . '</td>
            
               <td align="right"> ' . $constprice . '€</td>
               <td align="right"> ' . number_format($rows["price"], 2, '.', '') . '€</td>
              </tr>
             ';
        }

    }
    $result_cmd = number_format($rows["price"], 2, '.', '');
    $item_details = $rows["name"];
    $order_details .= '</table></div>';
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://js.stripe.com/v2/"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="js/jquery.creditCardValidator.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Payment Home</title>
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
                            <li><a href="#">Contact</a></li>
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


<div class="container">
    <br/>
    <br/>
    <span id="message"></span>
    <div class="panel panel-default">
        <div class="panel-heading">Information de paiement</div>

        <div class="panel-body">
            <form method="post" id="order_process_form" action="back_office/payment.php">
                <div class="row">
                    <div class="col-md-8" style="border-right:1px solid #ddd;">
                        <h4 align="center">Details client</h4>
                        <div class="form-group">
                            <label><b>Propriétaire de la carte <span class="text-danger">*</span></b></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" value=""/>
                            <span id="error_customer_name" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label><b>Adresse mail <span class="text-danger">*</span></b></label>
                            <input type="text" name="email_address" id="email_address" class="form-control" value=""/>
                            <span id="error_email_address" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label><b>Adresse <span class="text-danger">*</span></b></label>
                            <textarea name="customer_address" id="customer_address" class="form-control"></textarea>
                            <span id="error_customer_address" class="text-danger"></span>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><b>Ville <span class="text-danger">*</span></b></label>
                                    <input type="text" name="customer_city" id="customer_city" class="form-control"
                                           value=""/>
                                    <span id="error_customer_city" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><b>Code postal <span class="text-danger">*</span></b></label>
                                    <input type="text" name="customer_pin" id="customer_pin" class="form-control"
                                           value=""/>
                                    <span id="error_customer_pin" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><b>Département </b></label>
                                    <input type="text" name="customer_state" id="customer_state" class="form-control"
                                           value=""/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $req = $bdd->prepare('SELECT * FROM pays ORDER BY nom_fr_fr');
                                $req->execute();
                                $country = $req->fetchAll(PDO::FETCH_ASSOC);

                                ?>
                                <div class="form-group">
                                    <label><b>Pays <span class="text-danger">*</span></b></label>
                                    <select class="custom-select my-1 mr-sm-2" name="customer_country"
                                            id="customer_country">
                                        <?php $cont = 0;
                                        foreach ($country as $countrys) { ?>
                                            <option value="<?= $country[$cont]['nom_fr_fr'] ?>"><?= $country[$cont]['nom_fr_fr'] ?></option>
                                        <?php $cont = $cont + 1; } ?>
                                    </select>
                                    <span id="error_customer_country" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <h4 align="center">Detail de paiement</h4>
                        <div class="form-group">
                            <label>Numero de carte <span class="text-danger">*</span></label>
                            <input type="text" name="card_holder_number" id="card_holder_number" class="form-control"
                                   placeholder="1234 5678 9012 3456" maxlength="20" onkeypress=""/>
                            <span id="error_card_number" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Mois d'expiration</label>
                                    <input type="text" name="card_expiry_month" id="card_expiry_month"
                                           class="form-control" placeholder="MM" maxlength="2"
                                           onkeypress="return only_number(event);"/>
                                    <span id="error_card_expiry_month" class="text-danger"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Année expiration</label>
                                    <input type="text" name="card_expiry_year" id="card_expiry_year"
                                           class="form-control" placeholder="YYYY" maxlength="4"
                                           onkeypress="return only_number(event);"/>
                                    <span id="error_card_expiry_year" class="text-danger"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>CVC</label>
                                    <input type="text" name="card_cvc" id="card_cvc" class="form-control"
                                           placeholder="123" maxlength="4" onkeypress="return only_number(event);"/>
                                    <span id="error_card_cvc" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div align="center">
                            <input type="hidden" name="total_amount" value="<?php echo $result_cmd; ?>"/>
                            <?php // debug($result_cmd);?>
                            <input type="hidden" name="currency" value="EUR"/>
                            <input type="hidden" name="item_details" value="<?php echo $item_details; ?>"/>
                            <input type="hidden" name="last_id" value="<?php echo $last_id; ?>"/>

                            <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm"
                                   onclick="stripePay(event)" value="Payer"/>
                        </div>
                        <br/>
            </form>
        </div>
        <div class="col-md-4">
            <h4 align="center">Information de commande</h4>
            <?php
            echo $order_details;
            ?>
        </div>
    </div>
    </form>
</div>
</div>
</div>
</body>


<footer>
    <br>
    <img src="../img/logo.png" width="80">
    <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
        <small> Concierge Expert - All rights reserved © </small></div>
    <br>
</footer>

</html>

<script src="payment.js"></script>
