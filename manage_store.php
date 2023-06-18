<?php
    include_once 'header.php';
?>

<!-- CSS Start -->
<link rel="stylesheet" href="./assets/css/manage_store.css">
<!--  CSS End -->

<div class="body">
        <h1 style="text-align: center; font-weight: bold">Toy Stores</h1>
            <div id="main" class="container border">
<?php

                require_once 'connect.php';
                $conn = new Connect();
                $db_link = $conn->connectToPDO();
                if(isset($_GET['st_id'])):
                        $value = $_GET['st_id'];
                        $sqlSelect = "SELECT * FROM store WHERE st_id = ?";
                        $stmt = $db_link->prepare($sqlSelect);
                        $stmt->execute(array($value));
                        if($stmt->rowCount()>0):
                                $re = $stmt->fetch(PDO::FETCH_ASSOC);
                                $stID = $re['st_id'];
                                $stName = $re['st_name'];
                                $stAddress = $re['st_address'];
                        endif;
                endif;
// ADDING
                if(isset($_POST['txtAddress']) && isset($_POST['txtName'])){
                        $stID = $_POST['txtID'];
                        $stName = $_POST['txtName'];
                        $stAddress = $_POST['txtAddress'];
                    
                        if(isset($_POST['btnAdd'])){
                            $sqlInsert = "INSERT INTO `store`(`st_name`, `st_address`) VALUES (?,?)";
                            $stmt = $db_link->prepare($sqlInsert);
                            $execute = $stmt->execute(array($stName, $stAddress));
                            if($execute){
                                header("Location: manage_store.php");
                                exit();
                            } else{
                                echo "Failed ".$execute;
                            }
                        } else{
                            $sqlUpdate = "UPDATE `store` SET `st_name`=?, `st_address`=? WHERE `st_id` = ?";
                            $stmt = $db_link->prepare($sqlUpdate);
                            $execute = $stmt->execute(array($stName, $stAddress, $stID));
                            if($execute){
                                header("Location: view_category.php");
                                exit();
                            } else{
                                echo "Failed".$execute;
                            }
                        }
                    } 


?>

                <form id="form1" name="form1" method="POST" action="" class="form-horizontal" role="form">
                    <div class="form-group pb-3 pt-3">
                        <!-- <label for="txtTen" class="col-sm-2 control-label">Store Id:  </label> -->
                            <div class="col-sm-12">
                                <input type="text" name="st_id" id="txtID" class="form-control" placeholder="Store ID" value='<?php echo isset($_GET["st_id"])?($_GET["st_id"]):"";?>' hidden>
                            </div>
                            <!-- <h6 style="font-style: italic; color: green; padding: 3px 0 0 10px; font-size: 13px">(*)Enter your store Id here</h6> -->
                    </div>
                    <div class="form-group pb-3">
                            <label for="txtTen" class="col-sm-2 control-label">Store Name:  </label>
                            <div class="col-sm-12">
                                <input required type="text" name="txtName" id="txtName" class="form-control" placeholder="Store Name" value='<?php echo isset($stName)?($stName):"";?>'>
                            </div>
                            <h6 style="font-style: italic; color: green; padding: 3px 0 0 10px; font-size: 13px">(*) Enter your store name here</h6>
                    </div>
                    <div class="form-group pb-3">
                            <label for="txtTen" class="col-sm-2 control-label">Store Address:  </label>
                            <div class="col-sm-12">
                                <input required type="text" name="txtAddress" id="txtAddress" class="form-control" placeholder="Store Address" value='<?php echo isset($stAddress)?($stAddress):"";?>'>
                            </div>
                            <h6 style="font-style: italic; color: green; padding: 3px 0 0 10px; font-size: 13px">(*) Enter your store address here</h6>
                    </div>
                    <div class="form-group pb-3">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input style="background-color: #2B3467; border: none" type="submit" class="btn btn-primary" name="<?php echo isset($_GET["st_id"]) ? "btnEdit" : "btnAdd"; ?>" id="btnAction" value="<?php echo isset($_GET["st_id"]) ? "Update" : "Add new"; ?>" />
                        </div>
                    </div>
                </form>
            </div>
    </div>

    <div class="table-responsive" id="tables">
            <table class="table table-hover" id="myTable">
                <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Store Name</th>
                            <th scope="col">Store Address</th>
                            <th scope="col">Action</th>
                        </tr>
                </thead>
                <tbody>
                    <?php
                        include_once 'connect.php';
                        $conn = new Connect();
                        $db_link = $conn->connectToMySQL();
                        $sql = "SELECT * FROM `store` ORDER BY `st_id` ASC";
                        $re = $db_link->query($sql);
                        while($row = $re->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?=$row['st_id']?></td>
                        <td><?=$row['st_name']?></td>
                        <td><?=$row['st_address']?></td>
                        <td>
                        <a>
                            <div class="button" onclick="removeStore('<?=$row['st_id']?>')">Delete</div>
                        </a>
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
require_once 'connect.php';
if(isset($_GET['del_id'])){
    $pro_del = $_GET['del_id'];
    $query = "DELETE FROM `store` WHERE `st_id` = ?";
    $stmt = $db_link->prepare($query);
    $stmt->bind_param('s', $pro_del);
    $stmt->execute();
    if($stmt){
        header("Location:manage_store.php");
    }
}
?>
<script>
function removeStore(id2){
  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.isConfirmed) {
Swal.fire({
title: 'Deleted',
text: 'The item has been deleted.',
icon: 'success',
showConfirmButton: false
})
setTimeout(() => {
window.location.href = 'manage_store.php?del_id=' + id2;
}, 2000); 

} else if (result.isDenied) {
Swal.fire('Changes are not saved', '', 'info')
}
})
}
</script>

    <!-- JS
============================================ -->
<script src="../js/alert.js"></script>
<script src="../js/pagination.js"></script>
<script src="sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery JS -->
<script src="../js/vendor/jquery-3.6.0.min.js"></script>
<!-- Migrate JS -->
<script src="../js/vendor/jquery-migrate-3.3.2.min.js"></script>
<!-- Bootstrap JS -->
<script src="../js/bootstrap.bundle.min.js"></script>
<!-- Plugins JS -->
<script src="../js/plugins.js"></script>
<!-- Main JS -->
<script src="../js/main.js"></script>


<?php
    include_once 'footer.php';
?>