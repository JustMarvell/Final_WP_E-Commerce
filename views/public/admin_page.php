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

    if ($_SESSION['role'] != 'admin') {
        header('Location: index.php'); // Redirect to login page
        exit(); 
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['logout'])) {
                $utils->Redirect('logout.php');
            }
            if (isset($_POST['delete'])) {
                $productController->DeleteProduct($_POST);
                Utils::Redirect('admin_page.php');
            }
            if (isset($_POST['add_product'])) {
                Utils::Redirect('admin_add_product.php');
            }
        break;
        case 'GET':
            if (isset($_GET['keyword'])) {
                $keyword = strval($_GET['keyword']);
                $products = $productController->SearchProduct($keyword);
            }
        break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | VelloStore</title>

    <link rel="stylesheet" href="css/main_style.css">
    <link rel="stylesheet" href="css/admin_page.css">
    
    <link rel="shortcut icon" href="uploads/logos/Logo_2.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar_admin.php'; ?>

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
                        <h5>VelloStore Tool's and Tech</h5>
                        <p>For all your tech and tool needs</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/Tech_BG_1.jpg d-block w-100" alt=""> -->
                    <div class="d-block w-100 carousel-box-2"></div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>A good admin</h5>
                        <p>Will never abuse his power</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/Tech_BG_1.jpg d-block w-100" alt=""> -->
                    <div class="d-block w-100 carousel-box-3"></div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Don't forget to rest and eat</h5>
                        <p>Remember to take care of yourself</p>
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
    <div class="container mt-4">
        <form class="row domain-search bg-pblue">
            <div class="col-md-3">
                <h2 class="form-title">Find Item <strong>In Stock</strong></h2>
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
        </form>
    </div>

    <!-- Product list -->
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
                    <div class="d-flex align-items-center justify-content-center overflow-hidden">
                        <img src="<?php echo htmlspecialchars($product['prod_img']); ?>" class="product-image" alt="Product">
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($product['prod_name']); ?></h5>
                        <div class="d-flex align-items-center mb-3">
                            <?php echo htmlspecialchars($product['prod_category']); ?>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            In Stock : <?php echo htmlspecialchars($product['prod_qty']); ?>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <form action="admin_edit_product.php" method="get">
                                <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>">
                                <button name="edit" type="submit" class="btn btn-custom text-white px-4 py-2 rounded-pill">
                                    Edit Product
                                </button>
                            </form>
                            <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>">
                                <button name="delete" type="submit" class="btn btn-custom text-white px-4 py-2 rounded-pill">
                                    Delete Product
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main_java.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>