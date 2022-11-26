<?php
session_start();
require('./config/config.php');
if(!empty($_POST)){
    $id = $_POST['id'];
    $qty = $_POST['qty'];  
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id='$id'");
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
if($product['quantity'] < $qty ){
   echo "<script>alert('Out of Stock');window.location.href='home.php';</script>";
}else{
    if(isset($_SESSION['cart']['id'.$id])){
        $_SESSION['cart']['id'.$id] += $qty;
        if($_SESSION['cart']['id'.$id] >= $product['quantity']){
            echo "<script>alert('Out of Stock');window.location.href='home.php';</script>";
        }
    }else{
        $_SESSION['cart']['id'.$id] = $qty;
    }
    header("Location: cart.php");
}
}
?>