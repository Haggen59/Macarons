<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les allergènes</title>
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
        <section id="allergenes">
            <h2>Colorants</h2>
            <p>Les colorants alimentaires utilisés pour donner des couleurs vives aux macarons peuvent contenir divers allergènes. Ils peuvent être d'origine naturelle ou synthétique. Les colorants naturels peuvent contenir des traces de fruits, de légumes ou de plantes auxquels certaines personnes sont allergiques. Les colorants synthétiques, quant à eux, peuvent provoquer des réactions chez les personnes sensibles à certains additifs chimiques.</p>
        </section>
        
        <section id="allergenes">
            <h2>Poudre d'Amandes</h2>
            <p>La poudre d'amandes est un ingrédient fondamental des macarons. Les amandes appartiennent à la catégorie des fruits à coque, qui sont des allergènes courants. Une allergie aux amandes peut provoquer des réactions sévères comme des éruptions cutanées, des gonflements, des troubles respiratoires et dans les cas extrêmes, un choc anaphylactique.</p>
        </section>
        
        <section id="allergenes">
            <h2>Œufs</h2>
            <p>Les œufs, surtout les blancs, sont essentiels pour la structure aérée des macarons. L'allergie aux œufs est fréquente, notamment chez les enfants, et peut provoquer des symptômes variés allant de légères réactions cutanées à des problèmes gastro-intestinaux ou des réactions anaphylactiques graves.</p>
        </section>
        
        <section id="allergenes">
            <h2>Poudre de Noisette</h2>
            <p>La poudre de noisette peut parfois remplacer la poudre d'amandes. Les noisettes sont également des fruits à coque et peuvent causer des réactions allergiques similaires à celles des amandes. Les symptômes peuvent inclure des démangeaisons, des gonflements, des difficultés respiratoires et des chocs anaphylactiques.</p>
        </section>
        
        <section id="allergenes">
            <h2>Sucre Glace</h2>
            <p>Le sucre glace est couramment utilisé pour donner une texture lisse aux macarons. Bien qu'il soit généralement sans danger, certaines marques peuvent ajouter de l'amidon, parfois dérivé du blé, pour éviter l'agglutination, ce qui peut poser problème aux personnes allergiques au gluten ou atteintes de la maladie cœliaque.</p>
        </section>
        
        <section id="allergenes">
            <h2>Sucre en Poudre</h2>
            <p>Le sucre en poudre est utilisé pour la douceur des macarons. Comme le sucre glace, il est en général sans danger pour les personnes allergiques. Toutefois, il est toujours prudent de vérifier l'étiquette pour s'assurer qu'il ne contient aucun additif pouvant provoquer des allergies.</p>
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