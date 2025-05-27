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
                    <?php if (!isset($in_add_product)) : ?>
                    <button class="btn btn-log" type="submit" style="font-size: 18px;" name="add_product">Add product</button>
                    <?php endif; ?>
                    <button class="btn btn-log" type="submit" name="logout">Logout</button>
                </form>
            </div>
        </nav>
    </header>