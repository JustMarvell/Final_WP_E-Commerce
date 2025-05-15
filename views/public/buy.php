<?php
session_start();

include_once '../../models/database_connector.php'; // Include database connection file
include_once '../../controllers/prods_con.php'; // Include Product controller file
include_once '../../controllers/utils.php'; // Include utility functions
include_once '../../controllers/usrs_con.php'; // Include User controller file
include_once '../../controllers/purch_con.php'; // Include purchase controller file

$db = new DatabaseConnector(); // Create a new instance of the database connection
$db_conn = $db->GetConnection(); // Get the database connection
$productController = new ProductController($db_conn); // Create a new instance of the Product controller
$utils = new Utils(); // Create a new instance of the utility functions
$userController = new UserCnt($db_conn); // Create a new instance of the User controller
$purchaseController = new PurchCon($db_conn); // Create a new instance of the purchase controller

if (!isset($_GET['prod_id'])) {
    die("INVALID PRODUCT ID");
}

$prd_id = strval($_GET['prod_id']);
$product = $productController->GetProductByID($prd_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['buy'])) {
        $receipt = $purchaseController->CreateReceipt($product['prod_name'], $_POST['ord_qty'], $product['prod_price']);

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="receipt.txt"');
        echo $receipt;

        $initialQty = intval($product['prod_qty']);
        $orderQty = intval($_POST['ord_qty']);
        $total = $initialQty - $orderQty;
        $productController->UpdateQuantity($product['id'], $total);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Stalinist+One&display=swap" rel="stylesheet">

     <!-- Script JS untung nda error hehe kl error nti bilang -->
    <script>

        // Function to update total price based on order quantity
        function UpdateTotalPrice() {
            const quantity = document.getElementById('ord_qty').value;
            const itemPrice = <?php echo $product['prod_price'];  ?>;
            const total = quantity * itemPrice;
            const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
            document.getElementById('prc_total').textContent = formatted;
        }

    </script>
</head>

<body>

    <body>
        <div class="admin-bar">
            <img src="image/logo_transparent.png" class="welcome-admin-image" alt="Login">
            <span class="site-name">Nebula</span>
        </div>
        <div class="container">
            <div class="checkout-summary">
                <h2>Order Summary</h2>

                <div class="text-center mb-4">
                    <img src="<?php echo htmlspecialchars($product['prod_img']); ?>" alt="<?php echo htmlspecialchars($product['prod_name']); ?>" style="width: 220px; height: 220px; object-fit: cover;">
                    <h4 class="mt-3"><?php echo htmlspecialchars($product['prod_name']); ?></h4>
                    <p class="mb-1">Category: <?php echo htmlspecialchars($product['prod_category']); ?></p>
                    <p class="mb-1">Description: <?php echo htmlspecialchars($product['prod_desc']); ?></p>
                    <p class="mb-1">In Stock: <?php echo htmlspecialchars($product['prod_qty']); ?></p>
                </div>

                <form action="" method="post" class="mt-4">
                    <div class="summary-details">
                        <div class="summary-line">
                            <span>Subtotal (incl. tax)</span>
                            <span> <?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?></span>
                        </div>
                        <div class="summary-line">
                            <span>Shipping & Handling</span>
                            <span>Rp0</span>
                        </div>
                        <div class="summary-line">
                            <span>Tax</span>
                            <span>Rp0</span>
                        </div>
                        <div class="summary-line">
                            <span>Discount</span>
                            <span>Rp0</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span id="prc_total"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="ord_qty">Order Quantity:</label>
                        <input type="number" name="ord_qty" id="ord_qty" class="form-control" max="<?php echo $product['prod_qty']; ?>" value="1" min="1" required oninput="UpdateTotalPrice()">
                    </div>

                    <button class="btn btn-success w-100 mt-3" type="submit" name="buy">BUY</button>
                </form>

                <div class="text-center mt-3">
                    <a href="index_nn.php" class="btn btn-outline-secondary">Back to Product List</a>
                </div>
            </div>
        </div>

        <script>UpdateTotalPrice()</script>
    </body>

</html>