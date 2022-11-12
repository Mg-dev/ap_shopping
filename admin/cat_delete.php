<?php

session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    
    $cat_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id='$cat_id'");
    $stmt->execute();
    echo "<script>alert('Deleted Successfully!');;window.location.href = 'categories.php'</script>";