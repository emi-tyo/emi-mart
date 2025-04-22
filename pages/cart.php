<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// カートが空かチェック
$cart = $_SESSION['cart'] ?? [];

echo "<h2>Your Shopping Cart</h2>";

if (empty($cart)) {
    echo "<p>Your cart is empty.</p>";
    echo "<a href='../index.php'>Back to shopping</a>";
} else {
    echo "<form method='POST' action='../functions/cart_functions.php'>";
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Image</th><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Remove</th></tr>";

    $total = 0;

    foreach ($cart as $product_id => $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;

        echo "<tr>
                <td><img src='../assets/images/{$item['image']}' width='50'></td>
                <td>{$item['name']}</td>
                <td>\${$item['price']}</td>
                <td>
                    <input 
                        type='number' 
                        name='quantities[$product_id]' 
                        value='{$item['quantity']}' 
                        min='1' 
                        class='qty' 
                        data-price='{$item['price']}'
                    >
                </td>
                <td class='subtotal'>\$" . number_format($subtotal, 2) . "</td>
                <td>
                    <button type='submit' name='remove' value='$product_id'>X</button>
                </td>
              </tr>";
    }

    echo "</table>";
    echo "<p><strong>Total: \$<span id='total'>" . number_format($total, 2) . "</span></strong></p>";

    echo "<button type='submit' name='update'>Update Quantities</button> ";
    echo "<button type='submit' name='clear'>Clear Cart</button> ";
    echo "<a href='checkout.php'><button type='button'>Place Order</button></a>";
    echo "</form>";
}
?>

<script src="../assets/script.js"></script>

<?php include '../includes/footer.php'; ?>
