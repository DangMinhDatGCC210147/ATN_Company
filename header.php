<?php
    session_start();
    ob_start();
?>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>WonderKid World</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/Screenshot 2023-06-01 004340.png">
    
    <!-- CSS
	============================================ -->
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="./assets/css/icon-font.min.css">
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="./assets/css/plugins.css">
    
    <!-- Helper CSS -->
    <link rel="stylesheet" href="./assets/css/helper.css">
    
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    
    <!-- Modernizer JS -->
    <script src="./assets/js/vendor/modernizr-3.11.2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.all.min.js"></script>
</head>

<div class="main-wrapper">

    <!-- Header Section Start -->
    <div class="header-section section">

        <!-- Header Top Start -->
        <div class="header-top header-top-one bg-theme-two">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center">

                    <div class="col mt-10 mb-10 d-none d-md-flex">
                        <!-- Header Top Left Start -->
                        <div class="header-top-left">
                        <?php
                            if(isset($_SESSION['user_name'])):
                        ?>
                            <p>Welcome, <?=$_SESSION['user_name']?></p>
                        <?php
                            endif;
                        ?>
                            <p>Hotline: <a href="tel:0123456789">0907 294 396</a></p>
                        </div><!-- Header Top Left End -->
                    </div>


                    <div class="col mt-10 mb-10">
                        <!-- Header Shop Links Start -->
                        <div class="header-top-right">
                            <p><a href="my_account.php">My Account</a></p>
                            <p>
                                <?php if(isset($_SESSION['user_name'])):?>
                                    | <a href="logout.php">Logout</a>
                                <?php else: ?>
                                    <a href="login_register.php">Register</a><a href="login_register.php">Login</a>
                                <?php endif ?>
                            </p>

                        </div><!-- Header Shop Links End -->
                    </div>

                </div>
            </div>
        </div><!-- Header Top End -->

        <!-- Header Bottom Start -->
        <div class="header-bottom header-bottom-one header-sticky">
            <div class="container-fluid">
                <div class="row menu-center align-items-center justify-content-between">

                    <div class="col mt-15 mb-15">
                        <!-- Logo Start -->
                        <div class="header-logo">
                            <a href="index.php">
                                <img src="./assets/images/logo1.png" alt="WonderKid World">
                            </a>
                        </div><!-- Logo End -->
                    </div>

                    <div class="col order-2 order-lg-3">
                        <!-- Header Advance Search Start -->
                        <div class="header-shop-links">
                            <div class="header-search">
                                        <button class="search-toggle"><img src="./assets/images/icons/search.png" alt="Search Toggle"><img class="toggle-close" src="./assets/images/icons/close.png" alt="Search Toggle"></button>
                                <div class="header-search-wrap">
                                    <form action="search_products.php">
                                        <input type="text" name="search" placeholder="Type and hit enter">
                                        <button><img src="./assets/images/icons/search.png" alt="Search"></button>
                                    </form>
                                </div>
                            </div>
                            <?php
                            include_once 'connect.php';
                            $c = new Connect();
                            $dblink = $c->connectToPDO();
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $sqlSelect = "SELECT * FROM cart c, products p WHERE c.pro_id = p.pro_id AND user_id=?";
                                $stmt1 = $dblink->prepare($sqlSelect);
                                $stmt1->execute([$user_id]);
                                $rows = $stmt1->fetchAll(PDO::FETCH_BOTH);
                            ?>
                            <div class="header-mini-cart">
                                <a href="cart.php"><img src="./assets/images/icons/cart.png" alt="Cart"> <span><?=$stmt1->rowCount()?></span></a>
                            </div>
                            <?php
                            }
                            ?>
                        </div><!-- Header Advance Search End -->
                    </div>

                    <div class="col order-3 order-lg-2">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li class="" style="color:pink;"><a href="index.php">HOME</a></li>
                                    <li><a href="shop.php">SHOP</a></li>
                                    <?php
                                        $check1 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager';
                                        $check2 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                                        $check3 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user';
                                        if( $check1 || $check2 || $check3):
                                    ?>
                                    <li><a>MANAGE</a>
                                        <ul class="sub-menu">
                                            <?php
                                                if($check2 || $check1):
                                            ?>
                                            <li><a href="add_product.php">PRODUCT</a></li>
                                            <?php
                                                endif;
                                            ?>
                                            <?php
                                                if($check3 || $check2 || $check1):
                                            ?>
                                            <li><a href="order.php">ORDER</a></li>
                                            <?php
                                                endif;
                                            ?>
                                            <?php
                                                if($check2):
                                            ?>
                                            <li><a href="view_category.php">CATEGORY</a></li>
                                            <li><a href="manage_store.php">STORE</a></li>
                                            <li><a href="supplier.php">SUPPLIER</a></li>
                                            <?php
                                                endif;
                                            ?>
                                        </ul>
                                    </li>
                                    <?php
                                        endif;
                                    ?>
                                    <li><a href="contact.php">CONTACT</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div class="mobile-menu order-4 d-block d-lg-none col"></div>

                </div>
            </div>
        </div><!-- Header BOttom End -->

    </div><!-- Header Section End -->
