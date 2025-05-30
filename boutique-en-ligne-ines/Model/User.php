<?php
require_once 'config/database.php';

class User {
    public static function register($email, $password) {
        $pdo = getPDO();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO user (email, password, role) VALUES (?, ?, 'user')");
        return $stmt->execute([$email, $hash]);
    }

    public static function login($email, $password) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public static function getById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePassword($id, $newPassword) {
        $pdo = getPDO();
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }

    public static function getByEmail($email) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM user WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function updateInfo($id, $email, $adresse) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE user SET email = ?, adresse = ? WHERE id = ?");
        return $stmt->execute([$email, $adresse, $id]);
    }
    

    // Existing methods and properties

    public static function countAll() {
        $database = new Database();
        $db = $database->getConnection();
        $query = $db->query('SELECT COUNT(*) as total FROM user');
        $result = $query->fetch();
        return $result['total'];
    }
 
    // Existing methods and properties

  public static function delete($id) {
    $pdo = getPDO();
    $pdo->beginTransaction();
    try {
        // Supprimer les avis liés à l'utilisateur
        $pdo->prepare("DELETE FROM avis WHERE user_id = ?")->execute([$id]);
        // Supprimer les commandes liées à l'utilisateur
        $pdo->prepare("DELETE FROM commande WHERE user_id = ?")->execute([$id]);
        // Supprimer l'utilisateur
        $pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$id]);
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Erreur lors de la suppression : " . $e->getMessage());
        return false;
    }
}


}
