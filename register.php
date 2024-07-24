<?php
include 'connect.php';
session_start();

if(isset($_POST['signUp'])){
    $Prénom = $_POST['prenom'];
    $Nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['motDePasse'];
    $password = md5($password);

    $checkEmail = "SELECT * FROM utilisateurs WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        $_SESSION['message'] = "Cette adresse mail est déjà utilisée !";
        $_SESSION['message_type'] = "error";
    } else {
        $insertQuery = "INSERT INTO utilisateurs(Prénom,Nom,email,password)
                        VALUES ('$Prénom','$Nom','$email','$password')";
        if($conn->query($insertQuery) === TRUE){
            $_SESSION['message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            $_SESSION['message_type'] = "success";
            header("Location: connexion.php");
            exit();
        } else {
            $_SESSION['message'] = "Erreur: " . $conn->error;
            $_SESSION['message_type'] = "error";
        }
    }
    header("Location: enregistrement.php");
    exit();
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['motDePasse'];
    $password = md5($password);

    $sql = "SELECT * FROM utilisateurs WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['message'] = "Connexion réussie.";
        $_SESSION['message_type'] = "success";
        header("Location: compte.php");
        exit();
    } else {
        $_SESSION['message'] = "Email ou mot de passe incorrect.";
        $_SESSION['message_type'] = "error";
        header("Location: connexion.php");
        exit();
    }
}
?>
