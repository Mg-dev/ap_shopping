<?php

session_start();
require '../config/config.php';
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
            <h1 class="m-0">Starter Page</h1>
            <a href="user_add.php"><button class="btn btn-success">Add user</button></a>
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

                        if(empty($_POST['search'])){
                  
                            $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id ASC");
                            $stmt->execute();
                            $rawResult = $stmt->fetchAll();
          
                            $totalpages = ceil(count($rawResult)/$numOfrecs);
          
                            $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id ASC LIMIT $offset,$numOfrecs");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                          }else{
                            $searchKey = $_POST['search'];
                            $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
                            $stmt->execute();
                            $rawResult = $stmt->fetchAll();
          
                            $totalpages = ceil(count($rawResult)/ $numOfrecs);
          
                            $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                            $stmt->execute();
                            $users = $stmt->fetchAll();  
                          }
                    ?>
                <div class="col-12">
                    <div class="card  text-center">
                        <div class="card-header d-flex justify-content-start">
                            <h3 class="card-title">User listing</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>Id</th>
                                        <td>name</td>
                                        <td>email</td>
                                        <td>phone</td>
                                        <td>address</td>
                                        <td>role</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($users as $u){ ?>
                                    <tr>

                                        <th><?php echo $i  ?></th>
                                        <td><?php echo escape($u['name']); ?></td>
                                        <td><?php echo escape($u['email']); ?></td>
                                        <td><?php echo escape($u['phone']); ?></td>
                                        <td><?php echo escape($u['address']); ?></td>
                                        <td>
                                            <?php

                                                if($u['role'] === 1){
                                                    echo 'admin';
                                                }else{
                                                    echo 'user';
                                                }

                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="container">
                                                    <a href="user_edit.php?id=<?php echo $u['id']; ?>"><button class="btn btn-warning me-2 ">Edit</button></a>
                                                </div>
                                                <div class="container d-flex">
                                                    <a href="user_delete.php?id=<?php echo $u['id']; ?>"
                                                        onclick="return confirm('Are you sure, you want to delete this post?')"
                                                    >
                                                    <button class="btn btn-danger ">Delete</button>
                                                    </a>
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