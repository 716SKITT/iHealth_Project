<?php
namespace App\Models;

use Database;
use PDO;

class Cart {
    public static function getOrCreateActiveCart($userId) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT cart_id FROM carts WHERE user_id = ? AND is_active = true");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) return $cart['cart_id'];

        $stmt = $db->prepare("INSERT INTO carts (user_id, is_active, created_at) VALUES (?, true, NOW()) RETURNING cart_id");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    public static function addToCart($userId, $productId, $quantity = 1) {
        $cartId = self::getOrCreateActiveCart($userId);
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT cart_item_id FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$cartId, $productId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $stmt = $db->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_item_id = ?");
            $stmt->execute([$quantity, $item['cart_item_id']]);
        } else {
            $stmt = $db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$cartId, $productId, $quantity]);
        }
    }

    public static function getUserCartItems($userId) {
        $cartId = self::getOrCreateActiveCart($userId);
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT ci.quantity, p.name, p.price, p.image_url 
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.product_id
            WHERE ci.cart_id = ?
        ");
        $stmt->execute([$cartId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
