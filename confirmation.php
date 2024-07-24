<?php
session_start();
include('connect_commande.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="burger" onclick="toggleMenu()">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <div class="logo">
            <a href="index.php"><img src="images/logo_blanc.png" class="logo"></a>
        </div>
        <div id="cart">
            <a href="panier.php"><i class="fas fa-shopping-cart"></i> Panier (<span id="cart-count">0</span>)</a>
            <div id="cart-hover">
                <p id="empty-cart-message">Votre panier est vide.</p>
                <div id="cart-items"></div>
                <p id="total-price">Total: 0€</p>
                <a href="panier.php" style="color:#56200b"><i class="fas fa-shopping-cart"></i>       Procéder au paiement</a>
            </div>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="produits.php">Nos Produits</a></li>
            <li><a href="allergenes.php">Allergènes</a></li>
            <li><a href="livraison.php">Livraison</a></li>
            <li><a href="tarifs.php">Détail des prix</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="contact.php">Nous contacter</a></li>
            <?php if (isset($_SESSION['email']) && !empty($_SESSION['email'])): ?>
                <li><a href="compte.php">Mon compte</a></li>
            <?php else: ?>
                <li><a href="connexion.php">Mon compte</a></li>
            <?php endif; ?>
        </ul>
    </header>

    <main>
        <div id="confirmation-details">
            <?php 
            $email = $order_date = $total_cost = $promo_code = $montant_promo = $shipping_cost = $final_cost = $payment_method = $prenom = $nom = $adresse = $ville = $code_postal = $telephone = $status = '';
            if (isset($_SESSION['order_id'])) {
                $order_id = $_SESSION['order_id'];
                $ordersQuery = mysqli_query($conn, "SELECT * FROM ventes WHERE order_id='$order_id'");
                $shippingQuery = mysqli_query($conn, "SELECT * FROM shipping_infos WHERE order_id='$order_id'");
                if ($orderRow = mysqli_fetch_array($ordersQuery)) {
                    $email = htmlspecialchars($orderRow['email']);
                    $order_date = htmlspecialchars($orderRow['order_date']);
                    $total_cost = htmlspecialchars($orderRow['total_cost']);
                    $promo_code = htmlspecialchars($orderRow['promo_code']);
                    $montant_promo = htmlspecialchars($orderRow['montant_promo']);
                    $shipping_cost = htmlspecialchars($orderRow['shipping_cost']);
                    $final_cost = htmlspecialchars($orderRow['final_cost']);
                    $payment_method = htmlspecialchars($orderRow['payment_method']);
                    $status = htmlspecialchars($orderRow['status']);
                }
                if ($shippingRow = mysqli_fetch_array($shippingQuery)) {
                    $prenom = htmlspecialchars($shippingRow['prénom']);
                    $nom = htmlspecialchars($shippingRow['nom']);
                    $adresse = htmlspecialchars($shippingRow['adresse']);
                    $ville = htmlspecialchars($shippingRow['ville']);
                    $code_postal = htmlspecialchars($shippingRow['code_postal']);
                    $telephone = htmlspecialchars($shippingRow['téléphone']);
                }
            }
            ?>
            
            <h2>Merci pour votre commande !</h2>
            <p>Votre commande a été passée avec succès. Un mail récapitulatif de votre commande va vous être envoyé.</p>
            <p>Vous trouverez ci-dessous les détails de votre commande :</p>
            
            <h3>Informations de la commande</h3>
            <p>Statut de la commande : <?php echo $status; ?></p>
            <p>Numéro de suivi :</p>

            <h3>Articles commandés</h3>
            <?php 
            $orderItemsQuery = mysqli_query($conn, "SELECT * FROM macarons_vendus WHERE order_id='$order_id'");
            while ($itemRow = mysqli_fetch_array($orderItemsQuery)) {
                echo "<p>" . htmlspecialchars($itemRow['nom_produit']) . " - Quantité : " . htmlspecialchars($itemRow['quantité']) . " - Prix unitaire : " . htmlspecialchars($itemRow['prix_unitaire']) . "€</p>";
            }
            ?>
            
            <h3>Résumé de la commande</h3>
            <p>Date de commande : <?php echo $order_date; ?></p>
            <p>Montant : <?php echo $total_cost; ?>€</p>
            <p>Code Promo : <?php echo $promo_code; ?></p>
            <p>Montant Réduction : <?php echo $montant_promo; ?>€</p>
            <p>Frais de livraison : <?php echo $shipping_cost; ?>€</p>
            <p>Total : <?php echo $final_cost; ?>€</p>
            <p>Méthode de paiement : <?php echo $payment_method; ?></p>

            <h3>Informations de livraison</h3>
            <p>Prénom : <?php echo $prenom; ?></p>
            <p>Nom : <?php echo $nom; ?></p>
            <p>Email : <?php echo $email; ?></p>
            <p>Adresse : <?php echo $adresse; ?></p>
            <p>Ville : <?php echo $ville; ?></p>
            <p>Code Postal : <?php echo $code_postal; ?></p>
            <p>Téléphone : <?php echo $telephone; ?></p>
        </div>
    </main>

    <footer>
        <div class="social-icons">
            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.pinterest.com" target="_blank"><i class="fab fa-pinterest"></i></a>
            <a href="https://www.tiktok.com" target="_blank"><i class="fab fa-tiktok"></i></a>
            <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p>&copy; 2024 Antoine Floure. Tous droits réservés.</p>
    </footer>
    <script src="js/scripts.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            localStorage.removeItem("cart");
            document.getElementById("cart-count").textContent = "0";
            document.getElementById("empty-cart-message").style.display = "block";
            document.getElementById("cart-items").innerHTML = "";
            document.getElementById("total-price").textContent = "Total: 0€";
        });
    </script>
</body>
</html>