<?php
if(!empty($_POST['search'])){
	setcookie('search',$_POST['search'], time() + (86400*30) , '/');
  }else{
	if(empty($_GET['pageno'])){
	  unset($_COOKIE['search']);
	  setcookie('search',null,-1 , '/');
	}
  }
?>
<?php include('header.php') ?>
  
<?php
				if(!empty($_GET['pageno'])){
					$pageno = $_GET['pageno'];
				  }else{
					$pageno = 1;
				  }
				  $numOfrecs = 6;
				  $offset = ($pageno - 1) * $numOfrecs;
				  
				if(empty($_POST['search']) && empty($_COOKIE['search'])){
					if(!empty($_GET['id'])){
						$id = $_GET['id'];
						$stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE category_id=$id AND quantity>0");
						$stmt->execute();
						$rawResult = $stmt->fetchAll();
						$totalpages = ceil(count($rawResult)/ $numOfrecs);
						$stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE category_id=$id AND quantity>0 LIMIT $offset,$numOfrecs");
						$stmt->execute();
						$products = $stmt->fetchAll();	
					}else{
						$stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE  quantity>0");
						$stmt->execute();
						$rawResult = $stmt->fetchAll();
						$totalpages = ceil(count($rawResult)/ $numOfrecs);
						$stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id  WHERE  quantity>0 LIMIT $offset,$numOfrecs");
						$stmt->execute();
						$products = $stmt->fetchAll();
					}
				}else{
					$searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
					$stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE products.name LIKE '%$searchKey%' WHERE quantity>0");
					$stmt->execute();
					$rawResult = $stmt->fetchAll();
					$totalpages = ceil(count($rawResult)/ $numOfrecs);
					$stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE products.name LIKE '%$searchKey%' WHERE quantity>0 LIMIT $offset,$numOfrecs");
					$stmt->execute();
					$products = $stmt->fetchAll();  
				}
				
              ?> 

		<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
					<li class="main-nav-list"><a  href="./index.php" ><span
								 class="lnr lnr-arrow-right"></span>All</a>
								</li>
						<?php
						$catStmt = $pdo->prepare("SELECT * FROM categories");
						$catStmt->execute();
						$categories = $catStmt->fetchAll();
							foreach ($categories as $cat) {
								?>
								<li class="main-nav-list"><a  href="./index.php?id=<?php echo $cat['id'];?>" ><span
								 class="lnr lnr-arrow-right"></span><?php echo escape($cat['name']);  ?></a>
								</li>
								<?php
							}
						?>
						

						
					</ul>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
				
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="pagination">
					<!-- <a class="page-link" href="?pageno=1"  aria-hidden="true">First</a> -->
						<a href="<?php if($pageno<=1) { echo "#";} else { echo "?pageno=".($pageno-1);}  ?>" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
						<a href="#" class="active">1</a>
						
						<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
						
						<a href="<?php if($pageno>=$totalpages) { echo "#";} else { echo "?pageno=".($pageno+1);}  ?>" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
						
						<!-- <a class="page-link" href="?pageno=<?php echo $totalpages; ?>"  aria-hidden="true">Last</a> -->
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						<?php if(empty($products)){?>
							<div class="container d-flex justify-content-center align-items-center w-100 " style="height: 180px ;">
								<h3 class="text-danger">Empty Stocks!</h3>
							</div>
						<?php }else{ ?>
							<?php 
							foreach ($products as $product) {
								?>
								<div class="col-lg-4 col-md-6">
									<div class="single-product">
										<img class="img-fluid" src="./images/<?php echo $product['image']; ?>" alt="">
										<div class="product-details">
											<h6><?php echo $product['name']; ?></h6>
											<div class="price">
												<h6><?php echo $product['price']; ?></h6>
												<h6 class="l-through"><?php echo $product['price']+5000; ?></h6>
											</div>
											<div class="prd-bottom">

												<a href="" class="social-info">
													<span class="ti-bag"></span>
													<p class="hover-text">add to bag</p>
												</a>
												<a href="product_detail.php?id=<?php echo $product['id']; ?>" class="social-info">
													<span class="lnr lnr-move"></span>
													<p class="hover-text">view more</p>
												</a>
											</div>
										</div>
									</div>
								</div>
								<?php
							}
						?>
						<?php } ?>
						
					</div>
					
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>
