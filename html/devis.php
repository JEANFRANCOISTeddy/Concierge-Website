<?php
  ini_set('display_errors', 'off');
  include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Devis</title>
</head>

<body class="bodi">
<div class="container">
    <div class="">
        <center><img src="../img/logo.png" width="200px"></center>
    </div>
    <br>
    <div class="row centered-form">
        <div class="col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><h3 class="font">Demande de devis</h3></center><br>
                </div>
                <div class="panel-body">
                    <form action="jsDevis.php" method="POST" enctype="multipart/form-data" id="formDevis">
                      <?php
                        if (isset($_GET['error']) && $_GET['error'] === 'empty') {
                            echo '<small> *Les champs doivent tous être remplis ! </small><br>';
                        }
                        if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
                            echo '<small> *Email non valide ! </small><br>';
                        }
                        ?>
                      <!-- Catégorie de prestation -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">

                                    <?php
                                      include 'searchSubcategories.php';
                                      $subCategory = searchSubcategories();
                                    ?>
                                    <label class="font">Sélectionner une catégorie de prestation</label><br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ls-form">
                                              <?php for($j=0; $j < count($subCategory) ;$j++){ ?>
                                                 <div><input type="checkbox" name="choix[]" value="<?= $subCategory[$j][0]; ?>"><?= str_replace('_',' ',$subCategory[$j][0]); ?></div>
                                               <?php } ?>
                                           </div>
                                       </div>
                                   </div>
                                    </br>
                                </div>
                            </div>
                        </div>
                        <!-- Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form">
                                    <label class="font">Nom : </label>
                                    <input type="text" name="lastName" placeholder="Nom"
                                           class="form-control input-sm formInput"></br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form">
                                    <label class="font">Prénom : </label>
                                    <input type="text" name="firstName" placeholder="Prénom"
                                           class="form-control input-sm formInput"></br>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="md-form">
                            <label class="font">Numéro de téléphone : </label>
                            <input type="number" name="phoneNumber" placeholder="Téléphone"
                                   class="form-control input-sm formInput"></br>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="md-form">
                            <label class="font">Adresse e-mail : </label>
                            <div id="errorEmail"></div>
                            <input type="text" name="email" placeholder="E-mail"
                                   class="form-control input-sm formInput" id="email" onblur="verif_mail()"></br>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="md-form">
                            <label class="font">Code postal : </label>
                            <input type="number" name="postalCode" placeholder="Code postal"
                                   class="form-control input-sm formInput"></br>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="md-form">
                            <label class="font">Ville : </label>
                            <input type="text" name="city" placeholder="Ville"
                                   class="form-control input-sm formInput"></br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <center><input type="submit" name="" value="Valider" class="btn btn-primary"></center>
    </br>
    </form>
    <form action="../index.php" method="POST">
        <center><input type="submit" name="" value="Retour" class="btn btn-danger"></center>
    </form>
    </br>
  </div>
</div>
  <script type="text/javascript" src="devis.js"></script>
</body>


</html>
