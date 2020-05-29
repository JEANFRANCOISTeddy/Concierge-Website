<?php

Class Subscription{
    private $nameSubscription;
    private $image;
    private $price;
    private $hoursMonth;
    private $description;
    private $hourStart;
    private $hourEnd;
    private $daysWeek;

    public function __construct(string $nameSubscription, string $image, int $price, int $hoursMonth, string $description, float $hourStart, float $hourEnd, int $daysWeek){
        $this->nameSubscription = $nameSubscription;
        $this->image = $image;
        $this->price = $price;
        $this->hoursMonth = $hoursMonth;
        $this->description = $description;
        $this->hourStart = $hourStart;
        $this->hourEnd = $hourEnd;
        $this->daysWeek = $daysWeek;
    }

    public function getName(): string{
        return $this->nameSubscription;
    }

    public function getImage(): string{
        return $this->image;
    }

    public function getPrice(): int{
        return $this->price;
    }

    public function getHours(): int{
        return $this->hoursMonth;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function getHourStart(): float{
        return $this->hourStart;
    }

    public function getHourEnd(): float{
        return $this->hourEnd;
    }

    public function getDaysWeek(): int{
        return $this->daysWeek;
    }

    public function insertBdd($nameSubscription,$image,$price,$hoursMonth,$description,$hourStart,$hourEnd,$daysWeek){
      include '../config.php';

      if (isset($nameSubscription) && !empty($nameSubscription) &&
        isset($image) && !empty($image) &&
        isset($price) && !empty($price) &&
        isset($hoursMonth) && !empty($hoursMonth) &&
        isset($description) && !empty($description) &&
        isset($hourStart) && !empty($hourStart) &&
        isset($hourEnd) && !empty($hourEnd)  &&
        isset($daysWeek) && !empty($daysWeek) ){

        $req3 = $bdd -> prepare("INSERT INTO SUBSCRIPTION_TYPE(name,price,hoursMonth,image,description,hourStart,hourEnd,daysWeek) VALUES (:name,:price,:hoursMonth,:image,:description,:hourStart,:hourEnd,:daysWeek)");
        $req3 -> execute(array(
          'name' => htmlspecialchars($nameSubscription),
          'price' => htmlspecialchars($price),
          'hoursMonth' => htmlspecialchars($hoursMonth),
          'image' => htmlspecialchars($image),
          'description' => htmlspecialchars($description),
          'hourStart' => htmlspecialchars($hourStart),
          'hourEnd' => htmlspecialchars($hourEnd),
          'daysWeek' => htmlspecialchars($daysWeek)
          )
        );
        header('Location: ../subscription.php');
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
            'NameSubscription' => $this->nameSubscription,
            'Image' => $this->image,
            'Price' => $this->price,
            'HoursMonth' => $this->hoursMonth,
            'Description' => $this->description,
            'HourStart' => $this->hourStart,
            'HourEnd' => $this->hourEnd,
            'DaysWeek' => $this->daysWeek,
        ];
    }

}

?>
