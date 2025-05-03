<?php
include 'admin/db_connect.php';
// var_dump($_SESSION);
$chk = $conn->query("SELECT * FROM cart where user_id = {$_SESSION['login_user_id']} ")->num_rows;
if($chk <= 0){
    echo "<script>alert('You don\'t have an Item in your cart yet.'); location.replace('./')</script>";
}
else{ $total = 0; $get = $conn->query("SELECT *,c.id as cid FROM cart c inner join product_list p on p.id = c.product_id where c.user_id = '".$_SESSION['login_user_id']."'"); while($row= $get->fetch_assoc()): $total += ($row['qty'] * $row['price']); endwhile; }
?>
  <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-center mb-4 page-title">
                    	<h1 class="text-white">Checkout</h1>
                        <hr class="divider my-4 bg-dark" />
                    </div>
                    
                </div>
            </div>
        </header>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="" id="checkout-frm">
                    <h4>Confirm Delivery Information</h4>
                    <div class="form-group">
                        <label for="" class="control-label">Firstname</label>
                        <input type="text" name="first_name" required="" class="form-control" value="<?php echo $_SESSION['login_first_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Lastname</label>
                        <input type="text" name="last_name" required="" class="form-control" value="<?php echo $_SESSION['login_last_name'] ?>">

                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Contact</label>
                        <input type="text" name="mobile" required="" class="form-control" value="<?php echo $_SESSION['login_mobile'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Address</label>
                        <textarea cols="30" rows="3" name="address" required="" class="form-control"><?php echo $_SESSION['login_address'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Email</label>
                        <input type="email" name="email" required="" class="form-control" value="<?php echo $_SESSION['login_email'] ?>">
                    </div>  
                    <div class="form-group"> <label for="" class="control-label">Booking Date</label> <input name="bookingdate" class="form-control" type="date" placeholder="Booking Date" required=""> </div> <div class="form-group"> <label for="" class="control-label">Booking Time</label> <input type="text" id="timepicker" name="bookingtime" class=" form-control " placeholder="Time" required=""> </div> <div class="form-group"> <label for="" class="control-label">No.of Guests</label> <input type="text" name="guests" required="" class="form-control"> </div> <div class="form-group"> <label for="" class="control-label">Total amount</label> <input type="text" name="payment" value="<?php echo $total ?> "required="" class="form-control"> </div>

                    <div class="text-center">
                        <button class="btn btn-block btn-outline-dark">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
          $('#checkout-frm').submit(function(e){
            e.preventDefault()
          
            start_load()
            $.ajax({
                url:"admin/ajax.php?action=save_order",
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    if(resp==1){
                        alert_toast("Order successfully Placed.")
                        setTimeout(function(){
                            location.replace('index.php?page=home')
                        },1500)
                    }
                }
            })
        })
        })
    </script>