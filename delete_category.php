<?php
    include_once 'connect.php';
    $conn = new Connect();
    $db_link = $conn->connectToPDO();
    
if(isset($_GET['cid'])):
    $value = $_GET['cid'];
    $sqlDelete = "DELETE FROM `category` WHERE `cate_id` = ?";
    $stmt = $db_link->prepare($sqlDelete);
    $stmt->execute(array("$value"));
    header("Location: view_category.php");
endif; 
?>