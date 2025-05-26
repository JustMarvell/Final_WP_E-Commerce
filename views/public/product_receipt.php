<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start the session if not already started
    }

    include_once '../../models/database_connector.php'; // Include database connection file
    include_once '../../controllers/prods_con.php'; // Include Product controller file
    include_once '../../controllers/utils.php'; // Include utility functions
    include_once '../../controllers/usrs_con.php'; // Include User controller file
    include_once '../../controllers/purch_con.php'; // Include purchase controller file

    $db = new DatabaseConnector(); // Create a new instance of the database connection
    $db_conn = $db->GetConnection(); // Get the database connection
    $productController = new ProductController($db_conn); // Create a new instance of the Product controller
    $userController = new UserCnt($db_conn); // Create a new instance of the User controller
    $utils = new Utils(); // Create a new instance of the utility functions
    $purchaseController = new PurchCon($db_conn); // Create a new instance of the purchase controller


    if (!isset($_GET['prod_id'])) {
        die("INVALID PRODUCT ID");
    }

    $prd_id = strval($_GET['prod_id']);
    $ord_qty = intval($_GET['ord_qty']);
    $product = $productController->GetProductByID($prd_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
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
        function SetTotalPrice() {
            const quantity = <?php echo $ord_qty;?>;
            const itemPrice = <?php echo $product['prod_price']; ?>;
            const totalPrice = quantity * itemPrice;
            const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR'}).format(totalPrice);
            document.getElementById('prc_total_receipt').textContent = formatted;
        }

        function GenerateReceipt() {
            const receipt = document.getElementById('receipt');
            html2canvas(receipt).then(canvas => {
                const link = document.createElement('a');
                link.download = 'VelloStore_Receipt_<?php echo htmlspecialchars($product['prod_name'])?>.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div>
        <div id="receipt" class="tablerounededCorner">
            <div class="text-center mb-3">
                <img src="uploads/logos/Logo_2.png" alt="VelloStore Logo">
            </div>
            <table class="table table-sm roundedTable">
                <tbody>
                <tr><th>Product Name</th><td id="productName"><?php echo htmlspecialchars($product['prod_name']); ?></td></tr>
                <tr><th>Category</th><td id="productCategory"><?php echo htmlspecialchars($product['prod_category']); ?></td></tr>
                <tr><th>Price</th><td id="productPrice"><?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?></td></tr>
                <tr><th>Quantity</th><td id="productQuantity"><?php echo $ord_qty; ?></td></tr>
                <tr><th>Total</th><td id="totalPrice"><span id="prc_total_receipt"></span></td></tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>SetTotalPrice()</script>
    <script>GenerateReceipt()</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main_java.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>