<?php
session_start();
include('connect.php');
$prenom = $nom = $email = '';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = mysqli_query($conn, "SELECT utilisateurs.* FROM `utilisateurs` WHERE utilisateurs.email='$email'");
    if ($row = mysqli_fetch_array($query)) {
        $prenom = trim($row['Prénom']);
        $nom = trim($row['Nom']);
        $email = trim($row['email']);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous contacter</title>
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
        <h1>Nous contacter</h1>
        <form id="contact-form" method="POST" action="demande.php">
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <label for="subject">Sujet:</label>
                <input type="text" id="subject" name="subject" required>
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit">Envoyer</button>
        </form>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>" id="contactMessage">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['message_type']); ?>
        <?php endif; ?>
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
