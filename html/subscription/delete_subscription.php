<?php
  include '../config.php';

  $req = $bdd->query('DELETE FROM subscription_type WHERE name = "' . $_POST['subscriptionName'] .'"');

 ?>
