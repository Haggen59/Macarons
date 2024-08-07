<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
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
        <section id="presentation">
            <h2>Bienvenue chez Antoine Floure</h2>
            <p>Découvrez nos macarons faits maison, personnalisables selon vos envies.</p>
        </section>
        
        <section id="products">
            <h2>Nos macarons à personnaliser</h2>
            <div class="product" onclick="location.href='le_mac.php'">
                <h3>Le Mac</h3>
                <img src="images/le_mac.png" alt="Le Mac">
            </div>
            <div class="product" onclick="location.href='le_tete_brulee.php'">
                <h3>Le Tête Brûlée</h3>
                <img src="images/le_tete_brulee.png" alt="Le Tête Brûlée">
            </div>
        </section>
        
        <section id="preparation">
            <h2>La préparation des macarons</h2>
            <div class="slider">
                <div class="slides">
                    <div class="slide"><img src="images/preparation1.jpg" alt="Préparation des macarons 1"></div>
                    <div class="slide"><img src="images/preparation2.jpg" alt="Préparation des macarons 2"></div>
                    <div class="slide"><img src="images/preparation3.jpg" alt="Préparation des macarons 3"></div>
                    <div class="slide"><img src="images/preparation4.jpg" alt="Préparation des macarons 4"></div>
                    <div class="slide"><img src="images/preparation5.jpg" alt="Préparation des macarons 5"></div>
                    <div class="slide"><img src="images/preparation6.jpg" alt="Préparation des macarons 6"></div>
                </div>
                <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                <button class="next" onclick="moveSlide(1)">&#10095;</button>
            </div>
        </section>

        <section id="reviews">
            <h2>Les avis des goûteurs</h2>
            <div class="review">
                <p>"Les macarons sont délicieux et le service est impeccable !"</p>
                <p>- Marie</p>
            </div>
            <div class="review">
                <p>"Des saveurs uniques et une qualité irréprochable. Je recommande vivement !"</p>
                <p>- Jean</p>
            </div>
        </section>
        
        <section id="newsletter">
            <h2>Inscrivez-vous à la newsletter</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message <?php echo $_SESSION['message_type']; ?>" id="indexMessage">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
                <?php unset($_SESSION['message_type']); ?>
            <?php endif; ?>
            <form method="POST" action="newsletter_signup.php">
                <input type="email" name="email" placeholder="Votre adresse email" required>
                <button type="submit">S'inscrire</button>
            </form>
        </section>
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
    <script src="js/scripts.js"></script>

</body>
</html>
