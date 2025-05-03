<div class="container-fluid">
	
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Qty</th>
				<th>Order</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$total = 0;
			include 'db_connect.php';
			$qry = $conn->query("SELECT * FROM order_list o inner join product_list p on o.product_id = p.id  where order_id =".$_GET['id']);

			while($row=$qry->fetch_assoc()):
				$total += $row['qty'] * $row['price'];
			?>
			<tr>
				<td><?php echo $row['qty'] ?></td>
				<td><?php echo $row['name'] ?></td>
				<td><?php echo number_format($row['qty'] * $row['price'],2) ?></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2" class="text-right">TOTAL</th>
				<th ><?php echo number_format($total,2) ?></th>
			
				
			</tr>


		</tfoot>
	</table>
	<div class="text-left"> <form action="" id="order-frm"> <input type="hidden" name="id" value="<?php echo  $_GET['id'] ? $_GET['id']: '' ?>"> <span style="display:flex"> <select name="product_id" id="itemsId" style="width:60%"> <?php $qry = $conn->query("SELECT * FROM product_list "); while($row = $qry->fetch_assoc()): echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>'; endwhile; ?> </select> <input style="width:20%;margin-left:10px" type="number" value="" min = 1 class="form-control text-center" name="qty" > <button style="width:20%;margin-left:10px" class="btn btn-success" type="submit">Add</button> </span> </form> </div> <br/>
	<div class="text-center">
		<button class="btn btn-primary" id="confirm" type="button" onclick="confirm_order()">Confirm</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

	</div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
</style>
<script>
	function confirm_order(){
		start_load()
		$.ajax({
			url:'ajax.php?action=confirm_order',
			method:'POST',
			data:{id:'<?php echo $_GET['id'] ?>'},
			success:function(resp){
				if(resp == 1){
					alert_toast("Order confirmed.")
                        setTimeout(function(){
                            location.reload()
                        },1500)
				}
			}
		})
	}
	</script>
	<script>
    $(document).ready(function(){
          $('#order-frm').submit(function(e){
            e.preventDefault()
          
            start_load()
            $.ajax({
                url:"ajax.php?action=edit_order",
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    if(resp==1){
                        alert_toast("Order successfully Updeted.")
                        setTimeout(function(){
                            location.reload()
                        },1500)
                    }
                }
            })
        })
        })
    </script>