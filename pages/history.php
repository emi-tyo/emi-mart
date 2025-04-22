<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';


if (!isset($_POST['check_history'])) {
?>
    <h2>Check Purchase History</h2>
    <form method="POST">
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="mobile">Mobile Number:</label><br>
        <input type="text" name="mobile" pattern="\d{10}" required><br><br>

        <button type="submit" name="check_history">View History</button>
    </form>
<?php
    include '../includes/footer.php';
    exit;
}

// 情報を受け取った後
$email = $_POST['email'];
$mobile = $_POST['mobile'];

// 管理者の場合は全履歴を表示
if ($email === "admin@admin.com" && $mobile === "1234567890") {
    echo "<h2>Admin View: All Purchase Records</h2>";
    $query = "SELECT * FROM orders ORDER BY created_at DESC";
} else {
    echo "<h2>Your Purchase History</h2>";
    $stmt = $conn->prepare("SELECT * FROM orders WHERE email = ? AND mobile = ? ORDER BY created_at DESC");
    $stmt->bind_param("ss", $email, $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    if (empty($orders)) {
        echo "<p>No orders found for your email and mobile.</p>";
        include '../includes/footer.php';
        exit;
    }
}

echo "<ul>";
foreach ($orders as $order) {
    echo "<li>
        <strong>Date:</strong> {$order['created_at']}<br>
        <strong>Name:</strong> {$order['name']}<br>
        <strong>Total:</strong> \$" . number_format($order['total_price'], 2) . "<br>
        <hr>
    </li>";
}
echo "</ul>";

include '../includes/footer.php';
?>
