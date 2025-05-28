<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cart;

class CartController extends Controller {
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'] ?? null;

        if (!$productId) {
            http_response_code(400);
            echo "Missing product ID";
            return;
        }

        Cart::addToCart($userId, (int)$productId);
        header('Location: /cart');
        exit;
    }

    public function showCart() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $items = Cart::getUserCartItems($_SESSION['user_id']);
        $this->view('cart', ['items' => $items]);
    }
}
