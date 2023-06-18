<?php
    include_once 'header.php';
?>

<div class="page-section section section-padding">
        <div class="container">

			<!-- Checkout Form s-->
			<form method="POST" class="checkout-form">
			   <div class="row row-50 mbn-40 check">

				    <div class="col-lg-7">
                        <h2>Billing </h2>
					   <div class="left-image"><img src="./assets/images/poster_1_2.jpg" alt=""></div>
                       <style>
                            .left-image {
                                display: flex;
                                justify-content: center; /* Align the image horizontally */
                                align-items: center; /* Align the image vertically */
                                height: 1000px; /* Adjust the height as needed */
                                
                            }

                            .left-image img {
                                border: 2px solid black;
                                max-width: 100%;
                                height: 1000px;
                                padding: 10px;
                                border-radius: 8px;
                            }
                       </style>
					</div>

				   <div class="col-lg-5">
					   <div class="row">
                       <?php
                        include_once 'connect.php';
                        $conn = new Connect();
                        $db_link = $conn->connectToPDO();
                        $userID = $_SESSION['user_id'];
                        $query = "SELECT * FROM users WHERE u_id = $userID";
                        $result = $db_link->query($query);

                        if ($result && $result->rowCount() > 0) {
                            $row = $result->fetch(PDO::FETCH_ASSOC);
                            $userPhone = $row['u_phone'];
                            $userAddress = $row['u_address'];
                        } else {
                            // Handle the case when the query fails or no matching user is found
                            $userPhone = ""; // Set a default value for the phone number
                            $userAddress = ""; // Set a default value for the address
                        }
                        ?>

						   <!-- Cart Total -->
						   <div class="col-12 mb-40" >     
                                    <h4 class="checkout-title">Customer Information</h4>
                                    <div class="checkout-cart-total">
                                        <h5 class="checkout-title">Customer name: </h5>
                                        <input type="text" class="infor-general" style="margin-right: 30px" name="u_name" value="<?=$_SESSION['user_name']?>">
                                        <h5 class="checkout-title">Phone number: </h5>
                                        <input type="text" class="infor-general" style="margin-right: 30px" name="u_phone" value="<?=$userPhone?>">
                                        <h5 class="checkout-title">Address: </h5>
                                        <input type="text" class="infor-general" style="margin-right: 30px" name="u_address" value="<?=$userAddress?>">
                                        <h5 class="checkout-title">Store: </h5>
                                        <select name="pro_st_id" class="form-select" required style="border-radius: 25px; padding: 11px; border: 1px solid black; background-color: #f6f7f8">
                                            <!-- <option>Select store name</option> -->
                                            <?php
                                                include_once 'connect.php';
                                                $conn = new Connect();
                                                $db_link = $conn->connectToMySQL();
                                                $sql = "SELECT * FROM store";
                                                $re = $db_link->query($sql);
                                                while($row = $re->fetch_assoc()):
                                            ?>
                                            <option value="<?=$row['st_id']?>"><?=$row['st_name']?></option>
                                            <?php
                                                endwhile;
                                            ?>
                                        </select>
                                    </div>

							    <h4 class="checkout-title">Cart Total</h4>
                               
							   <div class="checkout-cart-total">

								   <h4>Product <span>Total</span></h4>
                                   <?php
                                        include_once 'connect.php';
                                        $conn = new Connect();
                                        $db_link = $conn->connectToPDO();
                                    if (isset($_SESSION['user_id'])) {
                                        $user_id = $_SESSION['user_id'];    
                                        $sql = "SELECT * FROM cart c INNER JOIN products p ON c.pro_id = p.pro_id WHERE c.user_id = ?";
                                        $stmt = $db_link->prepare($sql);
                                        $stmt->execute([$user_id]);
                                        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        $totalPrice = 0; // Variable to store the total price
                                    ?>
                                    <?php foreach ($cartItems as $row) { 
                                        $sum = 0;
                                        $result = 0;
                                        $money = $row['p_count'] * $row['pro_price'];
                                        $sum += $money;    
                                    ?>
								   <ul>
									   <li><?=$row['pro_name']?> X <?=$row['p_count']?> <span>$<?=$sum?></span></li>
								   </ul>
                                   <?php
                                        $subtotal = $row['pro_price'] * $row['p_count'];
                                        $totalPrice += $subtotal;
                                    }}?>
								   <p>Sub Total <span>$<?=$totalPrice?></span></p>

								   <h4>Grand Total <span>$<?=$totalPrice?></span></h4>
                                   <input type="text" hidden name="total" value="<?= $totalPrice?>">
							   </div>
						   </div>
                           <div class="cart-buttons mb-30">
							   <button class="place-order" style="margin-right: 30px" onclick="returnToCart(event)" id="returnToCartBtn">Return to Cart</button>
                               <button class="place-order" name="btnPayment">Place order</button>
						   </div>
					   </div>
				   </div>
			   </div>
			</form>
       
        </div>
    </div><!-- Page Section End -->
    <?php

            if (isset($_POST['btnPayment'])):
                // $name = $_POST['u_name'];
                $telephone = $_POST['u_phone'];
                $address = $_POST['u_address'];
                $store = $_POST['pro_st_id'];
                $total = $_POST['total'];
                
                $user_id = $_SESSION['user_id'];
                
                // $now = date("Y-m-d H:i:s");
                // Insert into Order
                $sql_order = "INSERT INTO `order`(`user_id`, `or_u_address`, `or_total`, `or_date`, `st_id`) VALUES (?,?,?,NOW(),?)";
                $result = $db_link->prepare($sql_order);
                // $check = $result->execute(["$user_id", "$address", "$total", date("Y-m-d"), "$store"]);
                $check = $result->execute([$user_id, $address, $total, $store]);    
                $last_id = $db_link->lastInsertId();
    
                // // Select cart to add into orderdetail

                $sql_selected = "SELECT cart_id, user_id, p_count, pro_id FROM `cart` WHERE user_id = ?";
                $result = $db_link->prepare($sql_selected);
                $check = $result->execute(array("$user_id"));
    
                $row = $result->fetchAll(PDO::FETCH_ASSOC);
    
                foreach ($row as $r) :
                    $pro_id = $r['pro_id'];
                    $od_qty = $r['p_count'];
    
                    // Insert into OrderDetail
                    $sql_order = "INSERT INTO `order_detail`(`or_de_pro_id`, `or_de_qty`, `or_de_or_id`) VALUES (?,?,?)";
                    $result = $db_link->prepare($sql_order);
                    $check = $result->execute(array("$pro_id", "$od_qty", "$last_id"));
    
                     // Update into Product
                    $sql_order = "SELECT pro_qty FROM `products` WHERE `pro_id`= ?";
                    $result = $dblink->prepare($sql_order);
                    $result->execute(array("$pro_id"));
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $update_quantity = $row['pro_qty'] - $od_qty;
    
                    $sql_order = "UPDATE `products` SET `pro_qty`= ? WHERE `pro_id`= ?";
                    $result = $dblink->prepare($sql_order);
                    $check = $result->execute(array("$update_quantity", "$pro_id"));
    
                endforeach;
    
                // Delete into ShoppingCart
                $sql_order = "DELETE FROM `cart` WHERE user_id = ?";
                $result = $dblink->prepare($sql_order);
                $check = $result->execute(array("$user_id"));
                    
                header("Location: order.php");
            endif;
            // echo $telephone;
            // echo $store;
            // echo $total;
            // echo $name;
            // echo $address;
            

?>
<!-- ====================================== -->
<script>
function returnToCart(event) {
    event.preventDefault();
    document.getElementById('returnToCartBtn').disabled = true; // Disable the button
    window.location.href = 'cart.php';
}
</script>
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