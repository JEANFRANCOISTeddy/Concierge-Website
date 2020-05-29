<?php
  include '../config.php';

  $nameCategorie = $_POST['nameCategorie'];
  $array = $_POST['array']; //récupération de tous les éléments le la liste 3
  $newArray = explode(',',$array); //stockage dans un nouveau tableau

  for($i = 0; $i < count($newArray); $i++){
    $req = $bdd->prepare("ALTER TABLE " . $nameCategorie . " DROP " . $newArray[$i]);
    $req->execute();
  }

 ?>
