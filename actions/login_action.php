<?php
ob_start();
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
$errors = [];
if (isset($_POST)) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($email)) {
        $errors[] = "Email can't be blank.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email address.";
    }
    if (empty($password)) {
        $errors[] = "Password can't be blank.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('location:' . SITEURL . "login.php");
    }

    // if no errors
    if (!empty($email) && !empty($password)) {
        $conn = db_connect();
        $sanitizeEmail = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM `users` WHERE `email`='{$sanitizeEmail}'";
        $sqlResult = mysqli_query($conn, $sql);
        if (mysqli_num_rows($sqlResult) > 0) {
            $userInfo = mysqli_fetch_assoc($sqlResult);
            if (!empty($userInfo)) {
                $passwordInDb = $userInfo['password'];
                if (password_verify($password, $passwordInDb)) {
                    unset($userInfo['password']);
                    $_SESSION['user'] = $userInfo;
                    $request_url = !empty($_SESSION['request_url']) ? $_SESSION['request_url'] : SITEURL;
                    unset($_SESSION['request_url']);
                    header('location:' . $request_url);
                } else {
                    $errors[] = "Incorrect Password!";
                    $_SESSION['errors'] = $errors;
                    header('location:' . SITEURL . "login.php");
                    exit();
                }
            }
        } else {
            $errors[] = "Email Address doesn't exist!";
            $_SESSION['errors'] = $errors;
            header('location:' . SITEURL . "login.php");
            exit();
        }
    }
}
