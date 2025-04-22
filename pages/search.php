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
            <img src='$image' alt='{$row['name']}' height='160'>
            <p>{$row['name']}</p>
            <p>\${$row['price']}</p>
          </div>";
}
echo "</div>";

include '../includes/footer.php';
?>
