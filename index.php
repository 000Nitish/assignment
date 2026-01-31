<?php
 //Home page - redirect to login or dashboard
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: crud/index.php');
} else {
    header('Location: auth/login.php');
}
exit();
?>
