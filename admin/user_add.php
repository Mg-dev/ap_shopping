<?php
    session_start();
    require '../config/config.php';
    require '../config/common.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }

    if($_POST){
        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password'])<6 ){
            if(empty($_POST['name'])){
                $nameErr = "name is required!";
              }
              if(empty($_POST['email'])){
                $emailErr = "email is required!";
              }
              if(strlen($_POST['password'])<6){
                $pwdErr = "password should be six characeters at least!";
              }
              if(empty($_POST['password'])){
                $pwdErr = "password is required!";
              }
        }else{
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            if($_POST['role']=='on'){
                $role = 1;
            }else{
                $role = 0;
            }

            $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
            $stmt->execute(array(':email'=>$email));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($user)){
                echo "<script>alert('Email duplicated!');</script>";
            }else{
                $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
                $result = $stmt->execute(
                    array(':name'=>$name,':email'=>$email,':password'=>$password,':role'=>$role)
                );
                if($result){
                    echo "<script>alert(' Successfully added!');window.location.href = 'user_list.php';</script>";
                } 
            }

            
        }         
    }
?>
<?php include('header.php')?>
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
                    <form action="user_add.php" method="post">
                        
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>" />
                        <div class="form-group">
                            <div>
                                <label for="">Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" > 
                            </div>
                            <span class="text-danger">
                                <?php 
                                if (empty($nameErr)) {
                                    echo '';
                                }else{
                                    echo $nameErr;
                                }
                                ?>
                            </span>
                            
                                
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="">Email</label><br>
                                <input type="email" name="email" id="" class="form-control">
                            </div>
                            <span class="text-danger">
                            <?php 
                                if (empty($emailErr)) {
                                    echo '';
                                }else{
                                    echo $emailErr;
                                }
                                ?>
                            </span>
                                

                        </div>
                        <div class="form-group">
                            <div>
                                <label for="">Password</label><br>
                                <input type="password" class="form-control" name="password" >
                            </div>
                            <span class="text-danger">
                            <?php 
                                if (empty($pwdErr)) {
                                    echo '';
                                }else{
                                    echo $pwdErr;
                                }
                                ?>
                            </span>
                                
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="role"  id="flexCheckDefault" >
                            <label for="flexCheckDefault" class="form-check-label">Admin</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Create</button>
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
  <?php include('footer.html')?>