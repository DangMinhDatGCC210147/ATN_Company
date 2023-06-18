<?php
    include_once 'header.php';
?>
<!-- CSS -->

<div class="page-section section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                <div class="product-short">
                    <h4>Sort by:</h4>
                    <select class="nice-select" onchange="sortProducts(this.value)">
                        <option option value="price_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'price_asc') echo 'selected'; ?>>Price Ascending</option>
                        <option value="price_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'price_desc') echo 'selected'; ?>>Price Descending</option>
                    </select>
                </div>
                </div>
                <?php
                    include_once 'connect.php';
                    $conn = new Connect();
                    $db_link = $conn->connectToMySQL();

                    $orderBy = ""; // Variable to store the ORDER BY clause for sorting

                    if (isset($_GET['sort'])) {
                        // Get the selected sorting option from the query string
                        $sortOption = $_GET['sort'];

                        // Set the ORDER BY clause based on the selected sorting option
                        switch ($sortOption) {
                            case 'price_asc':
                                $orderBy = "ORDER BY pr.pro_price ASC";
                                break;
                            case 'price_desc':
                                $orderBy = "ORDER BY pr.pro_price DESC";
                                break;
                            default:
                                $orderBy = ""; // Default sorting option (no sorting)
                                break;
                        }
                    }

                    $sql = "SELECT * FROM `products` pr JOIN category ca JOIN store st ON ca.cate_id = pr.pro_cate_id AND pr.pro_st_id = st.st_id $orderBy";
                    $re = $db_link->query($sql);
                    while($row = $re->fetch_assoc()):  
                ?>
                
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-40">
                    <div class="product-item">
                        <div class="product-inner">
                            <div class="image">
                                <img src="./assets/images/product/<?=$row['pro_image']?>" alt="Image">

                                <div class="image-overlay">
                                    <div class="action-buttons">
                                        <button onclick="addToCart('<?=$row['pro_id']?>')">add to cart</button>
                                        <!-- <button>add to wishlist</button> -->
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
                    endwhile;
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
<!--  -->
<script>
function sortProducts(value) {
  window.location.href = 'shop.php?sort=' + value;
}
</script>
<?php
    include_once 'footer.php';
?>