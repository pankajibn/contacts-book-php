<?php
include_once 'common/header.php';
require_once 'includes/db.php';
if (empty($_SESSION['user'])) {
    $currentPage = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $_SESSION['request_url'] = $currentPage;
    header('location:' . SITEURL . "login.php");
    exit();
}

$userId = $_SESSION['user']['id'];
$conn = db_connect();
$sql = "SELECT * FROM `users` WHERE `id`= $userId";
$sqlResult = mysqli_query($conn, $sql);
if (mysqli_num_rows($sqlResult) > 0) {
    $userInfo = mysqli_fetch_assoc($sqlResult);
} else {
    echo "User not found.";
    exit();
}
db_close($conn);
?>
<div class="row justify-content-center wrapper">
<div class="col-md-6">
<?php
include_once 'common/alert_message.php';
?>
<div class="card">
<header class="card-header">
	<h4 class="card-title mt-2">Profile</h4>
</header>
<article class="card-body">
<div class="container" id="profile">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <img src="<?php echo !empty($userInfo['profile_img']) ? SITEURL . "uploads/profilephotos/" . $userInfo['profile_img'] : "https://via.placeholder.com/50.png/09f/666"; ?>" alt="" class="rounded-circle profile_img" />
            </div>
            <div class="col-sm-6 col-md-8">
                <h4 class="text-primary">
                    <?php echo $userInfo['first_name'] . " " . $userInfo['last_name']; ?>
                </h4>
                <p class="text-secondary">
                <i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $userInfo['email']; ?><br />
                </p>
                <!-- Split button -->
            </div>
        </div>

    </div>
</article>

</div>
</div>

</div>
<?php
include_once 'common/footer.php';
?>