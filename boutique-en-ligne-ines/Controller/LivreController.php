<?php
// Correct partout :
require_once 'Model/Livre.php'; // même casse partout
require_once 'config/database.php';

require_once 'Model/categorie.php';
require_once 'Model/User.php';
require_once 'Model/Avis.php';

class LivreController
{
    // Page boutique
    // Removed duplicate boutique method

    // AJAX : filtrer par catégorie
    // Exemple dans LivreController.php// Autocomplétion AJAX


    // Autocomplétion AJAX pour la recherche de livres
    public function autocomplete()
    {
        header('Content-Type: application/json');
        $term = $_GET['term'] ?? '';
        $pdo = getPDO();
        $stmt = $pdo->prepare(
            "SELECT id, titre, auteur, image 
             FROM livre 
             WHERE titre LIKE ? 
             LIMIT 7"
        );
        $stmt->execute(['%' . $term . '%']);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit();
    }

    public function filtrer()
    {
        $categorieId = isset($_POST['categorieid']) ? (int) $_POST['categorieid'] : 0;

        $pdo = getPDO();
        if ($categorieId > 0) {
            $stmt = $pdo->prepare("SELECT * FROM livre WHERE categorieid = ?");
            $stmt->execute([$categorieId]);
        } else {
            $stmt = $pdo->query("SELECT * FROM livre");
        }
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Génération du HTML des livres
        ob_start();
        foreach ($livres as $livre): ?>
            <div class="book-card">
                <img src="assets/images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                <p><?= htmlspecialchars($livre['auteur']) ?></p>
                <div class="price"><?= number_format($livre['prix'], 2) ?> €</div>
                <a href="index.php?page=livre_detail&id=<?= $livre['id'] ?>" class="btn">Voir détail</a>
            </div>
        <?php endforeach;

        echo ob_get_clean();
        exit();
    }


    // Page détail livre
    public function detail($id)
    {
        $livre = Livre::getById($id);
        $avis = Avis::getValidatedForLivre($id);
        if (!is_array($avis))
            $avis = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $note = (int) $_POST['note'];
            $commentaire = htmlspecialchars($_POST['commentaire']);

            if ($note >= 1 && $note <= 5 && !empty($commentaire)) {
                Avis::create($id, $_SESSION['user_id'], $note, $commentaire);
                $_SESSION['success'] = "Votre avis est en attente de modération";
            }

            header("Location: index.php?page=livre_detail&id=$id");
            exit;
        }
        if (!isset($livres_similaires) || !is_array($livres_similaires)) {
            $livres_similaires = [];
        }
        $livres_similaires = Livre::getSimilaires($livre['categorie_id'], $id);
        $categories = Categorie::getAll();

        require 'Vue/livres/detail.php';
    }

    public function ajouterAvis()
    {
        // Assuming you have a database connection and the necessary data from the form
        $livre_id = $_POST['livre_id'];
        $note = $_POST['note'];
        $commentaire = $_POST['commentaire'];
        $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO avis (livre_id, user_id, note, commentaire) VALUES (?, ?, ?, ?)");
        $stmt->execute([$livre_id, $user_id, $note, $commentaire]);
        // Optionally, you can also update the average rating of the book here
        $stmt = $pdo->prepare("UPDATE livre SET moyenne = (SELECT AVG(note) FROM avis WHERE livre_id = ?) WHERE id = ?");
        $stmt->execute([$livre_id, $livre_id]);
        // Redirect or show a success message
        // You can also return a JSON response if this is an AJAX request
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Avis ajouté avec succès.']);
    }
    public function ajouterPanier()
    {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }
        $livre_id = $_POST['livre_id'];
        $quantite = $_POST['quantite'];
        // Vérifier si le produit existe déjà
        if (isset($_SESSION['panier'][$livre_id])) {
            $_SESSION['panier'][$livre_id] += $quantite;
        } else {
            $_SESSION['panier'][$livre_id] = $quantite;
        }
        header('Location: index.php?page=panier');
        exit;
    }
    public function validerCommande()
    {
        // Logic to validate the order
        echo "Commande validée avec succès.";
    }
    public function historique()
    {
        // Logic for displaying the order history
        echo "Displaying order history.";
    }
    public function boutique()
    {
        $categories = Categorie::getAll();
        $perPage = 10;
        $page = isset($_GET['page_num']) ? max(1, (int) $_GET['page_num']) : 1;
        $page = min($page, 100); // Limiter à 100 pages
        $page = max($page, 1); // Limiter à 1 page minimum
        $categorie_id = isset($_GET['categorie_id']) ? (int) $_GET['categorie_id'] : 0;

        if ($categorie_id) {
            $total = Livre::countByCategorie($categorie_id);
            $livres = Livre::getPaginatedByCategorie($categorie_id, ($page - 1) * $perPage, $perPage);
        } else {
            $total = Livre::countAll();
            $livres = Livre::getPaginated(($page - 1) * $perPage, $perPage);
        }
        $nbPages = ceil($total / $perPage);

        require 'Vue/livres/boutique.php';
    }
    public function getCategories()
    {
        return Categorie::getAll();
    }
    public function getLivreById($id)
    {
        return Livre::getById($id);
    }

}
?>