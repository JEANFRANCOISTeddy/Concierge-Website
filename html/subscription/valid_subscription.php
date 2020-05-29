<?php session_start();

require_once '../config.php';

function debug($variable)
{
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

if (isset($_SESSION['mail']) && !empty($_SESSION['mail'])) {
    $req = $bdd->prepare('SELECT id FROM subscription WHERE idUser = ?');
    $req->execute(array($_SESSION['id']));
    $res = $req->fetch();

    $req2 = $bdd->prepare('SELECT price FROM subscription_type WHERE name = ?');
    $req2->execute(array($_GET['subscription']));
    $res2 = $req2->fetch();

    if (!empty($res)) {
        header('location: ../subscription.php?error=subscribed');
        exit;
    }

} else {
    header('location: ../subscription.php?error=connected');
    exit;
} ?>

<?php
$req3 = $bdd->prepare('SELECT * FROM subscription_type WHERE name = ?');
$req3->execute(array($_GET['subscription']));
$res3 = $req3->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;

$item_details = '';

$order_details = '
<div class="table" id="order_table">
 <table class="table table-bordered table-striped">
      <tr>
        <th>Nom Abonnement</th>
        <th>Nombre Heures Mois</th>
        <th>Nombre de Jour disponible par semaine</th>
        <th>Prix Abonnement</th>
        <th>Total</th>
    </tr>
';
if (!empty($res3)) {
    foreach ($res3 as $rows) {
        //debug($rows);
        $order_details .= '
            <tr>
   <td>' . $rows["name"] . '</td>
   <td>' . $rows["hoursMonth"] . '</td>
    <td>' . $rows["daysWeek"] . '</td>
   <td align="right"> ' . $rows['price'] . '€</td>
   <td align="right"> ' . $rows['price'] . '€</td>
  </tr>

            ';
    }

}
$result_cmd = number_format($rows['price']);
$item_details = $rows["name"];
$order_details .= '</table></div>';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://js.stripe.com/v2/"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="../js/jquery.creditCardValidator.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">


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
                            <li><a href="../../index.php">Accueil</a></li>
                            <li><a href="../service.php">Services</a></li>
                            <a href="../../index.php" id="logo"><img src="../../img/logo.png" width="150px" alt="logo"></a>
                            <li><a href="#">Contact</a></li>
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


<div class="container">
    <br/>
    <br/>
    <span id="message"></span>
    <div class="panel panel-default">
        <div class="panel-heading">Information de paiement</div>

        <div class="panel-body">
            <form method="post" id="order_process_form"
                  action="../back_office/payment.php?subscription=<?= $_GET['subscription']; ?>">
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
                                    <label><b>Vile <span class="text-danger">*</span></b></label>
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
                                        <?php $cont = 0; ?>
                                        <?php $cont = $cont + 1; ?>
                                        <?php foreach ($country as $countrys): ?>
                                            <option value="<?= $country[$cont]['nom_fr_fr'] ?>"><?= $country[$cont]['nom_fr_fr'] ?></option>
                                            <?php $cont = $cont + 1; ?>
                                        <?php endforeach; ?>
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
                            <input type="hidden" name="total_amount" value="<?php echo $res2['price']; ?>"/>
                            <?php // debug($result_cmd);?>
                            <input type="hidden" name="currency" value="EUR"/>
                            <input type="hidden" name="item_details" value="<?php echo $item_details; ?>"/>

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
    <img src="../../img/logo.png" width="80">
    <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
        <small> Concierge Expert - All rights reserved © </small></div>
    <br>
</footer>
</html>


<script src="../payment.js"></script>
