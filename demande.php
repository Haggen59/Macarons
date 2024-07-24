<?php
session_start();

$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$sujet = $_POST['subject'];
$message = $_POST['message'];

$receiver = "antoineflouremacarons@gmail.com";
$subject = "$sujet";
$body = "Ce message a été envoyé par $prenom $nom.

$message

Email de réponse : $email";

$sender = "From: Antoine Floure <antoineflouremacarons@gmail.com>";

if (mail($receiver, $subject, $body, $sender)) {
    $_SESSION['message'] = "Email envoyé à $receiver";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Désolé, échec de l'envoi du mail.";
    $_SESSION['message_type'] = "error";
}

header("Location: contact.php");
exit;
?>