<?php

require_once 'class/Service.php';

if (isset($_FILES['image']) && !empty($_FILES['image'])) {

    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name']; //Stockage temporaire du fichier
    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];

    $fileExtension = explode('.', $fileName); //Scinde une chaîne de caractères en segments (qui sont séparés par un '.')
    $fileActualExtension = strtolower(end($fileExtension)); //end -> récupère la dernière valeur du tableau
    //strtolower -> renvoie une chaine en minuscule

    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($fileActualExtension, $allowed)) { //On cherche si le type est présent dans notre tableau
        if ($fileError === 0) {
            if ($fileSize < 3000000) { //La taille du fichier doit être inférieur a 3mb
                $fileNameNew = date('Y-m-d-H-i-s'); //Renvoie un identifiant unique
                $fileDestination = 'images/' . $fileNameNew . '.' . $fileActualExtension;
                move_uploaded_file($fileTmpName, $fileDestination);

                //Insertion en bdd

                $addIndex = $_POST['addIndex'];

                if( strpos($_POST['name']," ") != FALSE ){
                  $nameCategorie = str_replace(" ","_",$_POST['name']);
                }else{
                  $nameCategorie = $_POST['name'];
                }

                $myService = new Service($nameCategorie,$fileDestination,$addIndex);
                $myService->getName();echo '<br>';
                $myService->getImage();echo '<br>';
                $myService->getIndex();echo '<br>';
                $myService->insertBdd($nameCategorie,$fileDestination,$addIndex);

            } else {
                header('Location: add_service.php?error=size');
                exit;
            }
        } else {
            header('Location: add_service.php?error=corrupted');
            exit;
        }
    } else {
        header('Location: add_service.php?error=type');
        exit;
    }

  } else {
      header('Location: add_service.php?error=empty');
      exit;
  }

 ?>
