<?php
    include('header.php');
    
?>

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                
                        
                                
                                <?php   if(!empty($_SESSION['cart'])){ ?>
                                    <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <div class="table-responsive">
                                    <?php 
                                        $total = 0;
                                        $subtotal = 0;
                                        foreach ($_SESSION['cart'] as $key => $qty) :
                                        $id = str_replace('id','',$key);
                                        $stmt = $pdo->prepare("SELECT * FROM products WHERE id='$id'");
                                        $stmt->execute();
                                        $product = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $total = $product['price']*$qty;
                                        $subtotal += $total;
                                        $quantity = $qty;
                                    ?>
                                    <tr>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="./images/<?php echo $product['image'] ?>" alt="" style="width:120px;">
                                            </div>
                                            <div class="media-body">
                                                <p><?php echo $product['name']; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?php echo $product['price']; ?></h5>
                                    </td>
                                    <td>
                                        <div class="product_count">
                                            <input type="text" name="qty" id="sst<?php echo $product['id'] ?>" maxlength="12" value="<?php echo $quantity ?>" title="Quantity:"
                                                class="input-text qty" disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?php echo $total  ?></h5>
                                    </td>
                                    <td>
                                        <a href="clearItem.php?pid=<?php echo $product['id']; ?>"><button class="primary-btn">Remove</button></a>
                                    </td>
                                </tr>
                                    <?php
                                    endforeach
                                    ?>
                                
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <?php if($subtotal!==0) { ?>  
                                            <h5><?php echo $subtotal; ?></h5>
                                        <?php } ?>
                                    </td>
                                </tr>
                                
                                <tr class="out_button_area">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner d-flex ">
                                            <a class="gray_btn" href="clearall.php">Clear All</a>
                                            <a class="primary-btn" href="home.php">Continue Shopping</a>
                                            <a class="gray_btn" href="sale_order.php">Order Submit</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php   }else{ ?>
                    <h3 class="text-danger text-center">Your Cart is Empty!</h3>
            <?php    }  ?>
                
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <?php include("footer.php") ?>