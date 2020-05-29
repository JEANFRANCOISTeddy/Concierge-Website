<?php

include 'config.php';

$mail = $_POST['mail'];
$password = hash('sha256', $_POST['password']);

$reqCon = $bdd -> prepare("SELECT id FROM client WHERE mail = ? AND password = ?");
$reqCon->execute(array($mail, $password));
$result = $reqCon->fetch();

if (empty($result)) {
    header('location: connection.php?error=password');
    exit;
} else {
    session_start();
    $_SESSION['mail'] = $mail;
    $_SESSION['id'] = $result['id'];
    header("location: ../index.php?connection=ok");
    exit;
}