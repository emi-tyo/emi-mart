<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// カートが空なら戻す
if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. Please shop first.</p>";
    echo "<a href='../index.php'>Back to shopping</a>";
    include '../includes/footer.php';
    exit;
}

// フォーム入力のバリデーション
$required_fields = ['name', 'address', 'suburb', 'state', 'mobile', 'email'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo "<p>Missing field: $field</p>";
        echo "<a href='checkout.php'>Go back to checkout</a>";
        include '../includes/footer.php';
        exit;
    }
}

// 在庫チェック
$cart = $_SESSION['cart'];
$insufficient = [];

foreach ($cart as $product_id => $item) {
    $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product['stock'] < $item['quantity']) {
        $insufficient[] = $item['name'];
    }
}

if (!empty($insufficient)) {
    echo "<p>Sorry, the following items are out of stock or not enough in quantity:</p>";
    echo "<ul>";
    foreach ($insufficient as $name) {
        echo "<li>$name</li>";
    }
    echo "</ul>";
    echo "<a href='cart.php'>Return to cart</a>";
    include '../includes/footer.php';
    exit;
}

// 在庫更新
foreach ($cart as $product_id => $item) {
    $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $stmt->bind_param("ii", $item['quantity'], $product_id);
    $stmt->execute();
}

// セッションカートをクリア
$_SESSION['cart'] = [];

// 注文情報の表示
echo "<h2>Thank you for your order, {$_POST['name']}!</h2>";
echo "<p>Your order has been received and is being processed.</p>";
echo "<p>A confirmation email has been sent to {$_POST['email']} (pretend).</p>";

echo "<h3>Delivery Info</h3>";
echo "<p>{$_POST['address']}, {$_POST['suburb']}, {$_POST['state']}</p>";
echo "<p>Mobile: {$_POST['mobile']}</p>";

echo "<h3>Order Summary</h3>";
$total = 0;
echo "<ul>";
foreach ($cart as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
    echo "<li>{$item['name']} x {$item['quantity']} - \$" . number_format($subtotal, 2) . "</li>";
}
echo "</ul>";
echo "<p><strong>Total: \$" . number_format($total, 2) . "</strong></p>";

include '../includes/footer.php';
?>
