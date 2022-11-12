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
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
    $stmt->execute();

    $category = $stmt->fetch();
        
    
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
                    <form action="cat_edit.php" method="post">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>" />
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                        <div class="form-group">
                          <div>
                                <label for="">Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" value="<?php echo $category['name'];  ?>">
                          </div>
                          <span class="text-danger">
                            <?php if(empty($nameErr)) { echo ''; } else { echo $nameErr;} ?>
                          </span> 
                        </div>
                        <div class="form-group">
                          <div>
                                <label for="">Description</label><br>
                                <textarea name="description" id="" cols="140" rows="7" ><?php echo $category['description'];  ?></textarea>
                                <span class="text-danger">
                          </div>
                          <span class="text-danger">

                            <?php if(empty($descriptionErr)) { echo ''; } else { echo $descriptionErr;} ?>
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