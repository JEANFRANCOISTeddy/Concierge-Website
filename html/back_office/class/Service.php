<?php

Class Service{
    private $nameCategorie;
    private $image;
    private $addIndex;

    public function __construct(string $nameCategorie, string $image, string $addIndex){
        $this->nameCategorie = $nameCategorie;
        $this->image = $image;
        $this->addIndex = $addIndex;
    }

    public function getName(): string{
        return $this->nameCategorie;
    }

    public function setName(string $n): string{
        $this->nameCategorie = $n;
    }

    public function getImage(): string{
        return $this->image;
    }

    public function setImage(string $img): string{
        $this->image = $img;
    }

    public function getIndex(): string{
        return $this->addIndex;
    }

    public function setIndex(string $addIndex): string{
        $this->addIndex = $addIndex;
    }

    public function insertBdd($nameCategorie,$image,$addIndex){
      include '../config.php';

      if (isset($nameCategorie) && !empty($nameCategorie)){
        $req = $bdd -> prepare("CREATE TABLE " . $nameCategorie . "( id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255),image VARCHAR(255), heureSemaine TIME, date DATE, dateDebut DATE, dateFin DATE )");
        $req -> execute();

        $req3 = $bdd -> prepare("INSERT INTO SERVICE(name, image,add_index) VALUES (:name, :image,:add_index)");
        $req3 -> execute(array(
            'name' => htmlspecialchars($nameCategorie),
            'image' => htmlspecialchars($image),
            'add_index' => htmlspecialchars($addIndex)
          )
        );
        header('Location: ../../index.php');
      }else{
        header('Location: verif_service.php');
        echo "<small> *Un champs de saisie est vide ou invalide ! </small><br>";
      }

    }

    public function __toString(): string{
        return json_encode($this->getFields());
    }

    protected function getFields(): array {
        return [
            'Name' => $this->name,
            'Image' => $this->image,
            'AddIndex' => $this->addIndex
        ];
    }

}

?>
