<?php

function searchSubcategories() {
    include 'config.php';
    $category = [];
    $subCategory = [];
    $i = 0;
    $j = 0;
    $req2 = $bdd->prepare("SELECT name FROM SERVICE");
    $req2->execute();
    if ($req2->rowCount() > 0) {
        while ($row2 = $req2->fetch(PDO::FETCH_ASSOC)) {
            $category[$i] = $row2['name'];
            $i++;
        }
    }
    for($i = 0; $i < count($category); $i++){
        $reqTest = $bdd->prepare("SELECT name, image FROM " . $category[$i]);
        $reqTest->execute();
        if ($reqTest->rowCount() > 0) {
            while ($row3 = $reqTest->fetch(PDO::FETCH_ASSOC)) {
                $subCategory[$j][0] = $row3['name'];
                $subCategory[$j][1] = $row3['image'];
                $subCategory[$j][2] = $category[$i];
                $j++;
            }
        }
    }
    return $subCategory;

} ?>
