<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start the session if not already started
    }

    include_once '../../models/database_connector.php'; // Include database connection file
    include_once '../../controllers/prods_con.php'; // Include Product controller file
    include_once '../../controllers/utils.php'; // Include utility functions
    include_once '../../controllers/usrs_con.php'; // Include User controller file
    include_once '../../controllers/his_con.php';

    $db = new DatabaseConnector(); // Create a new instance of the database connection
    $db_conn = $db->GetConnection(); // Get the database connection
    $productController = new ProductController($db_conn); // Create a new instance of the Product controller
    $userController = new UserCnt($db_conn); // Create a new instance of the User controller
    $utils = new Utils(); // Create a new instance of the utility functions
    $historyController = new HistoryController($db_conn);

    $historys = $historyController->GetHistoryByUser($_SESSION['user_id']);

    // check if logged in or nah
    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true) {
        $logged_in = true;
        $log_button = '<button class="btn btn-log" type="submit" name="logout">Logout</button>';
    } else {
        $logged_in = false;
        $log_button = '<button class="btn btn-log" type="submit" name="login">Login</button>';
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        // handle post request
        case 'POST':
            if (isset($_POST['logout'])) {
                $utils->Redirect('logout.php');
            }
            if (isset($_POST['login'])) {
                $utils->Redirect('logreg.php');
            }
        break;
        // handle get request
        case 'GET':
            if (isset($_GET['keyword'])) {
                $keyword = strval($_GET['keyword']);
                $products = $productController->SearchProduct($keyword);
            }
        break;
    }

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     // Proses pencarian produk
    //     $keyword = $_POST['keyword'] ?? '';

    //     // Mencari produk berdasarkan keyword dan kategori
    //     $products = $productController->SearchProduct($keyword);
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History | VelloStore</title>

    <link rel="stylesheet" href="css/main_style.css">
    <link rel="stylesheet" href="css/product_history.css">

    <!-- <link rel="stylesheet" href="css/products_page.css"> -->
    <link rel="shortcut icon" href="uploads/logos/Logo_2.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- BS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <?php include_once 'navbar_user.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-5"><span class="cl-orange">Order</span> <span class="cl-blue">History</span></h1>
        
        <?php
            if (empty($historys) && $logged_in == true)   {
                echo '<div class="alert alert-warning" role="alert">You have no purchase history</div>';
            } else if (empty($historys) && $logged_in == false) {
                echo '<div class="alert alert-warning" role="alert">You have no purchase history please log in first</div>';
            }
        ?>

        <div class="row g-4">
            <!-- repeat from here -->
            <?php foreach($historys as $history): ?>
            <div class="col-12">
                <div class="card order-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h5 class="card-title">ID : <?php echo htmlspecialchars($history['id']); ?></h5>
                                <p class="card-text mb-1">Date: <?php echo htmlspecialchars($history['order_date']); ?></p>
                                <p class="card-text mb-1"><?php echo htmlspecialchars($history['product_name']); ?></p>
                                <p class="card-text mb-1">Quantity: <?php echo htmlspecialchars($history['order_qty']); ?></p>
                                <span class="badge bg-success">Delivered</span>
                            </div>
                            <div class="col-md-5 text-md-end">
                                <h4 class="price-text"><?php echo htmlspecialchars($utils->ConvertToRupiah($history['total_price'])); ?></h4>
                                <!-- <button class="btn btn-primary mt-2">View Product</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container mt-5 pt-2"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main_java.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>

