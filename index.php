<?php
    include_once 'header.php';
?>
<!-- Hero Section Start -->
<div class="hero-section section">

<!-- Hero Slider Start -->
    <div class="hero-slider hero-slider-one fix">

        <!-- Hero Item Start -->
        <div class="hero-item" style="background-image: url(./assets/images/hero/hero-1.jpg); height: 80%">
            <!-- Hero Content -->
            <div class="hero-content">
                <h1>Get 35% off <br>Latest Toy Products</h1>
                <a href="shop.php">SHOP NOW</a>
            </div>
        </div><!-- Hero Item End -->

        <!-- Hero Item Start -->
        <div class="hero-item" style="background-image: url(./assets/images/hero/hero-2.jpg); height: 80%">
            <!-- Hero Content -->
            <div class="hero-content">
                <h1>Get 35% off <br>Latest Toy Products</h1>
                <a href="shop.php">SHOP NOW</a>
            </div>

        </div><!-- Hero Item End -->

    </div><!-- Hero Slider End -->

</div><!-- Hero Section End -->

<!-- Banner Section Start -->
<div class="banner-section section mt-40">
        <div class="container-fluid">
            <div class="row row-10 mbn-20">

                <div class="col-lg-4 col-md-6 col-12 mb-20">
                    <div class="banner banner-1 content-left content-middle">
                        <div class="cover-image">
                            <a href="#" class="image"><img src="./assets/images/banner/banner-1.jpg" alt="Banner Image"></a>
                        </div>

                        <div class="content">
                            <h1>Welcome <br>Summer <br>GET 15% OFF</h1>
                            <a href="shop.php" data-hover="SHOP NOW">SHOP NOW</a>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-20">
                    <div class="banner banner-1 content-left content-middle">
                        <div class="cover-image">
                            <a href="" class="image"><img src="./assets/images/banner/banner-2.jpg" alt="Banner Image"></a>
                        </div>

                        <div class="content">
                            <h1>New Game <br>New Fun <br>GET 30% OFF</h1>
                            <a href="shop.php" data-hover="SHOP NOW">SHOP NOW</a>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-20">
                    <div class="banner banner-1 content-left content-top">

                        <div class="cover-image"><a href="#" class="image"><img src="./assets/images/banner/banner-3.jpg" alt="Banner Image"></a></div>

                        <div class="content">
                            <h1>Trendy <br>Collections</h1>
                            <a href="#" data-hover="SHOP NOW">SHOP NOW</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
</div><!-- Banner Section End -->

<style>
    .content{
        backdrop-filter: blur(5px);
        background-color: #ffffff06;
    }
</style>

<!-- Product Section Start -->
<div class="product-section section section-padding">
        <div class="container">

            <div class="row">
                <div class="section-title text-center col mb-30">
                    <h1>Popular Products</h1>
                    <p>All popular product find here</p>
                </div>
            </div>

            <div class="row mbn-40">
                <?php
                require_once 'connect.php';
                $conn = new Connect();
                $dblink = $conn->connectToPDO();

                // Retrieve 10 rows from the "products" table
                $sql = "SELECT * FROM products LIMIT 4";
                $stmt = $dblink->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display the retrieved rows
                foreach ($rows as $row) {
                    
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-40">
                    <div class="product-item">
                        <div class="product-inner">
                            <div class="image">
                                <img src="./assets/images/product/<?=$row['pro_image']?>" alt="Image">

                                <div class="image-overlay">
                                    <div class="action-buttons">
                                        <button onclick="addToCart('<?=$row['pro_id']?>')">add to cart</button>
                                    </div>
                                </div>
                            </div>

                            <div class="content">
                                <div class="content-left">
                                    <h4 class="title"><a href="product_detail.php?id=<?=$row['pro_id']?>"><?=$row['pro_name']?></a></h4>
                                </div>

                                <div class="content-right">
                                    <span class="price">&#x0024;<?=$row['pro_price']?></span>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                    <?php } ?>
            </div>

        </div>
    </div><!-- Product Section End -->


<!-- JS
============================================ -->
<script src="./assets/js/addToCart.js"></script>
<!-- jQuery JS -->
<script src="./assets/js/vendor/jquery-3.6.0.min.js"></script>
<!-- Migrate JS -->
<script src="./assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
<!-- Bootstrap JS -->
<script src="./assets/js/bootstrap.bundle.min.js"></script>
<!-- Plugins JS -->
<script src="./assets/js/plugins.js"></script>
<!-- Main JS -->
<script src="./assets/js/main.js"></script>

<?php
    include_once 'footer.php';
?>