<?php
// Include the database connection configuration
include 'config.php';

// Start the session to get the logged-in user's ID
session_start();

// Ensure the required POST variables are set
if (isset($_POST['product_id'], $_POST['quantity'], $_POST['name'], $_POST['address'], $_POST['phone'])) {
    
    // Assign the form data to variables
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    
    // Check if user is logged in and get the user_id from session, otherwise set default to 1
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

    // Get product details from the products table
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch product details
        $product = $result->fetch_assoc();
        $product_name = $product['name'];
        $product_price = $product['price'];

        // Prepare and insert the order into the orders table
        $sql = "INSERT INTO orders (product_id, quantity, name, address, phone, user_id) 
                VALUES ('$product_id', '$quantity', '$name', '$address', '$phone', '$user_id')";

        // Execute the query and check for errors
        if ($conn->query($sql) === TRUE) {
            echo "Order placed successfully!<br>";
            echo "Product: $product_name <br>";
            echo "Quantity: $quantity <br>";
            echo "Total Price: Rs " . ($product_price * $quantity) . "<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Error: Missing order details.";
}
?>
