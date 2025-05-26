<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | VelloStore</title>
    <link rel="stylesheet" href="css/main_style.css">
    <!-- <link rel="stylesheet" href="css/products_page.css"> -->
    <link rel="shortcut icon" href="uploads/logos/Logo_2.png" type="image/x-icon">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="wrapper">
            <div class="logo">
                <a href="products_page.php"><span class="left">Vello</span><span class="right">Store</span></a>
            </div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="#">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact Me</a></li>
        </ul>
            <div><button class="log-btn">Logout</button></div>
            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>

    <!-- Products Lists -->
    <div id="products" class="container mt-5">

        <!-- Product cards -->
        <?php
            $products = $productController->GetProducts();
            if (empty($products)) {
                echo '<div class="alert alert-danger" role="alert">No products found</div>';
            }
        ?>

        <div class="row justify-content-between">
            <?php foreach($products as $product): ?>
                <div class="col mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($product['prod_img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['prod_name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['prod_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['prod_desc']); ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Category : <?php echo htmlspecialchars($product['prod_category']); ?></li>
                            <li class="list-group-item item-price">Price : <?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?></li>
                            <li class="list-group-item">
                                <button class="btn">View</button>
                                <button class="btn">Buy</button>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</body>
</html>