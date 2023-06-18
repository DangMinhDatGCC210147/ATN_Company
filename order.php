<?php
    include_once 'header.php';
?>
<?php
include_once 'connect.php';
$c = new Connect();
$dblink = $c->connectToPDO();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];

    if (isset($_GET['del_id'])) {

        $order_del = $_GET['del_id'];
        // Validate and sanitize the del_id parameter
        $order_del = filter_var($order_del, FILTER_VALIDATE_INT);
    
        if ($order_del !== false) {
            // Delete associated order details first
            $query = "DELETE FROM `order_detail` WHERE or_de_or_id = ?";
            $stmt = $dblink->prepare($query);
            $stmt->execute([$order_del]);
            
            // Delete the order
            $query = "DELETE FROM `order` WHERE or_id = ?";
            $stmt = $dblink->prepare($query);
            $stmt->execute([$order_del]);
            $affectedRows = $stmt->rowCount();
    
            if ($affectedRows > 0) {
                header("Location: order.php");
                exit();
            }
        }
    }
//USERS INTERFACE   
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user'){
        $sqlSelect = "SELECT * FROM `order` od JOIN users ur ON od.user_id = ur.u_id WHERE `user_id` = ?";
        $stmt1 = $dblink->prepare($sqlSelect);
        $stmt1->execute([$user_id]);
        $rows = $stmt1->fetchAll(PDO::FETCH_BOTH);

?>
<div class="page-section section section-padding">
        <div class="container">

            <h3>Customer Name: <?=$user_name?></h3>

            <br>
            
            <form action="cart.php" method="POST">				
                <div class="row mbn-40">
                    <div class="col-12 mb-40">
                        <div class="table-responsive" id="tables">
                            <div class="cart-table table-hover" id="myTable">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="pro-price">Store ID</th>
                                        <th class="pro-price">Order ID</th>
                                        <th class="pro-quantity">Date</th>
                                        <th class="pro-subtotal">Address</th>
                                        <th class="pro-subtotal">Total</th>
                                        <th class="pro-subtotal">See more</th>
                                        <?php
                                        $check1 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager';
                                        $check2 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                                        if($check2 || $check1):
                                        ?>
                                        <th class="pro-remove">Remove</th>
                                        <?php
                                            endif;
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach( $rows as $row ):
                                        $databaseDate = $row['or_date']; // Replace 'date' with the actual column name from your database
                                        // Convert the database date to a UNIX timestamp
                                        $timestamp = strtotime($databaseDate);
                                        // Format the timestamp to your desired format
                                        $formattedDate = date("F d, Y h:i:s", $timestamp); // Replace 'Y-m-d' with your desired format
                                ?>
                                    <tr>
                                        <td class="pro-subtotal"><span class="amount"><?=$row['st_id']?></span></td>
                                        <td class="pro-subtotal"><span class="amount"><?=$row['or_id']?></span></td>
                                        <td class="pro-subtotal"><?=$formattedDate?></td>
                                        <td class="pro-subtotal"><?=$row['u_address']?></td>
                                        <td class="pro-subtotal">$<?=$row['or_total']?></td>
                                        <td class="pro-subtotal">
                                            <a href="order_detail.php?or_id=<?=$row['or_id']?>"">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                </svg>
                                            </a>
                                        </td>
                                        <?php
                                            $check1 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager';
                                            $check2 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                                            if($check2 || $check1):
                                        ?>
                                        <td class="pro-remove"><a href="order.php?del_id=<?=$row['or_id']?>">×</a></td>
                                        <?php
                                            endif;
                                        ?>
                                    </tr>
                                <?php
                                    endforeach;
                                ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- Page Section End -->
<?php
}
// 
$check1 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager';
$check2 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$check3 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user';
// 
// ADMIN and MANAGER INTERFACE
if($check1 || $check2 ){
    $sqlSelect = "SELECT * FROM `order` od JOIN users ur ON od.user_id = ur.u_id ORDER BY od.or_id";
    $stmt1 = $dblink->prepare($sqlSelect);
    $stmt1->execute();
    $rows = $stmt1->fetchAll(PDO::FETCH_BOTH);

?>
<div class="page-section section section-padding">
    <div class="container">

        <h3>Customer Name: <?=$user_name?></h3>

        <br>
        
        <!-- <form action="cart.php" method="POST">				 -->
            <div class="row mbn-40">
                <div class="col-12 mb-40">
                <div class="table-responsive" id="tables">
                    <div class="cart-table table-hover" id="myTable">
                        <table>
                            <thead>
                                <tr>
                                    <th class="pro-price">Store ID</th>
                                    <th class="pro-price">Order ID</th>
                                    <th class="pro-quantity">Date</th>
                                    <th class="pro-subtotal">Address</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-subtotal">See more</th>
                                    <?php
                                    $check1 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager';
                                    $check2 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                                    if($check2 || $check1):
                                    ?>
                                    <th class="pro-remove">Remove</th>
                                    <?php
                                        endif;
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach( $rows as $row ):
                                    $databaseDate = $row['or_date']; // Replace 'date' with the actual column name from your database
                                    // Convert the database date to a UNIX timestamp
                                    $timestamp = strtotime($databaseDate);
                                    // Format the timestamp to your desired format
                                    $formattedDate = date("M d, Y h:i:s", $timestamp); // Replace 'Y-m-d' with your desired format
                            ?>
                                <tr>
                                    <td class="pro-price"><span class="amount"><?=$row['st_id']?></span></td>
                                    <td class="pro-price"><span class="amount"><?=$row['or_id']?></span></td>
                                    <td class="pro-subtotal"><div class=""><?=$formattedDate?></td>
                                    <td class="pro-subtotal"><?=$row['u_address']?></td>
                                    <td class="pro-subtotal">$<?=$row['or_total']?></td>
                                    <td class="pro-subtotal">
                                        <a href="order_detail.php?or_id=<?=$row['or_id']?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                            </svg>
                                        </a>
                                    </td>
                                    <?php
                                        $check1 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager';
                                        $check2 = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                                        if($check2 || $check1):
                                    ?>
                                    <td class="pro-remove"><a href="order.php?del_id=<?=$row['or_id']?>">×</a></td>
                                    <?php
                                        endif;
                                    ?>
                                </tr>
                            <?php
                                endforeach;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        <!-- </form> -->
    </div>
</div><!-- Page Section End -->
<?php
}
}

?>
<!-- ======================================= -->
<script src="./assets/js/pagination.js"></script>

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