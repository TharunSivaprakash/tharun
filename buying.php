<?php
session_start();

$product_id = $_GET['product_id'];
$product_name = $_GET['product_name'];
$product_price = $_GET['product_price'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase <?php echo htmlspecialchars($product_name); ?></title>
    <link rel="stylesheet" href="shop.css">
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
        label, input, textarea, button {
            font-weight: bold;
        }
        textarea, input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: white;
            color: green;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Purchase <?php echo htmlspecialchars($product_name); ?></h1>
        <form method="post" action="process_order.php">
            <h2>Customer Details</h2>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="customer_name" required><br>

            <label for="phone">Phone Number:</label><br>
            <input type="tel" id="phone" name="customer_phone" pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" required><br>

            <label for="address">Address:</label><br>
            <textarea id="address" name="customer_address" rows="4" required></textarea><br>

            <h2>Order Details</h2>
            <p>Product: <?php echo htmlspecialchars($product_name); ?></p>
            <p>Price: Rs <?php echo htmlspecialchars($product_price); ?></p>

            <label for="quantity">Quantity:</label><br>
            <input type="number" id="quantity" name="quantity" value="1" min="1" required><br>

            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product_price); ?>">

            <button type="submit">Confirm Purchase</button>
        </form>
    </div>
</body>
</html>
