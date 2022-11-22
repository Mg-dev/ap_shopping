<?php
if(session_status()==PHP_SESSION_NONE){
  session_start();
}
require '../config/config.php';

if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
    header('Location: login.php');
}
if($_SESSION['role']!=1){
  header('Location: login.php');
}
?>

<?php
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

                        if(empty($_POST['search'])&&empty($_COOKIE['search'])){
                            $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY id ASC");
                            $stmt->execute();
                            $rawResult = $stmt->fetchAll();
                            $totalpages = ceil(count($rawResult)/$numOfrecs);
                            $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY id ASC LIMIT $offset,$numOfrecs");
                            $stmt->execute();
                            $products = $stmt->fetchAll();
                          }else{
                            $searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
                            $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id   WHERE  products.name LIKE '%$searchKey%'   ORDER BY id DESC");
                            $stmt->execute();
                            $rawResult = $stmt->fetchAll();  
                            $totalpages = ceil(count($rawResult)/ $numOfrecs);
                            $stmt = $pdo->prepare("SELECT products.*,categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id  WHERE products.name LIKE '%$searchKey%'  ORDER BY id DESC LIMIT $offset,$numOfrecs");
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
                      <th>image</th>
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
                      
                        <tr class="p-0">
                              <td  style="height:100px;"><?php echo $product['id'] ?></td>
                              <td><?php echo $product['name'] ?></td>
                              <td><?php echo $product['description'] ?></td>
                              <td><img src="../images/<?php echo $product['image']; ?>" class="img-thumbnail" width="100" alt=""></td>
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
                  
            </div>
                </table>
              </div>
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                  <li class="page-item <?php if($pageno<=1) { echo "disabled";}  ?> ">
                    <a class="page-link" href="<?php if($pageno<=1) { echo "#";} else { echo "?pageno=".($pageno-1);}  ?>">Previous</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                  <li class="page-item <?php if($pageno>=$totalpages) { echo "disabled";}  ?>">
                    <a class="page-link" href="<?php if($pageno>=$totalpages) { echo "#";} else { echo "?pageno=".($pageno+1);}  ?>">Next</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpages; ?>">Last</a></li>
                </ul></div>
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
