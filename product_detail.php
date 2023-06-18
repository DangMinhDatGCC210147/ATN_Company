<?php
    include_once 'header.php';
?>
<?php
if(isset($_GET['id'])):
        $pid = $_GET['id'];
        require_once 'connect.php';
        $conn = new Connect();
		$dblink = $conn->connectToPDO();
		$sql = "SELECT * FROM products WHERE `pro_id` = ?";
		$stmt = $dblink->prepare($sql);
		$stmt->execute(array($pid));
		$re = $stmt->fetch(PDO::FETCH_BOTH);
        $qtyInStock = $re['pro_qty'];

        if (isset($_SESSION['user_id']) && isset($_POST['pro-qty'])) {
            $user_id = $_SESSION['user_id'];
            $pro_qty = $_POST['pro-qty'];
            $pro_id = $_GET['id'];
        
            $sqlSelectCart = "SELECT * FROM cart WHERE user_id = ? AND pro_id = ?";
            $stmt = $dblink->prepare($sqlSelectCart);
            $stmt->execute([$user_id, $pro_id]);
        
            if ($stmt->rowCount() == 0) {
                $sqlSelectProduct = "SELECT pro_qty FROM products WHERE pro_id = ?";
                $stmt = $dblink->prepare($sqlSelectProduct);
                $stmt->execute([$pro_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $db_qty = $row['pro_qty'];
        
                if ($pro_qty < $db_qty) {
                    $sqlInsert = "INSERT INTO cart (user_id, pro_id, p_count, cart_date) VALUES (?, ?, ?, CURDATE())";
                    $stmt = $dblink->prepare($sqlInsert);
                    $stmt->execute([$user_id, $pro_id, $pro_qty]);
                    // header("Location: cart.php");
                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        title: "Item added to cart successfully!",
                        showConfirmButton: false,
                        timer: 1500
                      }).then(() => {
                        window.location.href = "cart.php";
                    });
                    </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "The quantity entered is not allow more than the quantity in the stock."
                            });
                        </script>';
                }
            } else {
                $sqlSelectCart = "SELECT * FROM cart WHERE user_id = ? AND pro_id = ?";
                $stmt = $dblink->prepare($sqlSelectCart);
                $stmt->execute([$user_id, $pro_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $db_qtyInCart = $row['p_count'];
                if(($db_qtyInCart + $pro_qty) > $qtyInStock){
                    echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "There is available in cart and the quantity entered is not allow more than the quantity in the stock."
                    });
                    </script>';
                }else{
                    $sqlUpdate = "UPDATE cart SET p_count = p_count + ? WHERE user_id = ? AND pro_id = ?";
                    $stmt = $dblink->prepare($sqlUpdate);
                    $stmt->execute([$pro_qty, $user_id, $pro_id]);
                    header("Location: cart.php");
                }
                
            }
            
        }
        

?>
<div class="page-section section section-padding">
        <div class="container">
            <div class="row row-30 mbn-50">
                <div class="col-12">
                    <div class="row row-20 mb-10">

                        <div class="col-lg-6 col-12 mb-40">

                            <div class="pro-large-img mb-10 fix easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                <a href="./assets/images/product/<?=$re['pro_image']?>">
                                    <img src="./assets/images/product/<?=$re['pro_image']?>" alt=""/>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 mb-40">
                            <div class="single-product-content">

                                <div class="head">
                                    <div class="head-left">

                                        <h3 class="title"><?=$re['pro_name']?></h3>

                                    </div>

                                    <div class="head-right">
                                        <span class="price">$<?=$re['pro_price']?></span>
                                    </div>
                                </div>

                                <div class="description">
                                    <p><?=$re['pro_des']?></p>
                                </div>
                                <?php
                                    include_once 'connect.php';
                                    $conn = new Connect();
                                    $db_link = $conn->connectToMySQL();
                                    $sql = "SELECT * FROM products";
                                    $re = $db_link->query($sql);
                                    $row = $re->fetch_assoc();
                                        $pro_qty = $row['pro_qty'];
                                            // Check if p_count is greater than 2
                                            if ($pro_qty > 3) {
                                                $stockStatus = "In Stock";
                                            } else {
                                                $stockStatus = "Out of Stock";
                                            }
                                ?>
                                <span class="availability">Availability: <span><?=$stockStatus?></span></span>

                                <form method="POST">
                                <div class="quantity-colors">
                                    <div class="quantity">
                                        <h5>Quantity:</h5>
                                        <div class="pro-qty"><input name="pro-qty" type="text" value="1"></div>
                                    </div>                                                      
                                    </div>
                                <div class="actions">
                                    <button type="submit"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></button>
                                </div>
                                </form>


                                <div class="tags">
                                <?php
                                    include_once 'connect.php';
                                    $conn = new Connect();
                                    $db_link = $conn->connectToMySQL();
                                    $sql = "SELECT * FROM products pr, category c WHERE pr.pro_cate_id = c.cate_id";
                                    $re = $db_link->query($sql);
                                    $row = $re->fetch_assoc();
                                ?>
                                    <h5>Tags:</h5>
                                    
                                    <p><?=$row['cate_name']?></p>

                                </div>


                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div><!-- Page Section End -->
<?php
    else:
?>
    <h2>Nothing to show</h2>
<?php
    endif;
?>

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