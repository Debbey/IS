<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the form data
    $product_id = $_POST['product'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0; // Ensure quantity is an integer

    // Check if quantity is a positive integer
    if ($quantity <= 0) {
        echo "Error: Quantity must be a positive integer.";
        exit();
    }

    // Insert the order into the database
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO orders (user_id, product_id, quantity) 
            VALUES ('$user_id', '$product_id', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        // Order successfully placed
        // Redirect to a confirmation page or display a success message
        header("Location: order_confirmation.php");
        exit();
    } else {
        // Error occurred while inserting order into the database
        // Handle the error appropriately (e.g., display an error message)
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product</title>
</head>
<body>
    <h2>Order Product</h2>
    <form method="post">
        <label for="product">Select Product:</label>
        <select id="product" name="product">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" required>
        <br>
        <input type="submit" value="Place Order">
    </form>

    <a href="products.php">Back to Products</a>
</body>
</html>
