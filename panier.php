<?php
session_start();
include('connect.php');
$prenom = $nom = $email = $adresse = $ville = $code_postal = $telephone = '';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = mysqli_query($conn, "SELECT utilisateurs.* FROM `utilisateurs` WHERE utilisateurs.email='$email'");
    if ($row = mysqli_fetch_array($query)) {
        $prenom = trim($row['Prénom']);
        $nom = trim($row['Nom']);
        $adresse = trim($row['Adresse']);
        $ville = trim($row['Ville']);
        $code_postal = trim($row['Code_Postal']);
        $telephone = trim($row['Téléphone']);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
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
    <div id="cart-details">
        <h2>Votre Panier</h2>
        <div id="cart-content">
            <div id="cart-items"></div>
            <p id="empty-cart-message">Votre panier est vide.</p>
            <p id="total-price">Total: 0.00€</p>
            <p id="promo">Code promo: 0.00€</p>
            <p id="livraison">Livraison: 8.00€</p>
            <p id="final-price">Total à régler: 0.00€</p>
        </div>
        <div class="promo-code-section">
            <label for="promo-code">Code promo</label>
            <input type="text" id="promo-code">
            <button id="apply-promo">Appliquer</button>
        </div>
        <p id="promo-message"></p>
        <button id="empty-cart">Vider le panier</button>

        <h2>Moyens de paiement</h2>
        <div class="payment-methods">
            <div class="payment-option">
                <input type="radio" name="payment_method" value="paypal" id="paypal" checked>
                <label for="paypal">
                    <img src="images/paypal.png" alt="PayPal">
                    PayPal
                </label>
            </div>
            <div class="payment-option">
                <input type="radio" name="payment_method" value="credit-card" id="credit-card">
                <label for="credit-card">
                    <img src="images/credit-card.png" alt="Carte de crédit">
                    Carte de crédit
                </label>
            </div>
            <div class="payment-option">
                <input type="radio" name="payment_method" value="cash-on-delivery" id="cash-on-delivery">
                <label for="cash-on-delivery">
                    <img src="images/cash.png" alt="Paiement en main propre">
                    Paiement en main propre
                </label>
            </div>
        </div>

        <h2>Informations de livraison</h2>
        <div class="delivery-info-section">
            <?php if (!isset($_SESSION['email'])): ?>
            <div class="login-create">
                <h3>Déjà client ?</h3>
                <button id="signUpButton" onclick="window.location.href = 'connexion.php';">Se connecter</button>
                <h3>Envie de nous rejoindre ?</h3>
                <button id="signUpButton" onclick="window.location.href = 'enregistrement.php';">Créer un compte</button>
            </div>
            <div class="guest-delivery-info">
                <h3>Ou</h3>
                <h3>Continuer en tant qu'invité</h3>
            
            </div>
            <?php endif; ?>
            <form id="checkout" method="POST" action="commande.php">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" <?php echo isset($_SESSION['email']) ? 'readonly' : 'required'; ?>>
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($adresse); ?>" required>
                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville" value="<?php echo htmlspecialchars($ville); ?>" required>
                <label for="code_postal">Code postal:</label>
                <input type="text" id="code_postal" name="code_postal" value="<?php echo htmlspecialchars($code_postal); ?>" required>
                <label for="telephone">Numéro de téléphone:</label>
                <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($telephone); ?>" required>
                <input type="hidden" name="cart_data" id="cart_data" value='<?php echo json_encode($_SESSION['cart']); ?>'>
                <input type="hidden" name="promo_code" value='<?php echo htmlspecialchars($promoValidee); ?>'>
                <input type="hidden" name="montant_promo" value='<?php echo htmlspecialchars($montant_promo); ?>'>
                <input type="hidden" name="methode_paiement" value='<?php echo htmlspecialchars($methode_paiement); ?>'>
                <input type="hidden" name="shipping_cost" value='<?php echo htmlspecialchars($shipping_cost); ?>'>
                <input type="hidden" name="total_cost" value='<?php echo htmlspecialchars($total_cost); ?>'>
                <input type="hidden" name="final_cost" value='<?php echo htmlspecialchars($final_cost); ?>'>
                <button type="submit" name="checkout" id="checkout-button">Valider la commande</button>
                <p id="empty-cart-warning" style="color: red; display: none;">Merci d'ajouter des articles à votre panier.</p>
            </form>
        </div>
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
</body>
</html>
