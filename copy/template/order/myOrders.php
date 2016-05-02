<?php
	include(SITE_TEMPLATE."header2.php");
	include("session_check.php");
?>

<div class="myListBox">
	<?php
		$i = 0; 
		foreach($orders as $order) : 
		$i = $i + 1;
	?>
	<div class="myOrderRow">
		<div class="row">
			<div class="small-1 columns">
				<?php echo $i; ?>
			</div>
			<div class="small-5 columns">
				<div class="myOrderProduct">
				<?php echo getProductTypeName($order['product_type_id']); ?>
				</div>
			</div>
			<div class="small-4 columns text-center">
				<div class="myOrderDate">
				<?php echo $order['order_date']; ?>
				</div>
			</div>
			<div class="small-2 columns text-center">
				<a href="#" class="myOrderView">Үзэх</a>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<?php if ( isset( $result ) ) { ?>
<div class="row">
<div class="small-12 columns">
	<div data-alert class="infoAlert alert-box alert round">
  		<?php echo $result; ?>
  		<a href="#" class="close">&times;</a>
	</div>
</div>
</div>
<?php } ?>

<?php
include(SITE_TEMPLATE."footer.php");
?>