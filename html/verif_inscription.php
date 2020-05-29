<?php

include 'config.php';

$firstName = htmlspecialchars($_POST['firstName']);
$lastName = htmlspecialchars($_POST['lastName']);
$mail = htmlspecialchars($_POST['mail']);
$password = hash( 'sha256',$_POST['password']);
$address = htmlspecialchars($_POST['address']);
$phoneNumber = htmlspecialchars($_POST['phoneNumber']);

if(isset($mail) && !empty($mail)) {

    $reqMail = $bdd -> prepare("SELECT id FROM client WHERE mail = ?");
    $reqMail -> execute(array($mail));
    $answers = [];
    while ($aMail = $reqMail->fetch()) {
        $answers[] = $aMail;
    }

    if (count($answers) != 0) {
        header('Location: inscription.php?error=mail_taken');
        exit;
    }

    if (isset($firstName) && !empty($firstName) &&
        isset($lastName) && !empty($lastName) &&
        isset($password) && !empty($password) &&
        isset($address) && !empty($address) &&
        isset($phoneNumber) && !empty($phoneNumber)) {

        $req = $bdd -> prepare("INSERT INTO client(firstName, lastName, mail, password, address, tel) 
                                        VALUES (:firstName, :lastName, :mail, :password, :address, :tel)");

        $req -> execute(array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'mail' => $mail,
                'password' => $password,
                'address' => $address,
                'tel' => $phoneNumber
            )
        );

        header('Location: ../index.php?inscription=ok');
    }
}



