<header class="masthead"> <div class="container h-100"> <div class="row h-100 align-items-center justify-content-center text-center"> <div class="col-lg-10 align-self-center mb-4 page-title"> <h1 class="text-white">My Bookings</h1> <hr class="divider my-4 bg-dark" /> </div> </div> </div> </header> <section class="page-section"> <div class="container-fluid"> <div class="card" style="margin-top: 50px;"> <div class="card-body"> <table class="table table-bordered"> <thead> <tr> <th>#</th> <th>Name</th> <th>Address</th> <th>Email</th> <th>Mobile</th> <th>Booking Date</th> <th>Booking Time</th> <th>No. of Guests</th> <th>Status</th><th>Chake Order</th> <th>Payment</th> </tr> </thead> <tbody> <?php
$i = 1;
$data = "";
include "admin/db_connect.php";
if (isset($_SESSION["login_mobile"])) {
    $data = "where mobile = '" . $_SESSION["login_mobile"] . "' ";
    $qry = $conn->query(
        "SELECT * FROM orders where mobile ={$_SESSION["login_mobile"]} ORDER BY orders.id DESC"
    );
    while (
        $row = $qry->fetch_assoc()
    ): ?> <tr> <td><?php echo $i++; ?></td> <td><?php echo $row[
    "name"
]; ?></td> <td><?php echo $row["address"]; ?></td> <td><?php echo $row[
    "email"
]; ?></td> <td><?php echo $row["mobile"]; ?></td> <td><?php echo $row[
    "bookingdate"
]; ?></td> <td><?php echo $row["bookingtime"]; ?></td> <td><?php echo $row[
    "guests"
]; ?></td> <?php if (
    $row["status"] == 1
): ?> <td class="text-center"><span class="badge badge-success">Confirmed</span></td> <?php else: ?> <td class="text-center"><span class="badge badge-secondary">For Verification</span></td> <?php endif; ?> <td> <button class="btn btn-sm btn-primary view_order" data-id="<?php echo $row[
     "id"
 ]; ?>" >View Order</button> </td> 

    <td> <button class="btn btn-sm btn-primary view_payment" data-id="<?php echo $row[
     "id"
 ]; ?>" >View payment</button> </td> 
</tr> 

<?php endwhile;
} else {
     ?> <tr> <td colspan="10" style="text-align: -webkit-center">No any bookings available!</td> </tr> <?php
}
?> </tbody> </table> </div> </div> </section> 
<style>
    .payment-popup{display: none;position: fixed;
    top: 0;
    left: 0;
    right: 0;
    margin: 0 auto;
    box-shadow: 0px 0px 0px 9999px rgba(255, 255, 255, 0.831);
    width: 100%;}
    .close-popup{color:#000;font-size: 18px;position: absolute;top:0;right:0;}
</style>
<div class="payment-popup">
    <span class="close-popup">Close</span>
    <img src="assets/img/scanr.jpg" class="scan-im" alt="" />
</div>

<script> 
$('.view_order').click(function(){ uni_modal('Order Details','order_items.php?id='+$(this).attr('data-id')) }) 
// $('.view_payment').click(function(){ uni_modal('payment','order_items.php?id='+$(this).attr('data-id')) }) 

$('.view_payment').on('click',function(){
    $('.payment-popup').show();
})
$('.close-popup').on('click',function(){
    $('.payment-popup').hide();
})
</script> 
