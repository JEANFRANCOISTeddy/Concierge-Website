<?php
  include '../config.php';

  $nameCategorie = $_POST['nameCategorie'];

  if (isset($_POST['columnName']) && !empty($_POST['columnName'])){
      if( strpos($_POST['columnName']," ") != FALSE ){
        $columnName = str_replace(" ","_",$_POST['columnName']);
      }else{
        $columnName = $_POST['columnName'];
      }
  }


  if (isset($_POST['type']) && !empty($_POST['type'])){
      $type = $_POST['type'];
  }

  if ($type === "VARCHAR" || $type === "CHAR"){
    if (isset($_POST['size']) && !empty($_POST['size'])){
      $size = $_POST['size'];
      $req = $bdd->prepare("ALTER TABLE " . $nameCategorie . " ADD " . $columnName . " ". $type . "(" . $size . ")");
      $req->execute();
      header("Location: reservation_back.php?service=" . $_GET['service'] );
    }else{
      echo "Entrez une taille valide";
      exit;
    }
  } else if ($type === "INT"){
    $newSize = 11;
    $req = $bdd->prepare("ALTER TABLE " . $nameCategorie . " ADD " . $columnName . " ". $type . "(" . $newSize . ")");
    $req->execute();
    header("Location: reservation_back.php?service=" . $_GET['service'] );
    exit;
  } else {
    $req = $bdd->prepare("ALTER TABLE " . $nameCategorie . " ADD " . $columnName . " ". $type);
    $req->execute();
    header("Location: reservation_back.php?service=" . $_GET['service'] );
  }

?>
