<?php

session_start();
include('connect_commande.php');

if (isset($_POST['checkout'])) {
    $email = $_POST['email'];
    $total_cost = $_POST['total_cost'];
    $promo_code = $_POST['promo_code'];
    $montant_promo = $_POST['montant_promo'];
    $shipping_cost = $_POST['shipping_cost'];
    $final_cost = $_POST['final_cost'];
    $methode_paiement = $_POST['methode_paiement'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $telephone = $_POST['telephone'];
    $cart_data = json_decode($_POST['cart_data'], true);

    $conn->begin_transaction();

    try {
        $insertOrderQuery = "INSERT INTO ventes(email, total_cost, promo_code, montant_promo, shipping_cost, final_cost, payment_method) VALUES ('$email', '$total_cost', '$promo_code', '$montant_promo', '$shipping_cost', '$final_cost', '$methode_paiement')";
        $conn->query($insertOrderQuery);

        $order_id = $conn->insert_id;

        $insertShippingQuery = "INSERT INTO shipping_infos(order_id, prénom, nom, email, adresse, ville, code_postal, téléphone) VALUES ('$order_id', '$prenom', '$nom', '$email', '$adresse', '$ville', '$code_postal', '$telephone')";
        $conn->query($insertShippingQuery);

        foreach ($cart_data as $item) {
            $nom_produit = $item['name'];
            $quantite = $item['quantity'];
            $prix_unitaire = $item['price'];
            $insertOrderItemsQuery = "INSERT INTO macarons_vendus (order_id, nom_produit, quantité, prix_unitaire) VALUES ('$order_id', '$nom_produit', '$quantite', '$prix_unitaire')";
            $conn->query($insertOrderItemsQuery);
        }

        $conn->commit();

        $macarons_commandes = "";
        $orderItemsQuery = mysqli_query($conn, "SELECT * FROM macarons_vendus WHERE order_id='$order_id'");
        while ($itemRow = mysqli_fetch_array($orderItemsQuery)) {
            $nom_produit = htmlspecialchars($itemRow['nom_produit']);
            $quantite = htmlspecialchars($itemRow['quantité']);
            $prix_unitaire = htmlspecialchars($itemRow['prix_unitaire']);
            $macarons_commandes .= "$nom_produit - Quantité : $quantite - Prix unitaire : $prix_unitaire €\n";
        }

        $receiver = $email;
        $subject = "Confirmation de votre commande";
        $body = "
        Bonjour $prenom $nom,

        Merci pour votre commande. Voici le récapitulatif de vos achats :

        Montant total : $total_cost €
        Code Promo : $promo_code
        Montant Réduction : $montant_promo €
        Frais de livraison : $shipping_cost €
        Montant final : $final_cost €
        Méthode de paiement : $methode_paiement

        Date de commande : $order_date

        Macarons commandés : 
        $macarons_commandes

        Informations de livraison :
        Prénom : $prenom
        Nom : $nom
        Adresse : $adresse
        Ville : $ville
        Code Postal : $code_postal
        Téléphone : $telephone

        Nous vous enverrons un mail lors de l'envoi de votre commande avec le numéro de suivi, sauf si remise en main propre.

        Cordialement,
        Antoine Floure
        ";

        $sender = "From: Antoine Floure <antoineflouremacarons@gmail.com>";

        if(mail($receiver, $subject, $body, $sender)){
            echo "Email envoyé à $receiver";
        }else{
            echo "Désolé, échec de l'envoi du mail.";
        }

        $_SESSION['cart'] = [];
        $_SESSION['order_id'] = $order_id;

        header("Location: confirmation.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
