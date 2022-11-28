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
                  
                  $stmt = $pdo->prepare("SELECT * FROM sale_order_details LEFT JOIN products ON sale_order_details.product_id = products.id group by product_id having count(product_id)>5");
                  $stmt->execute();
                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  
                 
                ?>
            <div class="card-body">
                <table class="table table-bordered" id="dtable">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>name</th>
                      <th>image</th>
                      <th>price</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                   <?php
                      $id = 1;
                      foreach($result as $product){
                        ?>
                      
                        <tr class="p-0">
                              <td  style="height:100px;"><?php echo $id; ?></td>
                              <td><?php echo $product['name'] ?></td>
                              <td><img src="../images/<?php echo $product['image']; ?>" class="img-thumbnail" width="100" alt=""></td>
                              <td><?php echo $product['price'] ?></td>
                              
                              
                            </tr> 
                        <?php
                      }
                      $id++;
                   ?>
                            
                          
                    
                    
                  </tbody>
                  
            </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
  $(document).ready(function () {
    $('#dtable').DataTable();
});
</script>
