<link rel="stylesheet" href="style1.css">
<?php include 'Vue/bases/header.php'; ?><br>

<a href="index.php?page=admin_livres" class="btn btn-primary">Retour à la liste des livres</a>
<br><br>

<div class="container">
    <h2>Gestion des catégories</h2><br><br>

    <!-- Formulaire d'ajout -->
    <form method="post" action="index.php?page=add_categorie" class="mb-4">
        <div class="form-group">
            <label for="nom">Nom de la catégorie :</label>
            <input type="text" class="form-control" name="nom" id="nom" required>
        </div>
      
        <button type="submit" class="btn btn-success mt-2">Ajouter</button>
        <a href="index.php?page=admin_livres" class="btn btn-secondary mt-2">Annuler</a>
    </form>

    <!-- Liste des catégories -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
              
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $categorie): ?>
                <?php if (isset($cat['id'], $cat['nom'], $cat['id'])): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td><?= htmlspecialchars($cat['nom']) ?></td>
                        <td>
                            <?php
                            if ($cat['id'] == 0) {
                                echo "Aucune";
                            } else {
                                $parentNom = "Inconnue";
                                foreach ($categories as $categorie) {
                                    if ($categorie['id'] == $cat['id']) {
                                        $Nom = htmlspecialchars($categorie['nom']);
                                        break;
                                    }
                                }
                                echo $Nom;
                            }
                            ?>
                        </td>
                        <td>
                            <a href="index.php?page=edit_categorie&id=<?= $cat['id'] ?>" 
                               class="btn btn-warning btn-sm">✏️</a>
                            <a href="index.php?page=delete_categorie&id=<?= $cat['id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Supprimer définitivement ?')">🗑️</a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'Vue/bases/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
