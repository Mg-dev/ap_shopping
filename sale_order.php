
<?php include('header.php') ?>
<?php
if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
	header('Location: index.php');
  }
if($_SESSION['cart']){
	if(!empty($_SESSION['user_id'])){
        $userId = $_SESSION['user_id'];
        $total = 0;
        date_default_timezone_set('Asia/Yangon');
        $date = date('m/d/Y h:i:s a', time());
        foreach ($_SESSION['cart'] as $key => $qty) {
            $id = str_replace('id','',$key);
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id='$id'");
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            $total += $product['price']*$qty;   
        }
        $stmt = $pdo->prepare("INSERT INTO sale_orders(user_id,total_price,order_date) VALUES (:user_id,:total_price,:order_date)");
        $result = $stmt->execute(
            array(':user_id'=>$userId,':total_price'=>$total,':order_date'=>date('Y-m-d H:i:s'))
        );
        // print_r($result);
        // exit();
        if($result){
            $saleOrderId = $pdo->lastInsertId();
            foreach ($_SESSION['cart'] as $key => $qty) {
                $pid = str_replace('id','',$key);
                $stmt = $pdo->prepare("INSERT INTO sale_order_details(sale_order_id,product_id,quantity) VALUES (:soid,:pid,:qty)");
                $result = $stmt->execute(
                array(":soid"=>$saleOrderId,":pid"=>$pid,":qty"=>$qty)
            );
			$qtyStmt = $pdo->prepare("SELECT * FROM products WHERE id='$pid'");
			$qtyStmt->execute();
			$qResult = $qtyStmt->fetch(PDO::FETCH_ASSOC);
			
			$updatedQty = $qResult['quantity']-$qty;
			$updatedStmt = $pdo->prepare("UPDATE products SET quantity=:qty where id='$pid'");
			$result = $updatedStmt->execute(array(':qty'=>$updatedQty));
            }
            unset($_SESSION['cart']);
        }
    }
}
    
    
                                        
                                    
?>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	
	<!-- End Banner Area -->

	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
			<!-- <div class="row order_d_inner">
				<div class="col-lg-6">
					<div class="details_item">
						<h4>Order Info</h4>
						<ul class="list">
							<li><a href="#"><span>Order number</span> : 60235</a></li>
							<li><a href="#"><span>Date</span> : Los Angeles</a></li>
							<li><a href="#"><span>Total</span> : USD 2210</a></li>
							<li><a href="#"><span>Payment method</span> : Check payments</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="details_item">
						<h4>Shipping Address</h4>
						<ul class="list">
							<li><a href="#"><span>Street</span> : 56/8</a></li>
							<li><a href="#"><span>City</span> : Los Angeles</a></li>
							<li><a href="#"><span>Country</span> : United States</a></li>
							<li><a href="#"><span>Postcode </span> : 36952</a></li>
						</ul>
					</div>
				</div>
			</div> -->
		</div>
	</section>
	<!--================End Order Details Area =================-->

	
	<?php include('footer.php'); ?>