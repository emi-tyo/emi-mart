<?php
session_start();
include '../includes/db.php'; // データベース接続

// 初期化
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 追加
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // 在庫チェック
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($product = $result->fetch_assoc()) {
        if ($product['stock'] > 0) {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => 1
                ];
            }
        }
    }
    // 元のページに戻る
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// 他の操作
if (isset($_POST['update']) && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $product_id => $qty) {
        if ($qty > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $qty;
        }
    }
    header('Location: ../pages/cart.php');
    exit;
}
if (isset($_POST['remove'])) {
    $product_id = $_POST['remove'];
    unset($_SESSION['cart'][$product_id]);
    header('Location: ../pages/cart.php');
    exit;
}
if (isset($_POST['clear'])) {
    $_SESSION['cart'] = [];
    header('Location: ../pages/cart.php');
    exit;
}
