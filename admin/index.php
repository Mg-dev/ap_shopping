<?php
session_start();
require '../config/config.php';
require '../config/common.php';
if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
  header('Location: login.php');
}


function subwords( $str, $max = 24, $char = ' ', $end = '...' ) {
  $str = trim( $str ) ;
  $str = $str . $char ;
  $len = strlen( $str ) ;
  $words = '' ;
  $w = '' ;
  $c = 0 ;
  for ( $i = 0; $i < $len; $i++ )
      if ( $str[$i] != $char )
          $w = $w . $str[$i] ;
      else
          if ( ( $w != $char ) and ( $w != '' ) ) {
              $words .= $w . $char ;
              $c++ ;
              if ( $c >= $max ) {
                  break ;
              }
              $w = '' ;
          }
  if ( $i+1 >= $len ) {
      $end = '' ;
  }
  return trim( $words ) . $end ;
}
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
            <a href="product_add.php"><button class="btn btn-success">Add Product</button></a>
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
              <div class="card-header">
                <h3 class="card-title">Product Listings</h3>
              </div>
              <!-- /.card-header -->

              <?php
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
                  // print '<pre>';
                  // print_r($products);
                  // exit();
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
                
              ?> 
            <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>name</th>
                      <th>description</th>
                      <th>price</th>
                      <th>quantity</th>
                      <th>category_name</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
                      foreach($products as $product){
                        ?>
                        <tr class="">
                              <td><?php echo $product['id'] ?></td>
                              <td><?php echo $product['name'] ?></td>
                              <td><?php echo $product['description'] ?></td>
                              <td><?php echo $product['price'] ?></td>
                              <td><?php echo $product['quantity'] ?></td>
                              <td>
                              <?php echo $product['category_name'] ?>
                              </td>
                              <td class="">
                                <div class="btn-group">
                                <div class="container">
                                <a href="product_edit.php?id=<?php echo $product['id']; ?>"><button class="btn btn-warning me-2 ">Edit</button></a>
                                

                                </div>
                                <div class="container">
                                <!-- <?php echo escape($product['id']); ?> -->
                                <a href="product_delete.php?id=<?php echo escape($product['id']); ?>">
                              
                                  <button class="btn btn-danger ">Delete</button>
                                </a>

                                </div>
                                </div>
                                
                              </td>
                            </tr> 
                        <?php
                      }
                   ?>
                            
                          
                    
                    
                  </tbody>
                </table>
              </div>
            <!-- /.card -->
            </div>
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
