<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $customer_name = $_POST["customer_name"]; 
    $customer_address = $_POST["customer_address"];
    $phone = !empty($_POST["phone"]) ? $_POST["phone"] : NULL;  // If phone is empty, set it as NULL
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    // Default user ID (since user login is not implemented)
    $user_id = 1;

    // Database connection
    $conn = new mysqli("localhost", "root", "12345", "nursery_management");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get product price from the database
    $product_price = 0;
    $product_name = "";
    $product_query = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    if (!$product_query) {
        die("Error preparing product query: " . $conn->error);
    }

    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $product_result = $product_query->get_result();
    if ($product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $product_name = $product_row['name'];
        $product_price = $product_row['price'];
    } else {
        die("Invalid product ID.");
    }
    $product_query->close();

    // Calculate total price
    $total_price = $product_price * $quantity;

    // Prepare the SQL query to insert data
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, product_id, quantity, name, address, phone, total_price) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Error preparing SQL statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("iiisssd", $user_id, $product_id, $quantity, $customer_name, $customer_address, $phone, $total_price);

    // Execute the statement
    if (!$stmt->execute()) {
        die("Error executing SQL statement: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Display success message
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Order Placed</title>
        <style>
            body {
                background-color: green;
                color: white;
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .container {
                text-align: center;
                border: 2px solid white;
                padding: 20px;
                border-radius: 10px;
                background-color: #005500;
                width: 50%;
            }
            h1, h2, p {
                font-weight: bold;
            }
            ul {
                list-style: none;
                padding: 0;
            }
            ul li {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Thank You for Your Purchase!</h1>
            <h2>Order Details</h2>
            <ul>
                <li><strong>Name:</strong> " . htmlspecialchars($customer_name) . "</li>
                <li><strong>Address:</strong> " . nl2br(htmlspecialchars($customer_address)) . "</li>
                <li><strong>Phone:</strong> " . ($phone ? htmlspecialchars($phone) : "Not Provided") . "</li>
                <li><strong>Product:</strong> " . htmlspecialchars($product_name) . "</li>
                <li><strong>Quantity:</strong> " . htmlspecialchars($quantity) . "</li>
                <li><strong>Total Price:</strong> Rs " . htmlspecialchars($total_price) . "</li>
            </ul>
            <p>Your order has been placed successfully!</p>
            <p><a href='onlineshopping.html' style='color: white; text-decoration: underline;'>Go back to homepage</a></p>
        </div>
    </body>
    </html>
    ";
    exit();
}
?>
