<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Foire Aux Questions</title>
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
        <section id="faq">
            <h1>FAQ</h1>
            <h2>Questions Fréquemment Posées</h2>
            <div class="faq-item">
                <h3>1. Comment puis-je passer une commande ?</h3>
                <p>Pour passer une commande, vous pouvez utiliser notre site web ou notre application mobile. Sélectionnez vos plats préférés, ajoutez-les au panier, et suivez les instructions pour finaliser la commande.</p>
            </div>
            <div class="faq-item">
                <h3>2. Quels sont les modes de paiement acceptés ?</h3>
                <p>Nous acceptons divers modes de paiement, y compris les cartes de crédit, les cartes de débit, PayPal, et certains services de paiement mobile. Veuillez vérifier les options disponibles lors de la finalisation de votre commande.</p>
            </div>
            <div class="faq-item">
                <h3>3. Puis-je suivre ma commande en temps réel ?</h3>
                <p>Oui, une fois votre commande passée, vous recevrez un lien de suivi en temps réel par SMS ou par email. Vous pouvez également suivre l'état de votre commande directement via notre application.</p>
            </div>
            <div class="faq-item">
                <h3>4. Que faire si ma commande est incorrecte ou endommagée ?</h3>
                <p>Si votre commande est incorrecte ou endommagée, veuillez contacter notre service client immédiatement via le formulaire de contact sur notre site web ou en appelant notre numéro d'assistance. Nous ferons le nécessaire pour résoudre le problème rapidement.</p>
            </div>
            <div class="faq-item">
                <h3>5. Est-ce que je peux modifier ou annuler ma commande après l'avoir passée ?</h3>
                <p>Vous pouvez modifier ou annuler votre commande tant qu'elle n'a pas encore été préparée par le restaurant. Veuillez nous contacter dès que possible pour toute modification ou annulation.</p>
            </div>
            <div class="faq-item">
                <h3>6. Quelle est votre politique de remboursement ?</h3>
                <p>Si vous n'êtes pas satisfait de votre commande, nous évaluerons les réclamations au cas par cas. Les remboursements peuvent être émis pour des commandes incorrectes, endommagées ou manquantes, selon notre politique de remboursement.</p>
            </div>
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
    
    <script src="js\scripts.js"></script>

</body>
</html>
