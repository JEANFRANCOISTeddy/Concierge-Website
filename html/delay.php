<?php

  function delay($id){
    include 'config.php';

    $req = $bdd->prepare("SELECT * FROM SUBSCRIPTION WHERE idUser = ?");
    $req->execute([
      $id
    ]);

    if ($req->rowCount() > 0) {
      while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['subscriptionType'];
        $req2 = $bdd->prepare("SELECT * FROM SUBSCRIPTION_TYPE WHERE name = ?");
        $req2->execute([
          $name
        ]);

        if ($req2->rowCount() > 0) {
          while ($row2 = $req2->fetch(PDO::FETCH_ASSOC)) {
            $start=$row2['hourStart'];
            $end=$row2['hourEnd'];

            $hour=(idate('H') * 100) + 200;
            $minutes=idate('i');
            $total=$hour + $minutes;

            if( $total >= $start && $total <= $end){
              return true;
            }else{
              return false;
            }

          }
        }

      }
    } else {
      return false;
    }

  }

 ?>
