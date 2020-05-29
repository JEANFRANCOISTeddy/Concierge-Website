<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-11 col-xs-12">
                <nav>
                    <div class="align">
                        <ul>
                            <li><a href="#">Accueil</a></li>
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
