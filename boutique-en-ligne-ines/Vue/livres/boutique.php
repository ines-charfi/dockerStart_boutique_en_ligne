
    <link rel="stylesheet" href="assets\css\style1.css">

    <script scr="assets/js/filters.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <?php include 'Vue\bases\header.php'; ?>
    <button class="btn" onclick="window.location.href='index.php'">Retour à l'accueil</button>

    <div class="container">
        <h2>Notre sélection pour tous !</h2><BR>
        <div class="filtre-categories">
            <button class="btn-filtre" data-id="0">Toutes les catégories</button>
            <?php foreach ($categories as $cat): ?>
                <a href="index.php?page=filtrer&categorie_id=<?= $cat['id'] ?>" class=" btn-filtre"
                    data-id="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></a>
            <?php endforeach; ?>
        </div>


        <div id="livres-grid" class="books-grid">
            <?php foreach ($livres as $livre): ?>
                <div class="book-card">
                    <img src="assets/images\<?= htmlspecialchars($livre['image']) ?>"
                        alt="<?= htmlspecialchars($livre['titre']) ?>">
                    <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                    <p><?= htmlspecialchars($livre['auteur']) ?></p>



                    <div class="price"><?= number_format($livre['prix'], 2) ?> €</div><br>
                    <a href="index.php?page=livre_detail&id=<?= $livre['id'] ?>" class="btn">Voir détail</a>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Pagination -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $nbPages; $i++): ?>
                <a href="index.php?page=boutique<?= $categorie_id ? '&categorie_id=' . $categorie_id : '' ?>&page_num=<?= $i ?>"
                    class="<?= ($i == $page) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

        </div>


    </div>


    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<?php include 'Vue\bases\footer.php'; ?>

