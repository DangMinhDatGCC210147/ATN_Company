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
    if (isset($_GET['or_id'])) {
        $orderId = $_GET['or_id'];

        $sql = "SELECT * 
        FROM order_detail as od JOIN products as pr 
        JOIN category as ca JOIN `order` as ord JOIN users as u
        ON od.or_de_pro_id = pr.pro_id 
        AND pr.pro_cate_id = ca.cate_id 
        AND ord.or_id = od.or_de_or_id 
        AND ord.user_id = u.u_id
        WHERE `or_de_or_id` = ?";
        $stmt = $dblink->prepare($sql);
        $stmt->execute(array($orderId));
        $rows = $stmt->fetchAll(PDO::FETCH_BOTH);
?>

<div class="page-section section section-padding">
    <div class="container">

<?php if (!empty($rows)): ?>
    <h3>Customer Name: <?=$rows[0]['u_lastName']?> <?=$rows[0]['u_firstName']?></h3>
    <h3>Order ID: <?=$orderId?></h3>
    <!-- Rest of your code -->
<?php endif; ?>
        <a href="order.php">
            <h3 style="color: #F266AB; font-weight: bold">Turn back</h3>
        </a>
        <br>
        
        <form action="cart.php" method="POST">				
            <div class="row mbn-40">
                <div class="col-12 mb-40">
                    <div class="table-responsive" id="tables">
                        <div class="cart-table table-hover" id="myTable">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="pro-quantity">Image</th>
                                        <th class="pro-price">Product Name</th>
                                        <th class="pro-quantity">Price</th>
                                        <th class="pro-subtotal">Category Name</th>
                                        <th class="pro-subtotal">Quantity</th>
                                        <th class="pro-subtotal">Total</th>
                                        <th class="pro-subtotal">Date buy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): 
                                            $databaseDate = $row['or_date']; // Replace 'date' with the actual column name from your database
                                            // Convert the database date to a UNIX timestamp
                                            $timestamp = strtotime($databaseDate);
                                            // Format the timestamp to your desired format
                                            $formattedDate = date('M d, Y', $timestamp); // Replace 'Y-m-d' with your desired format    
                                    ?>
                                        
                                    <tr>
                                    
                                        <td class="pro-thumbnail"><a><img src="./assets/images/product/<?=$row['pro_image']?>" alt="" /></a></td>
                                        <td class="pro-price"><span class="amount"><?=$row['pro_name']?></span></td>
                                        <td class="pro-subtotal">$<?=$row['pro_price']?></td>
                                        <td class="pro-subtotal"><?=$row['cate_name']?></td>
                                        <td class="pro-subtotal"><?=$row['or_de_qty']?></td>
                                        <td class="pro-subtotal">$<?=$row['or_de_qty'] * $row['pro_price']?></td>
                                        <td class="pro-subtotal"><?=$formattedDate?></td>
                                    </tr>
                                    <?php endforeach; ?>
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
<?php
    include_once 'footer.php';
?>
