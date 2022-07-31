<?php
include_once 'common/header.php';
require_once 'includes/db.php';
if (empty($_SESSION['user'])) {
    $currentPage = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $_SESSION['request_url'] = $currentPage;
    header('location:' . SITEURL . "login.php");
    exit();
}
$userId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;
$contactId = !empty($_GET['id']) ? $_GET['id'] : '';
if (!empty($contactId) && is_numeric($contactId)) {
    $conn = db_connect();
    $contact_Id = mysqli_real_escape_string($conn, $contactId);
    $sql = "SELECT * FROM `contacts` WHERE `id`={$contact_Id} AND `owner_id`={$userId}";
    $sqlResult = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($sqlResult);
    if ($rows > 0) {
        $contact = mysqli_fetch_assoc($sqlResult);
    } else {
        $error_msg = "Record doesn't exist.";
    }
    db_close($conn);
}

$first_name = (!empty($contact) && !empty($contact['first_name'])) ? $contact['first_name'] : '';
$last_name = (!empty($contact) && !empty($contact['last_name'])) ? $contact['last_name'] : '';
$email = (!empty($contact) && !empty($contact['email'])) ? $contact['email'] : '';
$phone = (!empty($contact) && !empty($contact['phone'])) ? $contact['phone'] : '';
$address = (!empty($contact) && !empty($contact['address'])) ? $contact['address'] : '';

?>
<div class="row justify-content-center wrapper">
<div class="col-md-6">
<?php
if (!empty($_SESSION['errors'])) {
    ?>
<div class="alert alert-danger">
<p>There were following error(s) found:</p>
<ul>
    <?php
foreach ($_SESSION['errors'] as $error) {
        print '<li>' . $error . '</li>';
    }
    ?>
</ul>
</div>
<?php
unset($_SESSION['errors']);
}
?>
<div class="card">
<header class="card-header">
	<h4 class="card-title mt-2">Add/Edit Contact</h4>
</header>
<article class="card-body">
<form method="POST" action="<?php echo SITEURL . "actions/addcontact_action.php"; ?>" enctype="multipart/form-data">
	<div class="form-row">
		<div class="col form-group">
			<label>First Name </label>
		  	<input type="text" name="fname" value="<?php echo $first_name; ?>" class="form-control" placeholder="First Name">
		</div>
		<div class="col form-group">
			<label>Last Name</label>
		  	<input type="text" name="lname" value="<?php echo $last_name; ?>" class="form-control" placeholder="Last Name">
		</div>
	</div>
	<div class="form-group">
		<label>Email Address</label>
		<input type="email" name="email" value="<?php echo $email; ?>" class="form-control" placeholder="Email">
	</div>
	<div class="form-group">
		<label>Phone No.</label>
		<input type="text" name="phone" value="<?php echo $phone; ?>"  class="form-control" placeholder="Contact">
	</div>
	<div class="form-group">
		<label>Address</label>
		<input type="text" name="address" value="<?php echo $address; ?>" class="form-control" placeholder="Address">
	</div>
	<div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="photo">Photo</span>
        </div>
    <div class="custom-file">
        <input type="file" name="photo" class="custom-file-input" id="contact_photo">
        <label class="custom-file-label" for="contact_photo">Choose file</label>
    </div>
	</div>
    <div class="form-group">
        <input type="hidden" name="cid" value="<?php echo $contactId; ?>" />
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </div>
</form>
</article>
</div>
</div>

</div>
<?php
include_once 'common/footer.php';
?>