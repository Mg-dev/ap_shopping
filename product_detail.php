<?php include('header.php') ?>
<?php 
  $stmt = $pdo->prepare('SELECT products.*,categories.name as category_name from products left join categories on products.category_id = categories.id where products.id='.$_GET['id']);
  $stmt->execute();
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
  
?>
<!--================Single Product Area =================-->
<div class="product_image_area">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <div class="s_Product_carousel">
          <div class="single-prd-item">
            <img class="img-fluid" src="./images/<?php echo $product['image']; ?>" alt="">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="./images/<?php echo $product['image']; ?>" alt="">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="./images/<?php echo $product['image']; ?>" alt="">
          </div>
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo $product['name']; ?></h3>
          <h2><?php echo $product['price']; ?></h2>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : <?php  echo $product['category_name']  ?></a></li>
            <li><a href="#"><span>Availibility</span> : <?php  if($product['quantity']>0){ echo "In Stock";} else { echo "Out of Stock";} ?></a></li>
          </ul>
          <p><?php echo $product['description']; ?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
             class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
