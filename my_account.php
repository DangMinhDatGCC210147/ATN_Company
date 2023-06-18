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

    $sqlSelect = "SELECT * FROM users WHERE `u_id` = ?";
    $stmt1 = $dblink->prepare($sqlSelect);
    $stmt1->execute([$user_id]);
    $rows = $stmt1->fetchAll(PDO::FETCH_BOTH);
?>
<!-- Page Section Start -->
<div class="page-section section section-padding">
        <div class="container">
			<div class="row mbn-30">

				<!-- My Account Tab Menu Start -->
				<div class="col-lg-3 col-12 mb-30">
					<div class="myaccount-tab-menu nav" role="tablist">
						<a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
							Dashboard</a>

						<a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a>

						<a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account Details</a>

						<a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
					</div>
				</div>
				<!-- My Account Tab Menu End -->

				<!-- My Account Tab Content Start -->
				<div class="col-lg-9 col-12 mb-30">
					<div class="tab-content" id="myaccountContent">
						<!-- Single Tab Content Start -->
						<div class="tab-pane fade show active" id="dashboad" role="tabpanel">
							<div class="myaccount-content">
								<h3>Dashboard</h3>

								<div class="welcome">
									<p>Hello, <strong><?=$rows[0]['u_lastName']?> <?=$rows[0]['u_firstName']?></strong> (If Not <strong><?=$_SESSION['user_name']?> ! </strong><a href="../php/logout.php" class="logout"> Logout</a>)</p>
								</div>

								<p class="mb-0">From your account dashboard. you can easily check &amp; view your
									recent orders, manage your shipping and billing addresses and edit your
									password and account details.</p>
							</div>
						</div>
						<!-- Single Tab Content End -->


						<!-- Single Tab Content Start -->
						<div class="tab-pane fade" id="address-edit" role="tabpanel">
							<div class="myaccount-content">
								<h3>Billing Address</h3>

								<address>
									<p><strong><?=$rows[0]['u_lastName']?> <?=$rows[0]['u_firstName']?></strong></p>
									<p><?=$rows[0]['u_address']?> <br>
									</p>
									<p><?=$rows[0]['u_phone']?></p>
								</address>

								<!-- <a href="#" class="btn btn-dark btn-round d-inline-block"><i class="fa fa-edit"></i>Edit Address</a> -->
							</div>
						</div>
						<!-- Single Tab Content End -->

						<!-- Single Tab Content Start -->
						<div class="tab-pane fade" id="account-info" role="tabpanel">
							<div class="myaccount-content">
								<h3>Account Details</h3>

								<div class="account-details-form">
										<div class="row">
											<div class="col-lg-6 col-12 mb-30">
												<input id="first-name" placeholder="First Name" type="text" value="<?=$rows[0]['u_firstName']?>">
											</div>

											<div class="col-lg-6 col-12 mb-30">
												<input id="last-name" placeholder="Last Name" type="text" value="<?=$rows[0]['u_lastName']?>">
											</div>

											<div class="col-12 mb-30">
												<input id="display-name" placeholder="Display Name" type="text" value="<?=$rows[0]['u_lastName']?> <?=$rows[0]['u_firstName']?>">
											</div>

											<div class="col-12 mb-30">
												<input id="email" placeholder="Email Address" type="email" value="<?=$rows[0]['u_email']?>">
											</div>
<!-- CHANGE PASSWORD -->
									<!-- Account details form fields... -->
                                    <div class="col-12 mb-30"><h4>Password change</h4></div>
								<form action="#" method="post">
                                    <div class="col-12 mb-30">
                                        <input name="current-pwd" placeholder="Current Password" type="password">
                                    </div>
                                    <div class="col-lg-6 col-12 mb-30">
                                        <input name="new-pwd" placeholder="New Password" type="password">
                                    </div>
                                    <div class="col-lg-6 col-12 mb-30">
                                        <input name="confirm-pwd" placeholder="Confirm Password" type="password">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-dark btn-round btn-lg">Save Changes</button>
                                    </div>
                                </form>

								</div>
							</div>
						</div>
						<!-- Single Tab Content End -->
					</div>
				</div>
				<!-- My Account Tab Content End -->
				
			</div>
        </div>
    </div><!-- Page Section End -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $currentPwd = $_POST["current-pwd"];
        $newPwd = $_POST["new-pwd"];
        $confirmPwd = $_POST["confirm-pwd"];
		$oldPassword = $rows[0]['u_password'];
        // Perform validation checks
        if ($currentPwd != $oldPassword){
			echo '<script>
			Swal.fire({
				icon: "error",
				title: "Oops...",
				text: "Current password is not true."
			}).then(() => {
				window.location.href = "my_account.php";
			});
		</script>';
		}elseif ($newPwd !== $confirmPwd) {
			echo '<script>
			Swal.fire({
				icon: "error",
				title: "Oops...",
				text: "New password and confirmation password do not match."
			}).then(() => {
				window.location.href = "my_account.php";
			});
		</script>';
            exit;
        }else{
			// Prepare the update statement
        $query = "UPDATE `users` SET `u_password`= ?  WHERE `u_id`= ?";
        $stmt = $dblink->prepare($query);
        $stmt->execute([$newPwd, $user_id]);
		

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
			echo '<script>
			Swal.fire({
				icon: "success",
				title: "Success",
				title: "Change Password successfully!",
				showConfirmButton: false,
				timer: 1500
			  }).then(() => {
				window.location.href = "my_account.php";
			});
			</script>';
        }
	}
    }
}
?>
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