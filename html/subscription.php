<?php session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Abonnement</title>
</head>

<body class="">

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

    <main></br>
        <div class="container">
            <div class="row centered-form">
            <br><div class="col-lg-12 col-sm-12 col-xs-12">
                <center><h3 class="font">Nos abonnements de base</h3>
                <?php
                if (isset($_SESSION['id']))
                {
                  $req=$bdd->query('SELECT subscriptionType FROM SUBSCRIPTION WHERE idUser =' . $_SESSION['id']);
                  $subscription = $req->fetch(PDO::FETCH_ASSOC);
                  echo 'Abonnement actuel pour votre compte : <b>' . (isset($subscription['subscriptionType']) ? $subscription['subscriptionType'] : 'Aucun')  . '</b></center>';
                }

                 ?>
                  <?php
                  if(isset($_GET['error']) && $_GET['error'] == 'connected') {
                      echo '<center><p style="color: red;">Il faut être connecté pour s\'abonner</p></center>';
                  }

                  if(isset($_GET['error']) && $_GET['error'] == 'subscribed') {
                      echo '<center><p style="color: red;">Vous êtes déjà abonné</p>';
                  }
                  ?>
                </div>
                <?php
                  $req2 = $bdd->prepare("SELECT * FROM SUBSCRIPTION_TYPE");
                  $req2->execute();

                  if ($req2->rowCount() > 0) {
                    while ($row = $req2->fetch(PDO::FETCH_ASSOC)) {
                      if( $row['name'] == 'Abonnement Premium' || $row['name'] == 'Abonnement Familial' || $row['name'] == 'Abonnement de base' ){ ?>


                        <div class="col-lg-4 col-sm-6 col-xs-12" id="<?= $row['name']; ?>">
                          <div class="card text-center box" style=""><br>
                              <center><img class="size" width="110px" height="110px"
                                           src="<?= 'subscription/' . $row['image']; ?>"></center>
                            <div class="card-body">
                                <h5 class="card-title" style="text-align: center"><?= $row['name']; ?></h5>
                                <h6 class="card-title" style="text-align: center">Prix : <?= $row['price']; ?>€ TTC/an</h6>
                                <p class="card-text" style="text-align: center"><?= $row['description']; ?></p>
                                <?php
                                    $hourStart = intdiv($row['hourStart'],100);
                                    if( ($row['hourStart'] % 100) < 10){
                                      $minuteStart = "0" . ($row['hourStart'] % 100);
                                    }else{
                                      $minuteStart = ($row['hourStart'] % 100);
                                    }

                                    $hourEnd = intdiv($row['hourEnd'],100);
                                    if( ($row['hourEnd'] % 100) < 10){
                                      $minuteEnd = "0" . ($row['hourEnd'] % 100);
                                    }else{
                                      $minuteEnd = ($row['hourEnd'] % 100);
                                    }
                                 ?>
                                <p class="card-text" style="text-align: center">Possibilités de réservation <?= $row['daysWeek']; ?>j/7 de <?= $hourStart; ?>h<?= $minuteStart; ?> à <?= $hourEnd; ?>h<?= $minuteEnd; ?></p>
                                <p class="card-text" style="text-align: center"><?= $row['hoursMonth']; ?>h de services/mois</p>
                                <center><a href="subscription/valid_subscription.php?subscription=<?= $row['name']; ?>" class="btn btn-primary">S'abonner</a></center>
                            </div>
                          </div>
                        </div>
                        <?php } } ?>
                      <?php } ?>
              </div>
            </div>

      <div class="container">
        <div class="row centered-form"><br>
          <div class="col-lg-12 col-sm-12 col-xs-12">
            <center><h3 class="font">Nos abonnements additionels</h3>
          </div>
        </div>
      </div>

      <div class="container">
          <div class="row centered-form" id="parent">
            <?php
              $req2 = $bdd->prepare("SELECT * FROM SUBSCRIPTION_TYPE");
              $req2->execute();

              if ($req2->rowCount() > 0) {
                while ($row = $req2->fetch(PDO::FETCH_ASSOC)) {
                  if( $row['name'] != 'Abonnement Premium' && $row['name'] != 'Abonnement Familial' && $row['name'] != 'Abonnement de base' ){?>


                    <div class="col-lg-4 col-sm-6 col-xs-12" id="<?= $row['name']; ?>">
                      <div class="card text-center box" style=""><br>
                          <center><img class="size" width="110px" height="110px"
                                       src="<?= 'subscription/' . $row['image']; ?>"></center>
                        <div class="card-body">
                            <h5 class="card-title" style="text-align: center"><?= $row['name']; ?></h5>
                            <h6 class="card-title" style="text-align: center">Prix : <?= $row['price']; ?>€ TTC/an</h6>
                            <p class="card-text" style="text-align: center"><?= $row['description']; ?></p>
                            <?php
                              $hourStart = intdiv($row['hourStart'],100);
                              if( ($row['hourStart'] % 100) < 10){
                                $minuteStart = "0" . ($row['hourStart'] % 100);
                              }else{
                                $minuteStart = ($row['hourStart'] % 100);
                              }

                              $hourEnd = intdiv($row['hourEnd'],100);
                              if( ($row['hourEnd'] % 100) < 10){
                                $minuteEnd = "0" . ($row['hourEnd'] % 100);
                              }else{
                                $minuteEnd = ($row['hourEnd'] % 100);
                              }
                             ?>
                            <p class="card-text" style="text-align: center">Possibilités de réservation <?= $row['daysWeek']; ?>j/7 de <?= $hourStart; ?>h<?= $minuteStart; ?> à <?= $hourEnd; ?>h<?= $minuteEnd; ?></p>
                            <p class="card-text" style="text-align: center"><?= $row['hoursMonth']; ?>h de services/mois</p>
                            <center><a href="subscription/valid_subscription.php?subscription=<?= $row['name']; ?>" class="btn btn-primary">S'abonner</a>
                              <?php
                                $connected = isset($_SESSION['mail']) && $_SESSION['mail'] == 'concierge_expert@gmail.com' ? true : false;
                                if ($connected) {
                              ?>
                            <input type="button" value="X" class="btn btn-danger" onclick="deleteSubscription('<?= $row['name'] ?>')"></center>
                              <?php } ?>
                        </div>
                      </div>
                    </div>
                    <?php } } ?>
                  <?php } ?>
              </div>
            </div></br>
        <?php
            $connected = isset($_SESSION['mail']) && $_SESSION['mail'] == 'concierge_expert@gmail.com' ? true : false;
            if ($connected) {
          ?>
            <center><a href="subscription/add_subscription.php">
                    <button type="button" class="btn btn-primary">Ajouter un abonnement</button>
                </a></center>
            <br>
          <?php } ?>

          <script type="text/javascript" src="subscription/sub.js"></script>
    </main>

  <footer>
      <br>
      <img src="../img/logo.png" width="80">
      <div><small>Conçu par : JAUCH Anthony - BURIOT Vincent - JEAN-FRANCOIS Teddy</small><br>
          <small> Concierge Expert - All rights reserved © </small></div>
      <br>
  </footer>
</body>

</html>
