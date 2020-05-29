<?php

  try {
    $bdd = new PDO('mysql:host=localhost;dbname=concierge_expert;charset=UTF8','tedanvi','kLKLxEe8M1EfOdvG');
  }
  catch(PDOException $error){
    echo ' Problème de connexion à la base de donnée '.$error;
    die();
  }

?>
