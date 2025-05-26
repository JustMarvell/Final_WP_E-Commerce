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

    if ($_SESSION['role'] != 'admin') {
        header('Location: index.php'); // Redirect to login page
        exit();
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['logout'])) {
                $utils->Redirect('logout.php');
            }
            if (isset($_POST['add_new_prod'])) {
                $productController->AddNewProduct($_POST, $_FILES); // Call method to add new product
                Utils::Redirect('admin_page.php');
            }
        break;
        case 'GET':
        break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add | VelloStore</title>

    <link rel="stylesheet" href="css/main_style.css">
    <link rel="stylesheet" href="css/admin_add_product.css">
    
    <link rel="shortcut icon" href="uploads/logos/Logo_2.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <header id="head" class="pt-5 pb-4">
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

    <!-- Add item -->
    <div class="container mt-5">
        <div class="registration-form">
            <form method="POST" action="" enctype="multipart/form-data">
                <?php if (isset($current_data)): ?>
                    <input type="hidden" name="id" value="<?php echo $current_data['id']; ?>">
                    <input type="hidden" name="gambar_lama" value="<?php echo $current_data['gambar']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <input type="text" class="form-control item" placeholder="Product name..." name="prod_name" required
                        value="<?php echo isset($current_data) ? $current_data['prod_name'] : ''; ?>">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control item" placeholder="Product price..." name="prod_price" required min="1"
                    value="<?php echo isset($current_data) ? $current_data['prod_price'] : ''; ?>">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control item" placeholder="Product quantity" name="prod_qty" required min="1"
                    value="<?php echo isset($current_data) ? $current_data['prod_qty'] : ''; ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control item" placeholder="Product category" name="prod_category" required
                    value="<?php echo isset($current_data) ? $current_data['prod_category'] : ''; ?>">
                </div>
                <div class="form-group">
                    <textarea name="prod_desc" required class="form-control item" placeholder="Product description..."><?php echo isset($current_data) ? $current_data['prod_desc'] : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control item" placeholder="Product image..." name="prod_img" required
                    value="<?php echo isset($current_data) ? $current_data['nama'] : ''; ?>">
                    <?php if (isset($current_data) && $current_data['prod_img']): ?>
                        <br>
                        <img src="uploads/<?php echo $current_data['prod_img']; ?>" class="img-prw">
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <?php if (isset($current_data)) : ?>
                        <button type="submit" name="update" class="btn btn-block create-account">Update Data</button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-block create-account">Cancel</a>
                    <?php else: ?>
                        <button type="submit" name="add_new_prod" class="btn btn-block create-account">Add New Product</button>
                    <?php endif; ?>
                        
                    <!-- <button type="submit" class="btn btn-block create-account">Add new product</button> -->
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main_java.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>