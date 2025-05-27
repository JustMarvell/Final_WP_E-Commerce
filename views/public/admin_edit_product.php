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

    if (!isset($_GET['prod_id'])) {
        die ('INVALID PRODUCT ID');
    }

    $prd_id = strval($_GET['prod_id']);
    $product = $productController->GetProductByID($prd_id);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['logout'])) {
                $utils->Redirect('logout.php');
            }
            if (isset($_POST['edit_prod'])) {
                $productController->EditProduct($_POST, $_FILES);
                Utils::Redirect('admin_page.php');
            }
            if (isset($_POST['add_product'])) {
                Utils::Redirect('admin_add_product.php');
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
    <title>Edit | VelloStore</title>

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
    <?php include 'navbar_admin.php'; ?>

    <!-- Edit -->
    <div class="container mt-5">
        <div class="registration-form">
            <form method="POST" action="" enctype="multipart/form-data">
                <?php if ($product): ?>
                    <input type="hidden" name="prod_id" value="<?php echo isset($product) ? $product['id'] : ''; ?> ">
                    <input type="hidden" name="current_image" value="<?php echo isset($product) ? $product['prod_img'] : ''; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <input type="text" class="form-control item" placeholder="Product name..." name="prod_name" required
                        value="<?php echo isset($product) ? $product['prod_name'] : ''; ?>">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control item" placeholder="Product price..." name="prod_price" required min="1"
                    value="<?= $product['prod_price'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control item" placeholder="Product quantity" name="prod_qty" required min="1"
                    value="<?php echo isset($product) ? $product['prod_qty'] : ''; ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control item" placeholder="Product category" name="prod_category" required
                    value="<?php echo isset($product) ? $product['prod_category'] : ''; ?>">
                </div>
                <div class="form-group">
                    <textarea name="prod_desc" required class="form-control item" placeholder="Product description..."><?php echo isset($product) ? $product['prod_desc'] : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control item" placeholder="<?= $product['prod_img'] ?? ''; ?>" name="prod_img">
                </div>
                <div class="form-group">
                    <button type="submit" name="edit_prod" class="btn btn-success">Edit Product</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main_java.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>