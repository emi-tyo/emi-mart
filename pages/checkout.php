<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// カートが空だったらcheckoutに進ませない
if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. Please add items before checking out.</p>";
    echo "<a href='../index.php'>Back to Shopping</a>";
    include '../includes/footer.php';
    exit;
}
?>

<h2>Delivery Details</h2>

<form method="POST" action="confirm.php">
    <label for="name">Recipient Name*</label><br>
    <input type="text" name="name" required><br><br>

    <label for="address">Street Address*</label><br>
    <input type="text" name="address" required><br><br>

    <label for="suburb">City/Suburb*</label><br>
    <input type="text" name="suburb" required><br><br>

    <label for="state">State*</label><br>
    <select name="state" required>
        <option value="">Select...</option>
        <option>NSW</option>
        <option>VIC</option>
        <option>QLD</option>
        <option>WA</option>
        <option>SA</option>
        <option>TAS</option>
        <option>ACT</option>
        <option>NT</option>
        <option>Other</option>
    </select><br><br>

    <label for="mobile">Mobile Number*</label><br>
    <input type="text" name="mobile" pattern="\d{10}" required><br><br>

    <label for="email">Email*</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit" name="submit_order">Place Order</button>
</form>

<?php include '../includes/footer.php'; ?>
