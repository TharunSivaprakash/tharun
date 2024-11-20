<?php
// config.php: Contains the database connection details
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Plant Ordering</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>ONLINE PLANT ORDERING</h1>
    </header>

    <main>
        <div class="product-container">
            <?php
            // Fetching products from the database
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            // Displaying each product
            while ($row = $result->fetch_assoc()) { ?>
                <div class="product">
                    <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <p>Price: Rs <?php echo $row['price']; ?></p>
                    <!-- Passing product_name, product_price, product_id, and quantity to buying.php -->
                    <a href="buying.php?product_id=<?php echo $row['id']; ?>&product_name=<?php echo urlencode($row['name']); ?>&product_price=<?php echo $row['price']; ?>&quantity=1">
                        <button>Buy Now</button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>  