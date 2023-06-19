<?php
    include_once 'header.php';
?>

<!-- CSS Start -->
<link rel="stylesheet" href="./assets/css/category.css">
<link rel="stylesheet" href="./assets/css/manage_store.css">
<!--  CSS End -->

<div class="body">
        <h1 style="text-align: center;">Suppliers</h1>
            <div id="main" class="container border">
                <div className="page-heading pb-2 mt-4 mb-2 ">
                
                </div>
<?php
// ADDING
                require_once 'connect.php';
                $conn = new Connect();
                $db_link = $conn->connectToPDO();
                if(isset($_GET['cid'])):
                        $value = $_GET['cid'];
                        $sqlSelect = "SELECT * FROM supplier WHERE sup_id = ?"; //This one
                        $stmt = $db_link->prepare($sqlSelect);
                        $stmt->execute(array("$value"));
                        if($stmt->rowCount()>0):
                                $re = $stmt->fetch(PDO::FETCH_ASSOC);
                                $sup_name = $re['sup_name'];
                                $sup_address = $re['sup_address'];
                        endif;
                endif;

                if(isset($_POST['txtAddress']) && isset($_POST['txtName'])):
                        $cid = $_POST['txtID'];
                        $cname = $_POST['txtName'];
                        $caddress = $_POST['txtAddress'];
                        //Check duplicate value
                        $conn = new Connect();
                        $db_link = $conn->connectToMySQL();
                        $query = "SELECT COUNT(*) as count FROM `supplier` WHERE `sup_id` = '$cid'";
                        $re = $db_link->query($query);
                        $row = $re->fetch_assoc();
                        $count = $row['count'];

                        if(isset($_POST['btnAdd'])):
                            //     $pattern = '/^(C)\d{4}$/';
                            //     $input = $_POST['txtID'];
                            // if (preg_match($pattern, $input)):
                                if ($count > 0) {
                                        // Duplicate data found, handle the error
                                        echo '<script>alert("Error: Duplicate data found!")</script>';
                                }else{
                                $sqlInsert = "INSERT INTO `supplier`(`sup_name`, `sup_address`) VALUES (?,?)";
                                $stmt = $db_link->prepare($sqlInsert);
                                $execute = $stmt->execute(array("$cname","$caddress"));
                                if($execute){
                                        echo '<script>
                                        Swal.fire({
                                          title: "Success!",
                                          text: "Item added successfully!",
                                          icon: "success",
                                          confirmButtonText: "OK"
                                        });
                                      </script>';

                                        header("Location:supplier.php");
                                        exit();
                                }else{
                                        echo "Failed ".$execute;
                                }
                                }
                        //    else:
                        //         echo '<script>alert("Error")</script>';  
                        //    endif;
                        else:
// UPDATING
                                        $sqlUpdate = "UPDATE `supplier` SET `sup_name`=?,`sup_address`=? WHERE `sup_id` = ?";
                                        $stmt = $db_link->prepare($sqlUpdate);
                                        $execute = $stmt->execute(array("$cname","$caddress","$cid"));


                                        if($execute){
                                            echo '<script>
                                            Swal.fire({
                                                icon: "success",
                                                title: "Success",
                                                title: "Update successfully!",
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(() => {
                                                window.location.href = "supplier.php";
                                            });
                                            </script>';
                                        }else{
                                                echo "Failed".$execute;
                                        }
                        endif;
                endif;                
?>

                <form id="form1" name="form1" method="POST" action="" class="form-horizontal" role="form">
                    <div class="form-group pb-3 pt-3">
                        <label for="txtTen" class="col-sm-2 control-label">Supplier Name:  </label>
                            <div class="col-sm-12">
                                <input required type="text" name="txtID" id="txtID" class="form-control" placeholder="Supplier Name" value='<?php echo isset($_GET["cid"])?($_GET["cid"]):"";?>' hidden>
                                <input required type="text" name="txtName" id="txtName" class="form-control" placeholder="Supplier Name" value='<?php echo isset($sup_name)?($sup_name):"";?>'>
                            </div>
                            <h6 style="font-style: italic; color: green; padding: 3px 0 0 10px; font-size: 13px">(*)Enter Supplier Name here</h6>
                    </div>
                    <div class="form-group pb-3">
                            <label for="txtTen" class="col-sm-2 control-label">Supplier Address:  </label>
                            <div class="col-sm-12">
                                <input required type="text" name="txtAddress" id="txtAddress" class="form-control" placeholder="Supplier Address" value='<?php echo isset($sup_address)?($sup_address):"";?>'>
                            </div>
                            <h6 style="font-style: italic; color: green; padding: 3px 0 0 10px; font-size: 13px">(*) Enter Supplier Address here</h6>
                    </div>
                        <style>
                                .select{
                                        padding-right: 20px;
                                }
                        </style>
                    <div class="form-group pb-3">
                        <div class="col-sm-offset-2 col-sm-10">
                                <input style="background-color: #2B3467; border: none" type="submit"  class="btn btn-primary " name="<?php echo isset($_GET["cid"])?"btnEdit":"btnAdd"; ?>" id="btnAction" value='<?php echo isset($_GET["cid"])?"Update":"Add new"?>'/>
                        </div>
                    </div>
                </form>
            </div>
    </div>
    <div class="table-responsive" id="tables">
    <table class="table table-hover" id="myTable">
      <thead>
        <tr>
          <th scope="col">Supplier Id</th>
          <th scope="col">Supplier Name</th>
          <th scope="col">Supplier Address</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
            include_once 'connect.php';
            $conn = new Connect();
            $db_link = $conn->connectToMySQL();
            $sql = "SELECT * FROM supplier";
            $re = $db_link->query($sql);
            while($row = $re->fetch_assoc()):
        ?>
        <tr>
          <td><?=$row['sup_id']?></td>
          <td><?=$row['sup_name']?></td>
          <td><?=$row['sup_address']?></td>
          <td>
            <a href="supplier.php?cid=<?=$row['sup_id']?>" class="button3 update">Update</a>
            <a href="supplier.php?de_id=<?=$row['sup_id']?>" class="button3 delete">Delete</a>
        </td>
        </tr>
        <?php
            endwhile;  
        ?>
      </tbody>
    </table>
</div>
<?php
// DELETING
include_once 'connect.php';
$conn = new Connect();
$db_link = $conn->connectToPDO();

if(isset($_GET['de_id'])):
$value = $_GET['de_id'];
$sqlDelete = "DELETE FROM `supplier` WHERE `sup_id` = ?";
$stmt = $db_link->prepare($sqlDelete);
$stmt->execute(array("$value"));
    if($stmt){
        header("Location: supplier.php");
    }
endif; 
?>

<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

    <!-- JS
============================================ -->

<!-- jQuery JS -->
<script src="./assets/js/pagination.js"></script>
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