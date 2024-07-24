<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Mac</title>
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
        <h1>Le Mac</h1>
        <p>Le macaron classique réalisé à base de meringue italienne.</p>
        <div class="product-container">
            <div class="image-container">
                <canvas id="merged-image" width="300" height="300"></canvas>
            </div>
            <div class="options-container">
                <div class="option">
                    <h3>Couleur de coque</h3>
                    <div class="colors" data-type="color1">
                        <div class="color-circle" data-color="rouge" data-image="images/le_mac_rouge.png" style="background-color: #c92f2d;"></div>
                        <div class="color-circle" data-color="rose" data-image="images/le_mac_rose.png" style="background-color: #ff5a80;"></div>
                        <div class="color-circle" data-color="violet" data-image="images/le_mac_violet.png" style="background-color: #7d1167;"></div>
                        <div class="color-circle" data-color="bleu" data-image="images/le_mac_bleu.png" style="background-color: #627097;"></div>
                        <div class="color-circle" data-color="vert" data-image="images/le_mac_vert.png" style="background-color: #a5ba4e;"></div>
                        <div class="color-circle" data-color="jaune" data-image="images/le_mac_jaune.png" style="background-color: #ead626;"></div>
                        <div class="color-circle" data-color="orange" data-image="images/le_mac_orange.png" style="background-color: #e08012;"></div>
                    </div>
                </div>
                <div class="option">
                    <h3>Composition</h3>
                    <div class="custom-select">
                        <div class="selected-option">mix poudres amandes et noisettes<i class="fas fa-chevron-down dropdown-icon"></i></div>
                        <div class="options-composition">
                            <div class="option-item" data-value="poudre d'amandes" data-info="Information sur la poudre d'amandes">poudre d'amandes <i class="fas fa-info-circle info-icon"></i></div>
                            <div class="option-item" data-value="poudre de noisettes" data-info="Information sur la poudre de noisettes">poudre de noisettes <i class="fas fa-info-circle info-icon"></i></div>
                            <div class="option-item" data-value="mix poudres amandes et noisettes" data-info="Information sur le mix de poudres amandes et noisettes">mix poudres amandes et noisettes <i class="fas fa-info-circle info-icon"></i></div>
                        </div>
                    </div>
                </div>
                <div class="option">
                    <h3>Saveur</h3>
                    <div class="colors" data-type="color2">
                        <div class="color-circle" data-color="framboise" data-image="images/filling-framboise.png" style="background-image: url('images/framboise.png');"></div>
                        <div class="color-circle" data-color="chocolat blanc" data-image="images/filling-chocolat-blanc.png" style="background-image: url('images/chocolat-blanc.png');"></div>
                        <div class="color-circle" data-color="nutella" data-image="images/filling-nutella.png" style="background-image: url('images/nutella.png');"></div>
                        <div class="color-circle" data-color="pistache" data-image="images/filling-pistache.png" style="background-image: url('images/pistache.png');"></div>
                        <div class="color-circle" data-color="myrtille" data-image="images/filling-myrtille.png" style="background-image: url('images/myrtille.png');"></div>
                        <div class="color-circle" data-color="citron" data-image="images/filling-citron.png" style="background-image: url('images/citron.png');"></div>
                        <div class="color-circle" data-color="coca" data-image="images/filling-coca.png" style="background-image: url('images/coca.png');"></div>
                    </div>
                </div>
                <div class="option">
                    <h3>Taille</h3>
                    <div class="sizes" data-type="size">
                        <div class="size-circle" data-size="S">S</div>
                        <div class="size-circle" data-size="M">M</div>
                        <div class="size-circle" data-size="L">L</div>
                    </div>
                </div>
                <div class="option">
                    <h3>Quantité</h3>
                    <div class="quantity-selection">
                        <input type="number" id="quantity" value="1" min="1">
                        <div class="quantity-buttons">
                            <button onclick="increaseInput()">&#9650;</button>
                            <button onclick="decreaseInput()">&#9660;</button>
                        </div>
                    </div>
                </div>
                <div class="option">
                    <h3>Prix unitaire</h3>
                    <p id="price">0.75€</p>
                </div>
                <button id="add-to-cart">Ajouter au panier</button>
                <p id="add-to-cart-message"></p>
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