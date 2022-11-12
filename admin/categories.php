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
            <a href="cat_add.php"><button class="btn btn-success">Add Category</button></a>
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
                <h3 class="card-title">Category Listings</h3>
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
                  
                  $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id ASC");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();

                  $totalpages = ceil(count($rawResult)/ $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id ASC LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $categories = $stmt->fetchAll();
                }else{
                  

                  $searchKey = $_POST['search'];
                  $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id ASC");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();

                  $totalpages = ceil(count($rawResult)/ $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id ASC LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $categories = $stmt->fetchAll();  
                }
                
            ?> 
              <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th style="width: 40px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    
                      if($categories){

                        $i=1;
                        foreach($categories as $cat){
                          
                          ?>
                            <tr class="">
                              <td><?php echo $i ?></td>
                              <td><?php echo escape($cat['name']) ?></td>
                              <td>
                                    <?php echo subwords(escape($cat['description']),10).'...' ?>
                              </td>
                              <td class="">
                                <div class="btn-group">
                                <div class="container">
                                <a href="cat_edit.php?id=<?php echo $cat['id']; ?>"><button class="btn btn-warning me-2 ">Edit</button></a>
                                

                                </div>
                                <div class="container">
                                <a href="cat_delete.php?id=<?php echo escape($cat['id']); ?>">
                              
                                  <button class="btn btn-danger ">Delete</button>
                                </a>

                                </div>
                                </div>
                                
                              </td>
                            </tr> 
                          <?php
                          $i++;
                        }
                        
                      }
                     
                      ?>
                    
                    
                    </tbody>
                </table>
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
