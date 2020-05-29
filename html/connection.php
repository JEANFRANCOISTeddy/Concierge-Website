<?php
include 'config.php';
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <title>Connexion</title>
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
                        <center><h3 class="font">Connexion</h3></center>
                    </div>
                    <div class="panel-body">
                        <form action="verif_connection.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12 col-xl-126">
                                    <div class="form-group">
                                        <?php
                                        if (isset($_GET['error']) && $_GET['error'] == 'password') {
                                            echo '<p style="color:red">Votre mail ou votre mot de passe est incorrect</p>';
                                        }
                                        ?>
                                        <label class="font">Mail : </label>
                                        <input type="text" name="mail" placeholder="Mail" class="form-control input-md"
                                               multiple><br>
                                        <label class="font">Mot de passe : </label>
                                        <input type="password" name="password" placeholder="Mot de passe"
                                               class="form-control input-sm"><br>
                                        <a href="inscription.php" class="btn btn-success">S'inscrire</a>
                                    </div>
                                </div>
                            </div>
                            <center><input type="submit" name="" value="Se connecter" class="btn btn-primary"></center>
                            <br>
                        </form>
                        <form action="../index.php" method="POST">
                            <center><input type="submit" name="" value="Retour" class="btn btn-danger"></center>
                        </form>
                    </div>
                </div>
            </div>
    </body>

    </html>
<?php
