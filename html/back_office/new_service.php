<?php
include '../config.php';

$string = "";
$i = 0;
$variable = array();
$name = $_GET['service'];
foreach ($_POST as $key => $value) {
    if ($key != 'description') {
        $key = $value;
        $variable[$i] = explode(" ", $key);
        $i++;
    }
}

if ((isset($_POST['columName']) && !empty($_POST['columName'])) &&
    (isset($_POST['price']) && !empty($_POST['price'])) && (isset($_POST['description']) && !empty($_POST['description'])) && isset($_FILES['image'])) {

    if( strpos($_POST['columName']," ") != FALSE ){
      $columName = str_replace(" ","_",$_POST['columName']);
    }else{
      $columName = $_POST['columName'];
    }

    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $variable[0];

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

                for ($j = 3; $j < count($variable); $j++) {
                    $string .= "," . $variable[$j][0] . " " . $variable[$j][1];
                }

                $req = $bdd->prepare("CREATE TABLE " . $variable[0][0] . "(id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,name VARCHAR(50), image VARCHAR(255),  price DOUBLE,description TEXT, heureSemaine TIME" . $string . ", idUser INT REFERENCES CLIENT(id), order_id INT(11) NULL )");
                $req->execute();

                $req2 = $bdd->prepare("INSERT INTO " . $variable[0][0] . "(name,image, price, description) VALUES(:name,:image, :price, :description)");
                $req2->execute(array(
                        'name' => htmlspecialchars($variable[0][0]),
                        'image' => htmlspecialchars($fileDestination),
                        'price' => htmlspecialchars($variable[1][0]),
                        'description' => htmlspecialchars($_POST['description'])
                    )
                );

                $req3 = $bdd->prepare("INSERT INTO " . $name . "(name,image) VALUES(:name,:image)");
                $req3->execute(array(
                        'name' => htmlspecialchars($variable[0][0]),
                        'image' => htmlspecialchars($fileDestination)
                    )
                );

                header('Location: ../../index.php');

            } else {
                header('Location: reservation_back.php?service=' . $name . '&error=size');
                exit;
            }
        } else {
            header('Location: reservation_back.php?service=' . $name . '&error=corrupted');
            exit;
        }
    } else {
        header('Location: reservation_back.php?service=' . $name . '&error=type');
        exit;
    }

} else {
    header('Location: reservation_back.php?service=' . $name . '&error=empty');
    exit;
}

?>
