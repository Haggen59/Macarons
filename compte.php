<?php
session_start();
include("connect.php");
$prenom = $nom = $email = $adresse = $ville = $code_postal = $telephone = '';
if(isset($_SESSION['email'])){
    $email=$_SESSION['email'];
    $query=mysqli_query($conn, "SELECT utilisateurs.* FROM `utilisateurs` WHERE utilisateurs.email='$email'");
    if($row=mysqli_fetch_array($query)){
        $prenom = trim($row['Prénom']);
        $nom = trim($row['Nom']);
        $adresse = trim($row['Adresse']);
        $ville = trim($row['Ville']);
        $code_postal = trim($row['Code_Postal']);
        $telephone = trim($row['Téléphone']);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
    $ville = mysqli_real_escape_string($conn, $_POST['ville']);
    $code_postal = mysqli_real_escape_string($conn, $_POST['code_postal']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);

    $sql = "UPDATE utilisateurs SET 
                Prénom='$prenom', 
                Nom='$nom', 
                Adresse='$adresse', 
                Ville='$ville', 
                Code_Postal='$code_postal', 
                Téléphone='$telephone' 
            WHERE email='$email'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Informations mises à jour avec succès.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de la mise à jour des informations : " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
    }

    header("Location: compte.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>
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
    <div class="informations-compte">
    <form id="guest-delivery-form" method="POST">
        <label for="guest-first-name">Prénom:</label>
        <input type="text" id="guest-first-name" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>">
        
        <label for="guest-last-name">Nom:</label>
        <input type="text" id="guest-last-name" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
        
        <label for="guest-email">Email:</label>
        <input type="email" id="guest-email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
        
        <label for="guest-address">Adresse:</label>
        <input type="text" id="guest-address" name="adresse" value="<?php echo htmlspecialchars($adresse); ?>">
        
        <label for="guest-city">Ville:</label>
        <input type="text" id="guest-city" name="ville" value="<?php echo htmlspecialchars($ville); ?>">
        
        <label for="guest-postcode">Code postal:</label>
        <input type="text" id="guest-postcode" name="code_postal" value="<?php echo htmlspecialchars($code_postal); ?>">
        
        <label for="guest-phone">Numéro de téléphone:</label>
        <input type="tel" id="guest-phone" name="telephone" value="<?php echo htmlspecialchars($telephone); ?>">
    </form>
    </div>
    <div class="modifier-informations">
        <button id="modifierInformations" onclick="document.getElementById('guest-delivery-form').submit();">Enregistrer ces informations</button>
    </div>
    <div class="logout">
    <button id="logout" onclick="window.location.href = 'logout.php';">Se déconnecter</a></button>
    </div>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message <?php echo $_SESSION['message_type']; ?>" id="compteMessage">
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