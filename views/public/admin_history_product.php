<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start the session if not already started
    }

    include_once '../../models/database_connector.php'; // Include database connection file
    include_once '../../controllers/prods_con.php'; // Include Product controller file
    include_once '../../controllers/utils.php'; // Include utility functions
    include_once '../../controllers/usrs_con.php'; // Include User controller file
    include_once '../../controllers/his_con.php';
    include_once '../../controllers/ent_con.php';

    $db = new DatabaseConnector(); // Create a new instance of the database connection
    $db_conn = $db->GetConnection(); // Get the database connection
    $productController = new ProductController($db_conn); // Create a new instance of the Product controller
    $userController = new UserCnt($db_conn); // Create a new instance of the User controller
    $utils = new Utils(); // Create a new instance of the utility functions
    $entryController = new EntryController($db_conn);

    $historys = $entryController->GetAllEntry();

    if ($_SESSION['role'] != 'admin') {
        header('Location: index.php'); // Redirect to login page
        exit();
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        // handle post request
        case 'POST':
            if (isset($_POST['logout'])) {
                $utils->Redirect('logout.php');
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
    <header id="head" class="pt-5 pb-4 mb-5">
        <nav id="navbar" class="navbar navbar-expand-lg fixed-top navbar">
            <div class="container">
                <a class="navbar-brand" href="#head">
                    <span class="cl-blue">
                        V<span class="gone">ello</span>
                    </span>
                    <span class="cl-orange">
                        S<span class="gone">tore</span>
                    </span>
                    <span class="cl-blue">
                        A<span class="gone">dmin</span>
                    </span>
                </a>
    
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item px-1 active">
                            <a class="nav-link" href="admin_page.php#head">Home</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="admin_page.php#products">Products</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">History</a>
                            
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item" href="admin_history_order.php">Order History</a></li>
                                <li><a class="dropdown-item" href="admin_history_product.php">Product History</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
    
                <form class="form-inline" method="post">
                    <button class="btn btn-log" type="submit" name="logout">Logout</button>
                </form>
            </div>
        </nav>
    </header>

    <div id="history" class="container">
        <h1 class="text-center mb-5"><span class="cl-orange">Product</span> <span class="cl-blue">History</span></h1>
        
        <?php
            if (empty($historys))   {
                echo '<div class="alert alert-warning" role="alert">There is currently no product history</div>';
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
                                <p class="card-text mb-1">Date: <?php echo htmlspecialchars($history['entry_date']); ?></p>
                                <p class="card-text mb-1"><?php echo htmlspecialchars($history['product_name']); ?></p>
                                <p class="card-text mb-1">Category: <?php echo htmlspecialchars($history['product_category']); ?></p>
                                <p class="card-text mb-1">Quantity: <?php echo htmlspecialchars($history['product_quantity']); ?></p>
                                <span class="badge bg-success">Added</span>
                            </div>
                            <div class="col-md-5 text-md-end">
                                <h4 class="price-text"><?php echo htmlspecialchars($utils->ConvertToRupiah($history['product_price'])); ?></h4>
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

