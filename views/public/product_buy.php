<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start the session if not already started
    }

    include_once '../../models/database_connector.php'; // Include database connection file
    include_once '../../controllers/prods_con.php'; // Include Product controller file
    include_once '../../controllers/utils.php'; // Include utility functions
    include_once '../../controllers/usrs_con.php'; // Include User controller file
    include_once '../../controllers/purch_con.php'; // Include purchase controller file
    include_once '../../controllers/his_con.php';

    $db = new DatabaseConnector(); // Create a new instance of the database connection
    $db_conn = $db->GetConnection(); // Get the database connection
    $productController = new ProductController($db_conn); // Create a new instance of the Product controller
    $userController = new UserCnt($db_conn); // Create a new instance of the User controller
    $utils = new Utils(); // Create a new instance of the utility functions
    $purchaseController = new PurchCon($db_conn); // Create a new instance of the purchase controller
    $historyController = new HistoryController($db_conn);

    if (!isset($_GET['prod_id']) && !isset($_GET['ord_qty'])) {
        die("INVALID PRODUCT ID AND QUANTITY");
    }

    $prd_id = strval($_GET['prod_id']);
    $product = $productController->GetProductByID($prd_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['buy'])) {
            // Add purchase history
            $productController->UpdateQuantity($_POST['prod_id'], intval($product['prod_qty']) - intval($_POST['ord_qty']));
            $historyController->AddOrderHistory($_POST);

            // Redirect to receipt page
            Header('Location: product_receipt.php?prod_id=' . $_POST['prod_id'] . '&ord_qty=' . $_POST['ord_qty']);
        }

        if (isset($_POST['logout'])) {
            $utils->Redirect('logout.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['prod_name']); ?> | VelloStore</title>

    <link rel="stylesheet" href="css/main_style.css">
    <link rel="stylesheet" href="css/product_buy.css">

    <!-- <link rel="stylesheet" href="css/products_page.css"> -->
    <link rel="shortcut icon" href="uploads/logos/Logo_2.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- BS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function UpdateTotalPrice() {
            const quantity = document.getElementById('ord_qty').value;
            const itemPrice = <?php echo $product['prod_price'];  ?>;
            const total = quantity * itemPrice;
            const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
            document.getElementById('prc_total').textContent = formatted;
            document.getElementById('prc_total_receipt').textContent = formatted;
            document.getElementById('qty_total_receipt').textContent = quantity;
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <header id="head" class="pt-5 pb-4">
        <nav id="navbar" class="navbar navbar-expand-lg fixed-top navbar">
            <div class="container">
                <a class="navbar-brand" href="#head">
                    <span class="cl-blue">V<span class="gone">ello</span></span><span class="cl-orange">S<span class="gone">tore</span>
                </a>
    
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item px-1 active">
                            <a class="nav-link" href="products_page.php#head">Home</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="products_page.php#products">Products</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="product_history.php">History</a>
                        </li>
                        <!-- <li class="nav-item px-1">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="#">Contact Me</a>
                        </li> -->
                    </ul>
                </div>
    
                <form class="form-inline" method="post">
                    <button class="btn btn-log" type="submit" name="logout">Logout</button>
                </form>
            </div>
        </nav>
    </header>

    <!-- Product Detail -->
    <div class="container py-5 product-detail">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 mb-4">
                <div class="card d-flex">
                    <img src="<?php echo htmlspecialchars($product['prod_img']); ?>" class="card-img h-100" alt="Product Image">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1 class="h2 mb-3"><?php echo htmlspecialchars($product['prod_name']); ?></h1>
                <div>
                    <span class="h4 me-2"><?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?></span>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <span class="text-muted"><?php echo htmlspecialchars($product['prod_category']); ?></span>
                    </div>
                </div>

                <p class="mb-4"><?php echo htmlspecialchars($product['prod_desc']); ?></p>

                <!-- In Stock -->
                <div>
                    <div class="d-flex align-items-center">
                        <label class="me-2">In Stock : <?php echo htmlspecialchars($product['prod_qty']); ?></label>
                    </div>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <div class="form-group">
                            <label for="ord_qty">Order Quantity : </label>
                            <input type="number" name="ord_qty" id="ord_qty" class="form-control" max="<?php echo $product['prod_qty']; ?>" value="1" min="1" required oninput="UpdateTotalPrice()">
                        </div>
                    </div>
                    
                    <!-- Total -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Total price : <span id="prc_total"></span></label>
                        </div>
                    </div>
                    
                <!-- Actions -->
                    <div class="d-grid gap-2">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                        <input type="hidden" name="prod_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <input type="hidden" name="ord_date" value="<?php echo Utils::GetCurrentTimestamp(); ?>">
                        <input type="hidden" name="prod_name" value="<?php echo htmlspecialchars($product['prod_name']); ?>">
                        <input type="hidden" name="prod_price" value="<?php echo htmlspecialchars($product['prod_price']); ?>">
                        <button type="submit" class="btn btn-primary" onclick="" name="buy">Buy Product</button>
                    </div>
                </form>

                <!-- Additional Info -->
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-truck text-primary me-2"></i>
                        <span>Free shipping on orders over $50</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-undo text-primary me-2"></i>
                        <span>30-day return policy</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-alt text-primary me-2"></i>
                        <span>2-year warranty</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="receipt" class="tablerounededCorner d-none">
            <div class="text-center mb-3">
                <img src="uploads/logos/Logo_2.png" alt="VelloStore Logo">
            </div>
            <table class="table table-sm roundedTable">
                <tbody>
                <tr><th>Product Name</th><td id="productName"><?php echo htmlspecialchars($product['prod_name']); ?></td></tr>
                <tr><th>Category</th><td id="productCategory"><?php echo htmlspecialchars($product['prod_category']); ?></td></tr>
                <tr><th>Price</th><td id="productPrice"><?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?></td></tr>
                <tr><th>Quantity</th><td id="productQuantity"><span id="qty_total_receipt"></span></td></tr>
                <tr><th>Total</th><td id="totalPrice"><span id="prc_total_receipt"></span></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    

    <script>UpdateTotalPrice()</script>
    <script>
        function GenerateReceipt() {
            const receipt = document.getElementById('receipt');
            receipt.classList.remove('d-none');
            html2canvas(receipt).then(canvas => {
                const link = document.createElement('a');
                link.download = 'VelloStore_Receipt_<?php echo htmlspecialchars($product['prod_name'])?>.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                receipt.classList.add('d-none');
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main_java.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>