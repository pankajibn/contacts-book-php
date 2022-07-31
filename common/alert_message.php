<?php
if (!empty($_SESSION['success'])) {
    ?>
<div class="alert alert-success text-center">
<?php echo $_SESSION['success']; ?>
</div>
<?php
unset($_SESSION['success']);
}
?>
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