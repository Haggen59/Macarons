<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "newsletter";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    $_SESSION['message'] = "Failed to connect to DB: " . $conn->connect_error;
    $_SESSION['message_type'] = "error";
    header("Location: index.php#newsletter");
    exit();
}

$email = $_POST['email'];
$checkEmail = "SELECT * FROM subs WHERE email='$email'";
$result = $conn->query($checkEmail);

if ($result->num_rows > 0) {
    $_SESSION['message'] = "Cette adresse mail est déjà utilisée !";
    $_SESSION['message_type'] = "error";
} else {
    $insertQuery = "INSERT INTO subs(email) VALUES ('$email')";
    if ($conn->query($insertQuery) === TRUE) {
        $_SESSION['message'] = "Merci pour votre inscription à notre newsletter !";
        $_SESSION['message_type'] = "success";

        $receiver = $email;
        $subject = "Inscription à la newsletter";
        $body = "
        Bonjour,

        Merci pour votre inscription à notre newsletter.

        Cordialement,
        Antoine Floure
        ";
        $sender = "From: Antoine Floure <antoineflouremacarons@gmail.com>";

        if (!mail($receiver, $subject, $body, $sender)) {
            $_SESSION['message'] = "Désolé, échec de l'envoi du mail.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Erreur : " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
}

header("Location: index.php#newsletter");
exit();
?>
