<?php
ob_start();
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
$errors = [];

if (isset($_POST)) {
    $old_password = trim($_POST['old_password']);
    $password = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    // validations
    if (empty($old_password)) {
        $errors[] = "Old Password can't be blank.";
    }
    if (empty($password)) {
        $errors[] = "New Password can't be blank.";
    }
    if (empty($confirmPassword)) {
        $errors[] = "Confirm Password can't be blank.";
    }

    if (!empty($password) && !empty($confirmPassword) && $password != $confirmPassword) {
        $errors[] = "Confirm password doesn't match.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('location:' . SITEURL . "change_password.php");
        exit();
    }

    $userId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;
    $conn = db_connect();
    $sql = "SELECT * FROM `users` WHERE `id`= $userId";
    $sqlResult = mysqli_query($conn, $sql);
    if (mysqli_num_rows($sqlResult) > 0) {
        $userInfo = mysqli_fetch_assoc($sqlResult);
        $passwordInDb = $userInfo['password'];
        if (password_verify($old_password, $passwordInDb)) {
            $newPassworHash = password_hash($password, PASSWORD_DEFAULT);
            $update_pass_sql = "UPDATE `users` SET password='{$newPassworHash}' WHERE id={$userId}";
            if (mysqli_query($conn, $update_pass_sql)) {
                $_SESSION['success'] = "Password has been changed successfully!.";
                db_close($conn);
                header('location:' . SITEURL . "change_password.php");
            }

        } else {
            $errors[] = "Old password is incorrect";
            $_SESSION['errors'] = $errors;
            header('location:' . SITEURL . "change_password.php");
            exit();
        }
    }
}
