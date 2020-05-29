<?php
  include '../config.php';

  $req = $bdd->query('SELECT name FROM ' . $_POST['categoryName']);
  if ($req->rowCount() > 0) {
      while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        $req2 = $bdd->query('DROP TABLE ' . $row['name']);
      }
  }

  $req3 = $bdd->query('DROP TABLE ' . $_POST['categoryName']);
  $req4 = $bdd->query('DELETE FROM service WHERE name = "' . $_POST['categoryName'] .'"');
 ?>
