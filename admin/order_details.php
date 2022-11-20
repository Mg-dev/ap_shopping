<?php

session_start();
require '../config/config.php';
require '../config/common.php';
if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
    header('Location: login.php');
}
if($_SESSION['role']!=1){
    header('Location: login.php');
  }
include('header.php');

?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 d-flex justify-content-between">
            
            <a href="order_list.php"><button class="btn btn-dark">Back</button></a>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <?php  
                    // $stmt = $pdo->prepare('SELECT * FROM  users');
                    // $stmt->execute();
                    // $users = $stmt->fetchAll();
                    // $totalpages = 2;
                    if(!empty($_GET['pageno'])){
                            $pageno = $_GET['pageno'];
                        }else{
                            $pageno = 1;
                        }
                        $numOfrecs = 4;
                        $offset = ($pageno - 1) * $numOfrecs;
                            $stmt = $pdo->prepare("SELECT * FROM sale_order_details WHERE sale_order_id=".$_GET['id']);
                            $stmt->execute();
                            $rawResult = $stmt->fetchAll();
          
                            $totalpages = ceil(count($rawResult)/$numOfrecs);
          
                            $stmt = $pdo->prepare("SELECT * FROM sale_order_details WHERE sale_order_id=".$_GET['id']." LIMIT $offset,$numOfrecs");
                            $stmt->execute();
                            $saleOrders = $stmt->fetchAll();

                            
                          
                    ?>
                <div class="col-12">
                    <div class="card  text-center">
                        <div class="card-header d-flex justify-content-start">
                            <h3 class="card-title"> Order Details</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th style="width:10px ;">#</th>
                                        <td>product</td>
                                        <td>quantity</td>
                                        <td>order date</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($saleOrders as $sorder){ ?>

                                    <?php
                                        $pStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$sorder['product_id']);
                                        $pStmt->execute();
                                        $pResult = $pStmt->fetch();
                                    ?>
                                    <tr>
                                        <th><?php echo $i  ?></th>
                                        <td><?php echo escape($pResult['name']); ?></td>
                                        <td><?php echo escape($sorder['quantity']); ?></td>
                                        <td><?php echo escape(date('Y-m-d'),strtotime($sorder['order_date'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="container">
                                                    <a href="order_details.php?id=<?php $sorder['id']; ?>"><button class="btn btn-dark me-2 ">View</button></a>
                                                </div>
                                                <div class="container d-flex">
                                                   
                                                    <button class="btn btn-danger ">Delete</button>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                </ul>
              </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <?php include('footer.html') ?>