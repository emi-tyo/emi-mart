<?php
include '../includes/db.php';
include '../includes/header.php';

$keyword = $_GET['keyword'] ?? '';

echo "<h2>Search results for '$keyword'</h2>";
$query = "SELECT * FROM products WHERE name LIKE '%$keyword%'";
$result = $conn->query($query);

echo "<div class='grid'>";
while ($row = $result->fetch_assoc()) {
    $image = !empty($row['image']) ? '../assets/images/' . $row['image'] : '../assets/images/default.png';
    
    echo "<div class='product'>
            <img src='$image' alt='{$row['name']}' width='160'>
            <p><strong>{$row['name']}</strong></p>
            <p>\${$row['price']}</p>
            <form method='POST' action='../functions/cart_functions.php'>
                <input type='hidden' name='product_id' value='{$row['id']}'>
                <button type='submit' name='add_to_cart'>Add to Cart</button>
            </form>
          </div>";
}
echo "</div>";

include '../includes/footer.php';
?>
