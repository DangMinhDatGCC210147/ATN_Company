<?php
    include_once 'header.php';
?>
<!-- CSS -->
<link rel="stylesheet" href="./assets/css/style.css">

<div class="page-section section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                </div>
                <?php
                    include_once 'connect.php';
                    $c = new Connect();
                    $dblink = $c->connectToPDO();
                    $nameP = $_GET['search'];
                    $sql = "SELECT * FROM `products` pr JOIN category ca JOIN store st ON ca.cate_id = pr.pro_cate_id AND pr.pro_st_id = st.st_id WHERE pro_name LIKE ?";
                    $re = $dblink->prepare($sql);
                    $re->execute(array("%$nameP%"));
                    $rows = $re->fetchAll(PDO::FETCH_BOTH); 
                    foreach($rows as $row):
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-40">
                    <div class="product-item">
                        <div class="product-inner">
                            <div class="image">
                                <img src="./assets/images/product/<?=$row['pro_image']?>" alt="Image">

                                <div class="image-overlay">
                                    <div class="action-buttons">
                                        <button onclick="addToCart('<?=$row['pro_id']?>')">add to cart</button>
                                        <button>add to wishlist</button>
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
                <?php
                    endforeach;
                ?>
                <!-- Brand Section Start -->
            </div>
        </div>
        <!-- Pagination -->
  <div id="pagination" class="pagination"></div>

    <div class="brand-section section section-padding pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="brand-slider">

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-1.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-2.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-3.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-4.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-5.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-6.png" alt="">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div><!-- Brand Section End -->


<!-- JS
============================================ -->
<!-- jQuery JS -->
<script src="./assets/js/addToCart.js"></script>
<script src="./assets/js/vendor/jquery-3.6.0.min.js"></script>
<!-- Migrate JS -->
<script src="./assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
<!-- Bootstrap JS -->
<script src="./assets/js/bootstrap.bundle.min.js"></script>
<!-- Plugins JS -->
<script src="./assets/js/plugins.js"></script>
<!-- Main JS -->
<script src="./assets/js/main.js"></script>
<!--  -->
<?php
    include_once 'footer.php';
?>