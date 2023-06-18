<?php
    include_once 'header.php';
?>
<!-- CSS Start -->
<link rel="stylesheet" href="./assets/css/category.css">
<!-- CSS End -->


<a href="add_category.php" class="button2 adding">Add category</a>
<div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Category Id</th>
          <th scope="col">Category</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
            include_once 'connect.php';
            $conn = new Connect();
            $db_link = $conn->connectToMySQL();
            $sql = "SELECT * FROM category ORDER BY `cate_id` ASC";
            $re = $db_link->query($sql);
            while($row = $re->fetch_assoc()):
        ?>
        <tr>
          <td><?=$row['cate_id']?></td>
          <td><?=$row['cate_name']?></td>
          <td>
            <a href="add_category.php?cid=<?=$row['cate_id']?>" class="button3 update">Update</a>
            <a href="delete_category.php?cid=<?=$row['cate_id']?>" class="button3 delete">Delete</a>
        </td>
        </tr>
        <?php
            endwhile;  
        ?>
      </tbody>
    </table>
</div>
<!-- JS
============================================ -->

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
