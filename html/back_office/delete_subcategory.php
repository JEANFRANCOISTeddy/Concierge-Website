<?php
  include '../config.php';

  $req = $bdd->query('DELETE FROM ' . $_POST['categoryName'] .' WHERE name = "' . $_POST['subCategory'] . '"');
  $req2 = $bdd->query('DROP TABLE ' . $_POST['subCategory']);

?>
