<?php

    session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id='$id'");
    $stmt->execute();
    header("Location: user_list.php");