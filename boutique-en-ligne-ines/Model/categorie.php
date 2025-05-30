<?php
require_once  'config/database.php';

class Categorie {


    public static function getById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Removed duplicate getAll method

    // Removed duplicate update method
    public static function getHierarchy() {
        $pdo = getPDO();
        $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
        
        $tree = [];
        foreach ($categories as $category) {
            if ($category['id'] == 0) {
                $tree[$category['id']] = $category;
                $tree[$category['id']] = [];
            }
        }
        
        foreach ($categories as $category) {
            if ($category['id'] != 0) {
                $tree[$category['id']][] = $category;
            }
        }
        
        return $tree;
    }

    public static function update($id, $nom, $parentid) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            UPDATE categorie 
            SET nom = ?, id = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$nom, $parentid, $id]);
    }
    public static function create($nom, $parentid) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            INSERT INTO categorie (nom, id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$nom, $parentid]);
    }

    public static function getAll() {
        $pdo = getPDO();
        return $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($nom, $parentid = null) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO categorie (nom, id) VALUES (?, ?)");
        return $stmt->execute([$nom, $parentid]);
    }

    public static function delete($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM categorie WHERE id = ?");
        return $stmt->execute([$id]);
    }
}




?>
