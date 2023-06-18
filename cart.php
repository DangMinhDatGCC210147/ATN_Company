<?php
    include_once 'header.php';
?>
<link rel="stylesheet" href="./assets/css/loading.css">
<?php
include_once 'connect.php';
$c = new Connect();
$dblink = $c->connectToPDO();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['pro_id']) && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
        $p_id = $_POST['pro_id'];
        // $quant = $_GET['pro-qty'];

        // Check if the item already exists in the cart
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    $sqlSelect1 = "SELECT * FROM cart WHERE user_id = ? AND pro_id = ?";
    $stmt = $dblink->prepare($sqlSelect1);
    $stmt->execute([$user_id, $p_id]);

    if ($stmt->rowCount() == 0) {
        // Nếu sản phẩm chưa tồn tại, thực hiện việc thêm nó vào giỏ hàng
        $query = "INSERT INTO cart (user_id, pro_id, p_count, cart_date) VALUES (?, ?, ?, CURDATE())";
        $stmt = $dblink->prepare($query);
        $stmt->execute([$user_id, $p_id, 1]);
    } else {
    // Nếu sản phẩm đã tồn tại, lấy số lượng đã có trong giỏ hàng và trong bảng sản phẩm
        $sqlSelectCart = "SELECT p_count FROM cart WHERE user_id = ? AND pro_id = ?";
        $stmtCart = $dblink->prepare($sqlSelectCart);
        $stmtCart->execute([$user_id, $p_id]);

        $row = $stmtCart->fetch(PDO::FETCH_ASSOC);
        $cartQuantity = $row['p_count'];

        $sqlSelectQuantity = "SELECT pro_qty FROM products WHERE pro_id = ?";
        $stmtQuantity = $dblink->prepare($sqlSelectQuantity);
        $stmtQuantity->execute([$p_id]);

        $row = $stmtQuantity->fetch(PDO::FETCH_ASSOC);
        $productQuantity = $row['pro_qty'];

        if ($cartQuantity < $productQuantity) {
            // Nếu số lượng trong giỏ hàng chưa đạt tối đa, cập nhật số lượng
            $query = "UPDATE cart SET p_count = p_count + 1 WHERE user_id = ? AND pro_id = ?";
            $stmt = $dblink->prepare($query);
            $stmt->execute([$user_id, $p_id]);
        }else{
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Quantity exceeds the available quantity for some products. Cart not updated."
            });
            </script>';
        }
    }}else if (isset($_GET['del_id'])) {
            $cart_del = $_GET['del_id'];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmed']) && $_POST['confirmed'] === 'true') {
            // Perform the deletion
            $query = "DELETE FROM cart WHERE cart_id = ?";
            $stmt = $dblink->prepare($query);
            $stmt->execute([$cart_del]);
    
            if ($stmt->rowCount() > 0) {
                header("Location: cart.php");
            }
        } else {
            echo '<script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form with confirmed flag
                        const form = document.createElement("form");
                        form.method = "post";
                        form.action = "cart.php?del_id=' . $cart_del . '";
    
                        const input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "confirmed";
                        input.value = "true";
    
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            </script>';
        }
    }else if (isset($_POST['update_cart'])) {
        $quantities = $_POST['quantity'];
        $user_id = $_SESSION['user_id'];
        $cartUpdated = true;

        foreach ($quantities as $cart_id => $quantity) {
            // Retrieve the product ID, available quantity, and current cart quantity
            $query = "SELECT c.pro_id, p.pro_qty, c.p_count FROM cart c
                      INNER JOIN products p ON c.pro_id = p.pro_id
                      WHERE c.cart_id = ? AND c.user_id = ?";
            $stmt = $dblink->prepare($query);
            $stmt->execute([$cart_id, $user_id]);
            $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($cartItem) {
                $product_id = $cartItem['pro_id'];
                $available_quantity = $cartItem['pro_qty'];
                $current_quantity = $cartItem['p_count'];
    
                // Check if the desired quantity exceeds the available quantity
                if ($quantity > $available_quantity) {
                    $cartUpdated = false;
                    break; // Stop checking further items
                }
    
                // Update the quantity in the cart table
                $query = "UPDATE cart SET p_count = ? WHERE cart_id = ? AND user_id = ?";
                $stmt = $dblink->prepare($query);
                $stmt->execute([$quantity, $cart_id, $user_id]);
            }
        }
        if ($cartUpdated) {
            // Redirect to the cart page to display the updated cart
            header("Location: cart.php");
            exit();
        } else {
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Quantity exceeds the available quantity for some products. Cart not updated."
                        });
                    </script>';
        }
    }
    
    // Query to fetch cart items
    $sqlSelect = "SELECT * FROM cart c, products p WHERE c.pro_id = p.pro_id AND user_id=?";
    $stmt1 = $dblink->prepare($sqlSelect);
    $stmt1->execute([$user_id]);
    $rows = $stmt1->fetchAll(PDO::FETCH_BOTH);

    $totalPrice = 0; // Variable to store the total price
?>

    <div class="page-section section section-padding">
        <div class="container">
            <h3><?=$stmt1->rowCount()?> item(s)</h3>
            <form action="cart.php" method="POST">				
                <div class="row mbn-40">
                    <div class="col-12 mb-40">
                        <div class="cart-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Image</th>
                                        <th class="pro-title">Product</th>
                                        <th class="pro-price">Price</th>
                                        <th class="pro-quantity">Quantity</th>
                                        <th class="pro-subtotal">Total</th>
                                        <th class="pro-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach( $rows as $row ):
                                            $sum = 0;
                                            $result = 0;
                                            $money = $row['p_count'] * $row['pro_price'];
                                            $sum += $money;
                                            // $result += $sum;   
                                    ?>
                                    <tr class="cart-row">
                                        <td class="pro-thumbnail"><a><img src="./assets/images/product/<?=$row['pro_image']?>" alt="" /></a></td>
                                        <td class="pro-title"><a href="product_detail.php?id=<?=$row['pro_id']?>"><?=$row['pro_name']?></a></td>
                                        <td class="pro-price"><span class="amount">$<?=$row['pro_price']?></span></td>
                                        <td class="pro-quantity">
                                            <div class="pro-qty">
                                                <input type="" name="quantity[<?php echo $row['cart_id']; ?>]" value="<?php echo $row['p_count'] ?>" min="1" class="quantity-input">
                                            </div>
                                        </td>
                                        <td class="pro-subtotal">$<?=$sum?></td>
                                        <td class="pro-remove"><a href="cart.php?del_id=<?=$row['cart_id']?>">×</a></td>
                                    </tr>
                                    <?php
                                        // Calculate the subtotal for each item and add it to the total price
                                        $subtotal = $row['pro_price'] * $row['p_count'];
                                        $totalPrice += $subtotal;
                                        endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                                if (isset($_SESSION['user_id'])) {
                                    $user_id = $_SESSION['user_id'];
                                       
                                    $sqlSelect2 = "SELECT * FROM cart WHERE user_id = ?";
                                    $stmt = $dblink->prepare($sqlSelect2);
                                    $stmt->execute([$user_id]);
                            
                                    if ($stmt->rowCount() > 0) {
                            ?>
                    <div class="col-lg-8 col-md-7 col-12 mb-40">
                        <div class="cart-buttons mb-30">
                            <input type="submit" name="update_cart" value="Update Cart">
                            <a href="shop.php">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-12 mb-40">
                        <div class="cart-total fix">

                            <h3>Cart Totals</h3>

                            <table>
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td><span id="total-price" class="amount">$<?php echo $totalPrice ?></span></td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td>
                                            <strong><span id="total-price" class="amount">$<?php echo $totalPrice ?></span></strong>
                                        </td>
                                    </tr>											
                                </tbody>
                            </table>

                            <div class="proceed-to-checkout section mt-30">

                                <a href="check_out.php">Proceed to Checkout</a>

                            </div>
                            <?php
                                }else{
                            ?>
                            <div aria-label="Orange and tan hamster running in a metal wheel" role="img" class="wheel-and-hamster">
                                <div class="wheel"></div>
                                <div class="hamster">
                                    <div class="hamster__body">
                                        <div class="hamster__head">
                                            <div class="hamster__ear"></div>
                                            <div class="hamster__eye"></div>
                                            <div class="hamster__nose"></div>
                                        </div>
                                        <div class="hamster__limb hamster__limb--fr"></div>
                                        <div class="hamster__limb hamster__limb--fl"></div>
                                        <div class="hamster__limb hamster__limb--br"></div>
                                        <div class="hamster__limb hamster__limb--bl"></div>
                                        <div class="hamster__tail"></div>
                                    </div>
                                </div>
                                <div class="spoke"></div>
                            </div>
                            <div class="cart-buttons mb-30" style="align-items:center;justify-content:center;display:flex">
                                <a href="shop.php">Continue Shopping</a>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- Page Section End -->
    <?php
} else {
    header("Location: login_register.php");
}
?>

<!--  -->
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
<?php
    include_once 'footer.php';
?>
