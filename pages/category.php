<?php
include '../includes/db.php';
include '../includes/header.php';

$cat_id = $_GET['cat_id'] ?? 0;
$sub = $_GET['sub'] ?? null; //サブカテゴリ用パラメータを追加

//サブカテゴリ定義（DB使わずにハードコーディング）
$subcategories = [
    'Fruits' => ['Banana', 'Apple'],
    'Vegetables' => ['Carrot', 'Tomato'],
    'Dairy' => ['Milk', 'Cheese'],
    'Snacks' => ['Chips', 'Chocolate'],
    'Drinks' => ['Juice', 'Soda']
  ];
  

//カテゴリ名の取得
$cat_name = "Category";
$cat_query = $conn->prepare("SELECT name FROM categories WHERE id = ?");
$cat_query->bind_param("i", $cat_id);
$cat_query->execute();
$cat_result = $cat_query->get_result();
if ($cat_row = $cat_result->fetch_assoc()) {
    $cat_name = $cat_row['name'];
}

echo "<h2>Category: $cat_name</h2>";

//サブカテゴリ表示（ある場合のみ）
if (isset($subcategories[$cat_name])) {
    echo "<div class='subcats'><strong>Subcategories:</strong><ul>";
    foreach ($subcategories[$cat_name] as $subcat_name) {
        $link = "category.php?cat_id=$cat_id&sub=" . urlencode($subcat_name);
        $active = ($sub === $subcat_name) ? "class='active-sub'" : "";
        echo "<li><a href='$link' $active>$subcat_name</a></li>";
    }    
    echo "</ul></div>";
}

//商品一覧クエリ（サブカテゴリ条件付き）
if ($sub) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? AND sub_category = ?");
    $stmt->bind_param("is", $cat_id, $sub);
} else {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $cat_id);
}
$stmt->execute();
$result = $stmt->get_result();

// 商品表示
echo "<div class='grid'>";
while ($product = $result->fetch_assoc()) {
    $in_stock = $product['stock'] > 0;
    $button_state = $in_stock ? "" : "disabled";
    $button_text = $in_stock ? "Add to Cart" : "Out of Stock";
    $image = !empty($product['image']) 
        ? '../assets/images/' . $product['image'] 
        : '../assets/images/default.png';
        
    echo "<div class='product'>
            <img src=\"$image\" alt=\"{$product['name']}\" width=\"160\">
            <p><strong>{$product['name']}</strong></p>
            <p>\${$product['price']}</p>
            <form method='POST' action='../functions/cart_functions.php'>
                <input type='hidden' name='product_id' value='{$product['id']}'>
                <button type='submit' name='add_to_cart' $button_state>$button_text</button>
            </form>
          </div>";
}
echo "</div>";

include '../includes/footer.php';
?>
