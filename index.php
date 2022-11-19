<?php include('header.php') ?>

<?php
				if(session_status()==PHP_SESSION_NONE){
					session_start();
				}
				require('./config/config.php');
				require('./config/common.php');
                if(!empty($_GET['pageno'])){
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }
                $numOfrecs = 3;
                $offset = ($pageno - 1) * $numOfrecs;
				
                if(empty($_POST['search'])){
                  $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();
                  $totalpages = ceil(count($rawResult)/ $numOfrecs);
                  $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id   LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $products = $stmt->fetchAll();
                }else{
                  $searchKey = $_POST['search'];
                  $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE name LIKE '%$searchKey%' ");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();
                  $totalpages = ceil(count($rawResult)/ $numOfrecs);
                  $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE name LIKE '%$searchKey%'  LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $products = $stmt->fetchAll();  
                }
				$catStmt = $pdo->prepare("SELECT * FROM categories");
				$catStmt->execute();
				$categories = $catStmt->fetchAll();
				if(!empty($_GET['id'])){
					$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=:id");
					$stmt->execute(
						array("id"=>$_GET['id'])
					);
					$products = $stmt->fetchAll();
					
				}
                
              ?> 

		<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
					<li class="main-nav-list"><a  href="./index.php?id=" ><span
								 class="lnr lnr-arrow-right"></span>All</a>
								</li>
						<?php
							foreach ($categories as $cat) {
								?>
								<li class="main-nav-list"><a  href="./index.php?id=<?php echo $cat['id'];?>" ><span
								 class="lnr lnr-arrow-right"></span><?php echo $cat['name'];  ?></a>
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
												<a href="" class="social-info">
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
						
						<!-- single product -->
						<!-- <div class="col-lg-4 col-md-6">
							<div class="single-product">
								<img class="img-fluid" src="img/product/p2.jpg" alt="">
								<div class="product-details">
									<h6>addidas New Hammer sole
										for Sports person</h6>
									<div class="price">
										<h6>$150.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
									<div class="prd-bottom">

										<a href="" class="social-info">
											<span class="ti-bag"></span>
											<p class="hover-text">add to bag</p>
										</a>
										<a href="" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">view more</p>
										</a>
									</div>
								</div>
							</div>
						</div> -->
						<!-- single product -->
						<!-- <div class="col-lg-4 col-md-6">
							<div class="single-product">
								<img class="img-fluid" src="img/product/p3.jpg" alt="">
								<div class="product-details">
									<h6>addidas New Hammer sole
										for Sports person</h6>
									<div class="price">
										<h6>$150.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
									<div class="prd-bottom">

										<a href="" class="social-info">
											<span class="ti-bag"></span>
											<p class="hover-text">add to bag</p>
										</a>
										<a href="" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">view more</p>
										</a>
									</div>
								</div>
							</div>
						</div> -->
					</div>
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>
