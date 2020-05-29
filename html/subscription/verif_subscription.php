<?php

var_dump($_POST);
include '../config.php';
require_once '../back_office/class/Subscription.php';

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
                $fileDestination = 'img/' . $fileNameNew . '.' . $fileActualExtension;
                move_uploaded_file($fileTmpName, $fileDestination);

                $nameSubscription = $_POST['name'];
                $price = $_POST['price'];
                $hoursMonth = $_POST['hoursMonth'];
                $description = $_POST['description'];
                $daysWeek = $_POST['daysWeek'];

                $hourStart = strtotime($_POST['hourStart']);
                $hour =  idate('H',$hourStart) * 100;
                $minute =  idate('i',$hourStart);
                $start = $hour + $minute;

                $hourEnd = strtotime($_POST['hourEnd']);
                $hour2 =  idate('H',$hourEnd) * 100;
                $minute2 =  idate('i',$hourEnd);
                $end = $hour2 + $minute2;

                //Insertion en bdd
                $mySubscription = new Subscription($nameSubscription,$fileDestination,$price,$hoursMonth,$description,$start,$end,$daysWeek);
                $mySubscription->getName();echo '<br>';
                $mySubscription->getImage();echo '<br>';
                $mySubscription->getPrice();echo '<br>';
                $mySubscription->getHours();echo '<br>';
                $mySubscription->getDescription();echo '<br>';
                $mySubscription->getHourStart();echo '<br>';
                $mySubscription->getHourEnd();echo '<br>';
                $mySubscription->getDaysWeek();echo '<br>';
                $mySubscription->insertBdd($nameSubscription,$fileDestination,$price,$hoursMonth,$description,$start,$end,$daysWeek);


            } else {
                header('Location: add_subscription.php?error=size');
                exit;
            }
        } else {
            header('Location: add_subscription.php?error=corrupted');
            exit;
        }
    } else {
        header('Location: add_subscription.php?error=type');
        exit;
    }

  } else {
      header('Location: add_subscription.php?error=empty');
      exit;
  }

 ?>
