<?php
// Correct partout :
require_once 'Model/Livre.php'; // même casse partout


class AccueilController
{
    public function index()
    {
        $nouveautes = Livre::getNouveautes();
        $phares = Livre::getProduitsPhares();
        require 'Vue\livres\acceuil.php';
    }

    // Route AJAX pour l'autocomplétion
    public function autocomplete()
    {
        header('Content-Type: application/json');
        if (isset($_GET['term'])) {
            $results = Livre::search($_GET['term']);
            echo json_encode($results);
        }
        exit;
    }
    // Route AJAX pour la recherche
    public function search()
    {
        header('Content-Type: application/json');
        if (isset($_GET['query'])) {
            $results = Livre::search($_GET['query']);
            echo json_encode($results);
        }
        exit;
    }
    // Route AJAX pour le tri

}
?>