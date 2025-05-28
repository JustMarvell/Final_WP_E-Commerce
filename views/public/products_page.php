<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start the session if not already started
    }

    include_once '../../models/database_connector.php'; // Include database connection file
    include_once '../../controllers/prods_con.php'; // Include Product controller file
    include_once '../../controllers/utils.php'; // Include utility functions
    include_once '../../controllers/usrs_con.php'; // Include User controller file

    $db = new DatabaseConnector(); // Create a new instance of the database connection
    $db_conn = $db->GetConnection(); // Get the database connection
    $productController = new ProductController($db_conn); // Create a new instance of the Product controller
    $userController = new UserCnt($db_conn); // Create a new instance of the User controller
    $utils = new Utils(); // Create a new instance of the utility functions

    $products = $productController->GetProducts();

    // check if logged in or nah
    if (isset($_SESSION['is_logged_in']) && isset($_SESSION['is_logged_in']) == true) {
        $log_button = '<button class="btn btn-log" type="submit" name="logout">Logout</button>';
    } else {
        $log_button = '<button class="btn btn-log" type="submit" name="login">Login</button>';
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        // handle post request
        case 'POST':
            if (isset($_POST['logout'])) {
                $utils->Redirect('logout.php');
            }
            if (isset($_POST['purch_prod'])) {
                header("Location:product_buy.php?prod_id=" . $_POST['prod_id']);
            }
            if (isset($_POST['login'])) {
                $utils->Redirect('logreg.php');
            }

            // $keyword = $_POST['keyword'] ?? '';

            // $products =  $productController->SearchProduct($keyword);
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
    <title>Products | VelloStore</title>

    <link rel="stylesheet" href="css/main_style.css">
    <link rel="stylesheet" href="css/products_page.css">

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

    <!-- Carousel -->
    <div class="container mt-4">
        <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#productsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#productsCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#productsCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/Tech_BG_1.jpg d-block w-100" alt=""> -->
                    <div class="d-block w-100 carousel-box-1"></div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Technology Products</h5>
                        <p>All your tech needs available in one place</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/Tech_BG_1.jpg d-block w-100" alt=""> -->
                    <div class="d-block w-100 carousel-box-2"></div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Utility Tools</h5>
                        <p>All your tools available in one place</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/Tech_BG_1.jpg d-block w-100" alt=""> -->
                    <div class="d-block w-100 carousel-box-3"></div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Shop and Enjoy!</h5>
                        <p>Shop now and enjoy the benefits!</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Search box -->
    <div class="container mt-3">
        <form class="row domain-search bg-pblue">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h2 class="form-title">Find Your <strong>Dream Products</strong></h2>
                        <p>Search for your item now</p>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group search-box">
                            <form action="" method="POST">
                                <input name="keyword" id="keyword" type="text" placeholder="Enter product name or category..." style="font-style: italic;" class="form-control">
                                <!-- <span class="input-group-addon"><input type="submit" value="Search" class="btn btn-primary"></span> -->
                                <button class="input-group-addon btn btn-primary" type="submit" name="search">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Products -->
    <div  id="products"></div>
    <div class="container mt-5 products-list">
        <?php
            if (empty($products))   {
                echo '<div class="alert alert-danger" role="alert">No products found</div>';
            }
        ?>

        <div class="row justify-content-between">
            <?php foreach($products as $product): ?>
            <div class="col-md-4 mb-5">
                <div class="product-card bg-white rounded-4 shadow-sm h-100 position-relative">
                    <div class="product-image-container">
                        <img src="<?php echo htmlspecialchars($product['prod_img']); ?>" class="product-image w-100" alt="Product">
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-3 text-truncate" style="line-clamp: 2; -webkit-line-clamp: 2; line-height: 2; line-clamp: 2; -webkit-box-orient: vertical;"><?php echo htmlspecialchars($product['prod_name']); ?></h5>
                        <div class="d-flex align-items-center mb-3 truncate-2">
                            <?php echo htmlspecialchars($product['prod_category']); ?>
                        </div>
                        <!-- <p class="text-muted mb-4 truncate-4">
                            <?php echo htmlspecialchars($product['prod_desc']); ?>
                        </p> -->
                        <!-- <div class="d-flex justify-content-between align-items-center">
                            <span class="price">
                                <?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?>
                            </span>
                            <form method="post">
                                <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>">
                                <button name="purch_prod" type="submit" class="btn btn-custom text-white px-4 py-2 rounded-pill">
                                    Buy Product
                                </button>
                            </form>
                        </div> -->
                        <div class="mb-4">
                            <span class="price">
                                <?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?>
                            </span>
                        </div>
                        <div class="align-items-end">
                            <form method="post">
                                <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>">
                                <button name="purch_prod" type="submit" class="btn btn-custom text-white px-4 py-2 rounded-pill">
                                    Buy Product
                                </button>
                            </form>
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