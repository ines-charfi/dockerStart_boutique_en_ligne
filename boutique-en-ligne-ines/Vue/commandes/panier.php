<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - MERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style1.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/boutique.js"></script>
    <script src="assets/js/panier.js"></script>
</head>
<body>
<?php include 'Vue\bases\header.php'; ?>

<div class="container">
    <a href="index.php?page=boutique" class="btn">Retour à la boutique</a>
    <a href="index.php?page=accueil" class="btn">Retour à l'accueil</a><br><br>

    <h2>Votre panier</h2>
    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert error"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']) ?>
<?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert success"><?= $_SESSION['success'] ?></div>
    <?php endif; ?>

    <?php if (empty($panier)) : ?>
        <p>Votre panier est vide.</p>
        <a href="index.php?page=boutique" class="btn">Voir la boutique</a>
    <?php else: ?>
       
        <table class="panier-table">
    <thead>
        <tr>
            <th>Livre</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($panier as $item): ?>
            <tr>
                <td data-label="Livre"><?= htmlspecialchars($item['titre']) ?></td>
                <td data-label="Quantité"><?= $item['quantite'] ?></td>
                <td data-label="Prix unitaire"><?= number_format($item['prix'], 2) ?> €</td>
                <td data-label="Total"><?= number_format($item['prix'] * $item['quantite'], 2) ?> €</td>
            </tr>
            <?php $total += $item['prix'] * $item['quantite']; ?>
        <?php endforeach; ?>
        <tr class="panier-total">
            <td colspan="3" style="text-align:right;"><strong>Total</strong></td>
            <td><strong><?= number_format($total, 2) ?> €</strong></td>
        </tr>
    </tbody>
</table><br>


        <p>Vous avez <?= count($panier) ?> livre(s) dans votre panier.</p>
        <p>Pour valider votre commande, cliquez sur le bouton ci-dessous.</p>
       <form method="post" action="index.php?page=valider_commande">
    <h3>Paiement (simulation)</h3>
    <div class="form-group">
        <label for="nom">Nom sur la carte :</label>
        <input type="text" name="nom" id="nom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="numero">Numéro de carte :</label>
        <input type="text" name="numero" id="numero" class="form-control" maxlength="16" required>
    </div>
    <div class="form-group">
        <label for="expiration">Date d'expiration :</label>
        <input type="text" name="expiration" id="expiration" class="form-control" placeholder="MM/AA" required>
    </div>
    <div class="form-group">
        <label for="cvv">CVV :</label>
        <input type="text" name="cvv" id="cvv" class="form-control" maxlength="4" required>
    </div>
    <button type="submit" class="btn btn-success">Valider le paiement</button>
</form>

     
        <p>Pour vider votre panier, cliquez sur le bouton ci-dessous.</p>
        <form method="post" action="index.php?page=clear_panier">
            <button type="submit" class="btn btn-danger">Vider le panier</button>
        </form>
       
    <?php endif; ?>
</div>

<?php include  'Vue\bases\footer.php'; ?>
</body>
</html>