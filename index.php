<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Émi Mart</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>

<?php
include 'includes/db.php';
include 'includes/header.php';
?>

<div class="main-container">
  <div class="product-section">
      <h1>Welcome to Émi Mart</h1>
      <h2>Featured Products</h2>
      <div class="grid">
      <?php
      $product_query = "SELECT * FROM products LIMIT 6";
      $product_result = $conn->query($product_query);
      while ($product = $product_result->fetch_assoc()) {
          $in_stock = $product['stock'] > 0;
          $button_state = $in_stock ? "" : "disabled";
          $button_text = $in_stock ? "Add to Cart" : "Out of Stock";
          $image = !empty($product['image']) ? 'assets/images/' . $product['image'] : 'assets/images/default.png';

          echo "<div class='product'>
                  <img src='$image' alt='{$product['name']}' width='100'>
                  <p>{$product['name']}</p>
                  <p>\${$product['price']}</p>
                  <form method='POST' action='functions/cart_functions.php'>
                      <input type='hidden' name='product_id' value='{$product['id']}'>
                      <button type='submit' name='add_to_cart' $button_state>$button_text</button>
                  </form>
                </div>";
      }
      ?>
      </div>
  </div>


  <div class="sidebar">
      <!-- 検索 -->
      <form method="GET" action="pages/search.php">
          <input type="text" name="keyword" placeholder="Search products..." />
          <button type="submit">Search</button>
      </form>

      <!-- カテゴリ -->
      <h2>Categories</h2>
      <ul>
      <?php
      $cat_query = "SELECT * FROM categories";
      $cat_result = $conn->query($cat_query);
      while ($cat = $cat_result->fetch_assoc()) {
          echo "<li><a href='pages/category.php?cat_id={$cat['id']}'>{$cat['name']}</a></li>";
      }
      ?>
      </ul>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
