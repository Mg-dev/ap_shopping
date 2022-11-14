<?php
    session_start();
    require '../config/config.php';
    require '../config/common.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    if($_POST){
        
        if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['quantity']) || empty($_POST['category_id'])  ){
          if(empty($_POST['name'])){
              $nameErr = "name is required!";
            }
            if(empty($_POST['description'])){
              $descriptionErr = "description is required!";
            }
            if(empty($_POST['price'])){
              $priceErr = "price is required!";
            }
            if(empty($_POST['quantity'])){
              $qtyErr = "quantity is required!";
            }
            if(empty($_POST['category_id'])){
              $categoryErr = "category is required!";
            }
            if(empty($_POST['description'])){
              $descriptionErr = "description is required!";
            }
            
            }else{
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $category_id = $_POST['category_id'];
                
                $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,price=:price,quantity=:quantity,category_id=:category_id where id=:id");
                $result = $stmt->execute(
                    array(':name'=>$name,':description'=>$description,':price'=>$price,':quantity'=>$quantity,':category_id'=>$category_id,':id'=>$id)
                );
                
                
                if($result){
                    echo "<script>alert('Updated Successfully!');;window.location.href = 'index.php'</script>";
                }
            }
    }   
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
    $stmt->execute();
    $product = $stmt->fetch();

    
?>


<?php include('header.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 d-flex justify-content-between">
            <h1 class="m-0">Starter Page</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php
                        $stmt = $pdo->prepare('SELECT * FROM categories');
                        $stmt->execute();
                        $categories = $stmt->fetchAll();
                    ?>
                    <form action="product_edit.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>" />
                        <div class="form-group">
                          <div>
                                <label for="">Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" value="<?php echo $product['name']; ?>">
                          </div>
                          <span class="text-danger">
                            <?php if(empty($nameErr)) { echo ''; } else { echo $nameErr;} ?>
                          </span> 
                        </div>
                        <div class="form-group">
                          <div>
                                <label for="">Description</label><br>
                                <textarea name="description" id="" cols="140" rows="7" ><?php echo $product['description']; ?></textarea>
                                <span class="text-danger">
                          </div>
                          <span class="text-danger">

                            <?php if(empty($descriptionErr)) { echo ''; } else { echo $descriptionErr;} ?>
                          </span>
                          </span> 
                        </div>
                        
                        <div class="form-group">
                          <div>
                                <label for="">Category</label><br>
                                <select name="category_id" id="" class="form-control">
                                    <option value="">Choose Category</option>
                                    <?php   foreach ($categories as $cat) {  ?>

                                            <option value="<?php echo $cat['id']; ?>" <?php if($cat['id']==$product['category_id']){ echo 'selected';}else{ echo "";}?>>
                                            <?php echo $cat['name']; ?>
                                            </option>
                                    <?php   }   ?>
                                </select>
                                <span class="text-danger">
                          </div>
                          <span class="text-danger">

                            <?php if(empty($categoryErr)) { echo ''; } else { echo $categoryErr;} ?>
                          </span>
                          </span> 
                        </div>
                        <div class="form-group">
                          <div>
                                <label for="">Price</label><br>
                                <input type="number" class="form-control" name="price" value="<?php echo $product['price']; ?>">
                                <span class="text-danger">
                          </div>
                          <span class="text-danger">

                            <?php if(empty($priceErr)) { echo ''; } else { echo $priceErr;} ?>
                          </span>
                          </span> 
                        </div>
                        <div class="form-group">
                          <div>
                                <label for="">Qty</label><br>
                                <input type="number" class="form-control" name="quantity" value="<?php echo $product['quantity']; ?>">
                                <span class="text-danger">
                          </div>
                          <span class="text-danger">

                            <?php if(empty($qtyErr)) { echo ''; } else { echo $qtyErr;} ?>
                          </span>
                          </span> 
                        </div>
                        
                        
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Update</button>
                            <a href="index.php" class="btn btn-dark">Back</a>
                        </div>
                            
                            
                        


                    </form>
                </div>
                
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
    <?php include('footer.html') ?>