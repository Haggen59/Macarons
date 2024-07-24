<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
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
        <div class="container" id="signIn">
            <h1 class="form-title">Se connecter</h1>
            <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="motDePasse" id="motDePasse" placeholder="Mot de passe" required>
            </div>
            <p class="recover">
                <a href="#">Mot de passe oublié ?</a>
            </p>
            <input type="submit" class="btn" value="Se connecter" name="signIn">
            </form>
            <div class="links">
            <p>Pas encore de compte ?</p>
            <button id="signUpButton" onclick="window.location.href = 'enregistrement.php';">S'enregistrer</button>
            </div>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message <?php echo $_SESSION['message_type']; ?>" id="connexionMessage">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
                <?php unset($_SESSION['message_type']); ?>
            <?php endif; ?>
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js\scripts.js"></script>

</body>
</html>
