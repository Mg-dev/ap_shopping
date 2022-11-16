<?php
    session_start();
    require '../config/config.php';
    require '../config/common.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    if($_POST){
      if(empty($_POST['name']) || empty($_POST['description'])  ){
        if(empty($_POST['name'])){
            $nameErr = "name is required!";
          }
          if(empty($_POST['description'])){
            $descriptionErr = "description is required!";
          }
    }else{
      
            $name = $_POST['name'];
            $description = $_POST['description'];
            $id = $_POST['id'];
            
            $stmt = $pdo->prepare("UPDATE categories SET name=:name, description=:description  WHERE id=:id");
            $result = $stmt->execute(
                array(':name'=>$name,':description'=>$description,':id'=>$id)
            );

            if($result){
                echo "<script>alert('Updated Successfully!');;window.location.href = 'categories.php'</script>";
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
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo ($user['id']);?>" />
                        
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>" />
                        <div class="form-group">
                            <div>
                                <label for="">Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" value="<?php echo escape($user['name']); ?>" >
                            </div>
                            <span class="text-danger">
                                <?php if(empty($nameErr)){ echo ''; } else { echo $nameErr;}  ?>
                            </span>
                                
                        </div>
                        <div class="form-group">
                                <div>
                                    <label for="">Email</label><br>
                                    <input type="email" name="email" id="" class="form-control" value="<?php echo escape($user['email']); ?>" >
                                </div>
                                <span class="text-danger">
                                    <?php if(empty($emailErr)){ echo ''; } else { echo $emailErr;}  ?>
                                </span>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="">Password</label><br>
                                <small>
                                  <?php if($user['password']){ echo "password already exit."; }else{ echo ''; } ?>
                                </small>
                                <input type="password" class="form-control" name="password" value="" >
                            </div>
                            <span class="text-danger">
                                    <?php if(empty($pwdErr)){ echo ''; } else { echo $pwdErr;}  ?>
                            </span>
                            
                                
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="role"  id="flexCheckDefault" <?php if($user['role']=='1'){echo "checked";} ?>>
                            <label for="flexCheckDefault" class="form-check-label">Admin</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Update</button>
                            <a href="user_list.php" class="btn btn-dark">Back</a>
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