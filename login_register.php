<?php
    include_once 'header.php';    
?>
<!-- Login -->
<!-- <link rel="stylesheet" href="../css/my.css"> -->
<?php
    require_once 'connect.php';

function login($email, $password){
    $c = new Connect();
    $dblink = $c->connectToPDO();
    
    $sql = "SELECT * FROM users WHERE u_email = ? and u_password = ?";
    $stmt = $dblink->prepare($sql);
    $re = $stmt->execute(array("$email","$password"));
    $numrow = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_BOTH);
    if ($numrow == 1) {
        $_SESSION['user_id'] = $row['u_id'];
        $_SESSION['user_name'] = $row['u_firstName'];
        $_SESSION['user_role'] = $row['u_role'];
        $_SESSION['user_lastName'] = $row['u_lastName'];
        // Verify password
            if ($row['u_role'] == 0) {
                // Admin login
                $_SESSION['user_role'] = 'admin';
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        title: "Login successfully!",
                        text: "Hello admin",
                        showConfirmButton: false,
                        timer: 1500
                      }).then(() => {
                        window.location.href = "index.php";
                    });
                    </script>';
            } elseif ($row['u_role'] == 1) {
                // Manager login
                $_SESSION['user_role'] = 'manager';
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        title: "Login successfully!",
                        text: "Hello manager",
                        showConfirmButton: false,
                        timer: 1500
                      }).then(() => {
                        window.location.href = "index.php";
                    });
                    </script>';
            } elseif ($row['u_role'] == 2) {
                // User login
                $_SESSION['user_role'] = 'user';
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        title: "Login successfully!",
                        showConfirmButton: false,
                        timer: 1500
                      }).then(() => {
                        window.location.href = "index.php";
                    });
                    </script>';
            } 
            exit();
    } else {
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Wrong password. Please enter again",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
    }
}

if (isset($_POST['btnLogin'])) {
    if (isset($_POST['txtEmail']) && isset($_POST['txtPass'])) {
        $email = $_POST['txtEmail'];
        $password = $_POST['txtPass'];
        
        login($email, $password);
    }
}
?>
<!-- End Login -->

<!-- Register-->
<?php

if (isset($_POST['btnRegister'])) {
    if(isset($_POST['btnRegister'])){
        $pwd2 = $_POST['txtPass2'];
        $re_pwd = $_POST['txtConfirmPass'];
        $fname = $_POST['txtFirstName'];
        $lname = $_POST['txtLastName'];
        $email2 = $_POST['txtEmail2'];
        $phone = $_POST['txtPhone'];
        $add = $_POST['txtAddress'];
        $dateBirthday = date('Y-m-d', strtotime($_POST['txtDate']));
        
    $username = isset($_POST['txtEmail2']) ? trim($_POST['txtEmail2']) : '';
    $password = isset($_POST['txtPass']) ? trim($_POST['txtPass']) : '';
    $passConfirm = isset($_POST['txtPassConfirm']) ? trim($_POST['txtPassConfirm']) : '';

    if ($pwd2 != $re_pwd) {
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "The password and confirm password are not match!",
            showConfirmButton: false,
            timer: 1500
        });
        </script>';
    } elseif (strlen($pwd2) < 5) {
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Your password must be greater than 5",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
    } elseif (strlen($fname) >= 30) {
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Your First Name must be less than 30.",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
    }elseif ($pwd2 == $re_pwd){
        $c = new Connect();
        $dblink2 = $c->connectToPDO();
        $sql = "INSERT INTO `users`(`u_email`, `u_firstName`, `u_lastName`, `u_address`, `u_password`, `u_role`, `u_phone`, `u_birthday`) VALUES (?,?,?,?,?,?,?,?)";
        $re2 = $dblink2->prepare($sql);
        $stmt2 = $re2->execute(array("$email2", "$fname", $lname, "$add", "$pwd2", 2, "$phone", "$dateBirthday"));
        if ($stmt2) {
            header("Location: login_register.php");
        }
    }else{
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Registration failed.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>'. $stmt2;
    }
}
}

?>
<!-- End Register -->
    <!-- Page Section Start -->
    <div class="page-section section section-padding">
        <div class="container">
            <div class="row mbn-40">

                <div class="col-lg-4 col-12 mb-40">
                    <div class="login-register-form-wrap">
                        <h3>Login</h3>
                        <form method="POST" class="mb-30">
                            <div class="row">
                                <div class="col-12 mb-15"><input name="txtEmail" type="text" placeholder="Email"></div>
                                <div class="col-12 mb-15"><input name="txtPass" type="password" placeholder="Password"></div>
                                <div class="col-12"><input type="submit" name="btnLogin" value="Login"></div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-2 col-12 mb-40 text-center d-none d-lg-block">
                    <span class="login-register-separator"></span>
                </div>

                <div class="col-lg-6 col-12 mb-40 ms-auto">
                    <div class="login-register-form-wrap">
                        <h3>Register</h3>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-15"><input name="txtFirstName" type="text" placeholder="Your First Name" required></div>
                                <div class="col-md-6 col-12 mb-15"><input name="txtLastName" type="text" placeholder="Your Last Name" required></div>
                                <div class="col-md-6 col-12 mb-15"><input name="txtEmail2" type="email" placeholder="Your Email"required></div>
                                <div class="col-md-6 col-12 mb-15"><input name="txtAddress" type="text" placeholder="Your Address" required></div>
                                <div class="col-md-6 col-12 mb-15"><input name="txtPhone" type="text" placeholder="Your Phone Number" required></div>
                                <div class="col-md-6 col-12 mb-15"><input name="txtDate" type="date" placeholder="Your Date of Birth" required></div>
                                <div class="col-md-6 col-12 mb-15"><input name="txtPass2" type="password" placeholder="Password" required></div>
                                <div class="col-md-6 col-12 mb-15"><input name="txtConfirmPass" type="password" placeholder="Confirm Password" required></div>
                                <div class="col-md-6 col-12"><input type="submit" name="btnRegister" value="Register"></div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div><!-- Page Section End -->

    <!-- Brand Section Start -->
    <div class="brand-section section section-padding pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="brand-slider">

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-1.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-2.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-3.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-4.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-5.png" alt="">
                    </div>

                    <div class="brand-item col">
                        <img src="./assets/images/brands/brand-6.png" alt="">
                    </div>

                </div>
            </div>
        </div>
    </div><!-- Brand Section End -->

<!-- JS
============================================ -->
<!-- <script src="../js/my.js"></script> -->
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