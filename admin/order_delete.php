<?php

session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    
    $order_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM sale_orders WHERE id='$order_id'");
    $stmtDetail = $pdo->prepare("DELETE FROM sale_order_details WHERE sale_order_id='$order_id'");
    
    $result = $stmt->execute() && $stmtDetail->execute();
    if(!empty($result)){
        header("Location: order_list.php");
    }
    