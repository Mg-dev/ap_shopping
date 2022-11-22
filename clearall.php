<?php
    session_start();
    unset($_SESSION['cart']);
    header('Location: ap_shopping_home.php');