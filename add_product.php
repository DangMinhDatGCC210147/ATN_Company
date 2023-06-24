<?php
    include_once 'header.php';
?>
<!-- CSS Start -->
<link rel="stylesheet" href="./assets/css/add_products.css">
<!-- CSS End -->


<!-- Content Start -->
<?php
// ADDING
        require_once 'connect.php';
        $conn = new Connect();
        $db_link = $conn->connectToPDO();

        if(isset($_POST['pro_name']) && isset($_POST['pro_price'])):
                $pro_id = $_POST['pro_id'];
                $pro_name = $_POST['pro_name'];
                $pro_price = $_POST['pro_price'];
                $pro_des = $_POST['pro_des'];
                $pro_qty = $_POST['pro_qty'];
                $imgs = str_replace(' ', '_', $_FILES['pro_image']['name']);
                $storedImage = "./assets/images/product/";
                $pro_date = $_POST['pro_date'];
                $pro_cate_id = $_POST['pro_cate_id'];
                $pro_st_id = $_POST['pro_st_id'];
                $sup_id = $_POST['sup_id'];
                $flag = move_uploaded_file($_FILES['pro_image']['tmp_name'], $storedImage.$imgs);

                if(isset($_POST['btnSubmit'])):
                    $sqlInsert = "INSERT INTO `products`(`pro_id`, `pro_name`, `pro_price`, `pro_des`, `pro_qty`, `pro_image`, `pro_date`, `pro_cate_id`, `pro_st_id`, `sup_id`) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $db_link->prepare($sqlInsert);
                    $execute = $stmt->execute(array("$pro_id","$pro_name", "$pro_price", "$pro_des","$pro_qty","$imgs","$pro_date","$pro_cate_id","$pro_st_id","$sup_id"));
                    if($execute){
                        echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            title: "Item added to cart successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "add_product.php";
                        });
                        </script>';
                            // header("Location: add_product.php");
                    }else{
                        echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Item has not added!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>';
                    }
                endif;
        endif;
?>
<!-- PHP -->
        <div class="title1"><h2 style="font-weight: bold;" value=''>Add Products</h2></div>
        <!-- Form template-->
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <div class="formbold-form-wrapper">
            <div class="formbold-input-flex">
                    <div>
                        <label for="" class="formbold-form-label"> Product ID: </label>
                        <input value="" type="text" name="pro_id" id="" class="formbold-form-input"  required/>
                    </div>
                    <div>
                        <label for="" class="formbold-form-label"> Product Name: </label>
                        <input value="" type="text" name="pro_name" id="" class="formbold-form-input"  required/>
                    </div>
                </div>
                <div class="formbold-input-flex">
                    <div>
                        <label for="" class="formbold-form-label"> Price: </label>
                        <input type="number" min="0" value="0" step="any" name="pro_price" id="" class="formbold-form-input"  required/>
                    </div>
                    <div>
                        <label for="" class="formbold-form-label"> Quantity: </label>
                        <input type="number" min="0" value="0" step="1" name="pro_qty" id="" class="formbold-form-input" required/>
                    </div>
                </div>
                <div class="formbold-input-flex category">
                    <div>
                        <label for="" class="custom-select formbold-form-label"> Category: </label>
                        <select name="pro_cate_id" class="form-select" required>
                            <option value="" selected disabled>Select category:</option>
                            <?php
                                include_once 'connect.php';
                                $conn = new Connect();
                                $db_link = $conn->connectToMySQL();
                                $sql = "SELECT * FROM category";
                                $re = $db_link->query($sql);
                                while($row = $re->fetch_assoc()):
                            ?>
                            <option value="<?=$row['cate_id']?>"><?=$row['cate_name']?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="" class="formbold-form-label"> Date: </label>
                        <input value="" type="date" name="pro_date" id="pro_date" class="formbold-form-input" required/>
                    </div>
                </div>
                <div class="formbold-input-flex">
                    <div>
                        <label for="" class="formbold-form-label"> Description: </label>
                        <!-- <input value="" type="text" name="pro_des" id="" class="formbold-form-input" required/> -->
                        <textarea name="pro_des" id="" cols="30" rows="1" class="formbold-form-input" required></textarea>
                    </div>
                </div>
                <div class="formbold-input-flex">
                    <div>
                        <label for="" class="formbold-form-label"> Store Name: </label>
                        <select name="pro_st_id" class="form-select" required>
                            <option value="" selected disabled>Select store name</option>
                            <?php
                                include_once 'connect.php';
                                $conn = new Connect();
                                $db_link = $conn->connectToMySQL();
                                $sql = "SELECT * FROM store";
                                $re = $db_link->query($sql);
                                while($row = $re->fetch_assoc()):
                            ?>
                            <option value="<?=$row['st_id']?>"><?=$row['st_name']?> - <?=$row['st_address']?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="" class="formbold-form-label"> Supplier Name: </label>
                        <select name="sup_id" class="form-select" required>
                            <option value="" selected disabled>Select supplier name</option>
                            <?php
                                include_once 'connect.php';
                                $conn2 = new Connect();
                                $db_link2 = $conn2->connectToMySQL();
                                $sql2 = "SELECT * FROM supplier";
                                $re2 = $db_link2->query($sql2);
                                while($row = $re2->fetch_assoc()):
                            ?>
                            <option value="<?=$row['sup_id']?>"><?=$row['sup_id']?> - <?=$row['sup_name']?> - <?=$row['sup_address']?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="formbold-input-flex">
                    
                </div> -->
                <!-- <div class="formbold-input-flex"> -->
                    <div class="photo">
                        <label class="formbold-form-label"  for="image-vertical">Image: </label>
                        <input required type="file" name="pro_image" id="pro_image" class="form-control" value="<?php echo isset($imgs)?($imgs):"";?>">
                    </div>
                <!-- </div> -->
                <input type="submit" name="btnSubmit" id="btnSubmit" class="formbold-btn" style="font-size: 20px; background-color:#2B3467" value='Submit'></input>
            </div>
        </form>
    <!--  -->
    
    <!-- Show list -->
    <div class="title2">
        <h2 style="font-weight: bold;">LIST OF THE WORK</h2>
    </div>
    
    <div class="fex" style="display:block !important">

        <div class="table-responsive" id="tables">
            <table class="table table-hover" id="myTable">
                <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date</th>
                            <th scope="col">Category</th>
                            <th scope="col">Store</th>
                            <th scope="col">Action</th>
                        </tr>
                </thead>
                <tbody>
                    <?php
                        include_once 'connect.php';
                        $conn = new Connect();
                        $db_link = $conn->connectToMySQL();
                        $sql = "SELECT * FROM `products` pr JOIN category ca JOIN store st ON ca.cate_id = pr.pro_cate_id AND pr.pro_st_id = st.st_id ORDER BY  pr.pro_id ASC";
                        $re = $db_link->query($sql);
                        while($row = $re->fetch_assoc()):
                            $newDate = date("M d, Y",strtotime($row['pro_date']));
                            $pro_qty = $row['pro_qty'];
                            if ($pro_qty > 3) {
                                $stockStatus = "In Stock";
                            } else {
                                $stockStatus = "Out of Stock";
                            }  
                    ?>
                    <tr>
                        <td><?=$row['pro_id']?></td>
                        <td><?=$row['pro_name']?></td>
                        <td><?=$stockStatus?></td>
                        <td><?=$row['pro_price']?></td>
                        <td><?=$row['pro_qty']?></td>
                        <td><?=$newDate?></td>
                        <td><?=$row['cate_name']?></td>
                        <td><?=$row['st_name']?></td>
                        <td>
                        <a>
                            <div class="button" onclick="deleteProduct('<?=$row['pro_id']?>')">Delete</div>
                        </a>
                        </td>
                    </tr>
                    <?php
                        endwhile;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
// DELETING
require_once 'connect.php';
if(isset($_GET['del_id'])){
    $pro_del = $_GET['del_id'];
    $query = "DELETE FROM `products` WHERE `pro_id` = ?";
    $stmt = $db_link->prepare($query);
    $stmt->bind_param('s', $pro_del);
    $stmt->execute();
    if($stmt){
        header("Location:add_product.php");
    }
}
?>

<!-- ================================================== -->
<script src="./assets/js/alert.js"></script>
<script src="./assets/js/pagination.js"></script>
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
