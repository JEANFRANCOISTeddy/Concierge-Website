<?php
include 'searchSubcategories.php';

if(isset($_POST['research'])) {
    //get all subcategories
    $sc = searchSubcategories();

    for ($i = 0; $i < count($sc); $i++) {
        if ($sc[$i][0] == $_POST['research']) {
          echo '<center>';
          echo '<div class="col-lg-3 col-sm-6 col-xs-12">';
            echo '<div class="card text-center box" style="width: 15rem;">';
              echo '<center><img class="size" width="100px" height="100px" src="back_office/' . $sc[$i][1] . '"></center>';
            echo '<br>';
              echo '<div class="card-body">';
              echo '<h5 class="card-title"><h4><b>'. $sc[$i][0] . '</h4></b></h5>';
                echo '<form style="text-align: center" action="subcategory.php" method="post">';
                    echo '<input type="hidden" name="categorie" value="' . $sc[$i][2] . '">';
                    echo '<input type="hidden" name="name" value="' . $sc[$i][0] . '">';
                        $connected = isset($_SESSION['mail']) ? true : false;
                        if ($connected) {
                            echo '<input type="submit" value="Réserver" class="btn btn-success">';
                        } else {
                            echo '<a href="connection.php" class="btn btn-success">Connectez-vous</a>';
                        }
                echo '</form>';
              echo '<br>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
          echo '</center>';
          exit;
        }
    }
    echo '<p>Ce service n\'existe pas</p>';
}
