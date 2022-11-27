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
              <div class="card-header">
                <h3 class="card-title"></h3>Weekly Report
              </div>
              <!-- /.card-header -->

              <?php  
                  $current_date = date("Y-m-d");
                  $from_date = date("Y-m-d",strtotime($current_date . ' +2 day '));
                  
                  $to_date = date("Y-m-d",strtotime($current_date . ' -7 day '));
                  
                  $stmt = $pdo->prepare("SELECT * FROM sale_orders LEFT JOIN users ON sale_orders.user_id = users.id WHERE sale_orders.order_date<:from_date AND sale_orders.order_date>=:to_date ORDER BY sale_orders.id DESC")  ;
                  $stmt->execute(
                    array(":from_date"=>$from_date,":to_date"=>$to_date)
                  );
                  $sale_orders = $stmt->fetchAll();
                 
                  
                ?>
            <div class="card-body">
                <table class="table table-bordered" id="dtable">
                  
                  <thead>
                    <tr>
                        <th>Id</th>
                        <th>User_Id</th>
                        <th>Total Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                            foreach ($sale_orders as $so) {
                                ?>
                    <tr>
                        
                                <td><?php echo $so['id']; ?></td>
                                <td><?php echo $so['name']; ?></td>
                                <td><?php echo date("Y-m-d",strtotime($so['order_date'])) ?></td>
                               
                    </tr>
                    <?php
                            }
                        ?>
                    
                  </tbody>
                  
            </div>
                </table>
              </div>
              
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