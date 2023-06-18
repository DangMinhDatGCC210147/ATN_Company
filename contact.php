<?php
    include_once 'header.php';
?>

<!-- Page Section Start -->
    <div class="page-section section section-padding">
        <div class="container">
            <div class="row row-30 mbn-40">

               <div class="contact-info-wrap col-md-6 col-12 mb-40">
                   <h3>Get in Touch</h3>
                   <p style="text-align: justify;">Welcome to ATN Toys, your premier destination for all things fun and imaginative! As a leading toy company with a wide network of stores across the country, we pride ourselves on bringing joy to children and families everywhere. With our extensive range of high-quality toys, we strive to create magical moments, inspire creativity, and foster learning through play. Join us as we take you on a journey through our world of toys, where imagination knows no bounds.</p>
                   <p style="text-align: justify;">At ATN Toys, we understand the importance of play in a child's development. That's why we curate a diverse selection of toys that cater to children of all ages and interests. From classic board games and puzzles to cutting-edge tech toys and educational resources, our stores offer a comprehensive range of options to ignite curiosity, spark imagination, and promote healthy development in children.</p>
                   <ul class="contact-info">
                       <li>
                           <?php
                                include_once 'connect.php';
                                $c = new Connect();
                                $dblink = $c->connectToPDO();
                                if (isset($_SESSION['user_id'])) {
                                    $sql = "SELECT * FROM `store`";
                                    $re = $dblink->prepare($sql);
                                    $re->execute(); // Execute the prepared statement
                                    $rows = $re->fetchAll(PDO::FETCH_BOTH);
                                    foreach($rows as $row):
                            ?>
                           <p>
                           <i class="fa fa-map-marker"></i>
                            <?=$row['st_id']?>: <?=$row['st_address']?><br>
                            </p>
                            <?php
                                endforeach;
                            }else{
                                header('Location: login_register.php');
                            }
                            ?>
                       </li>
                       <li>
                           <i class="fa fa-phone"></i>
                           <p><a href="#">0907 294 396</a></p>
                       </li>
                       <li>
                           <i class="fa fa-globe"></i>
                           <p><a href="#">info@example.com</a><a href="#">www.example.com</a></p>
                       </li>
                   </ul>
               </div>

               <div class="contact-form-wrap col-md-6 col-12 mb-40">
                   <h3>Leave a Message</h3>
                   <img src="./assets/images/Poster.jpg" alt="" style="width: 100%; border: 2px solid black; border-radius: 10px; padding: 10px;">
                   <!-- <div class="form-message mt-3"></div> -->
               </div>

            </div>
        </div>
    </div><!-- Page Section End -->

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