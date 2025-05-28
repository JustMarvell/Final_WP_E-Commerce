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
                        <li class="nav-item px-1">
                            <a class="nav-link"><?php if (isset($_SESSION['username'])) echo 'Logged in as : ' . $_SESSION['username']; ?></a>
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
                    <?php echo $log_button; ?>
                </form>
            </div>
        </nav>
    </header>