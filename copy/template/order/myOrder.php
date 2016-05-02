<?php
	include(SITE_TEMPLATE."header2.php");
	include("session_check.php");
?>

<div class="myOrderTitle">
	<div class="row">
		<div class="small-12 columns">
			Миний захиалгууд
		</div>
	</div>
</div>

<div class="myOrderSearch">
	<form action="order.php?action=yearSelect" method="post">
		<div class="row">
			<div class="small-12 columns">
				<label>Он</label>
				<select name="year" id="Year" required="required">
					<?php for($k=2014;$k<=date('Y');$k++) { ?>
					<option value="<?php echo $k; ?>" <?php if($current_year == $k){ echo 'selected'; } ?>><?php echo $k.' он'; ?></option>
					<?php } ?>
				</select>
				<button type="submit" name="selectYear" class="selectYearBtn">Хайх</button>
			</div>
		</div>
	</form>
</div>

<div class="myOrderList">
	<div class="myOrderHeader">
		<div class="row">
			<div class="small-4 columns">
				Захиалгын №
			</div>
			<div class="small-5 columns">
				Бүтээгдэхүүн
			</div>
			<div class="small-3 columns">
				Хэмжээ
			</div>
		</div>
	</div>
	<div class="myOrderBody">
	<?php foreach($orders as $order) : ?>
		<div class="myOrderRow">
			<div class="row">
				<div class="small-4 columns">
					<?php echo '№ '.$order['id']; ?>
					<a class="myOrderMore" href="order.php?action=myOrderInfo&id=<?php echo $order['id']; ?>">Дэлгэрэнгүй</a>
				</div>
				<div class="small-5 columns">
					<?php echo getProductTypeName($order['product_type_id']); ?>
					<div class="addRow">
						Захиалга өгсөн:<br/>
						<?php echo substr($order['created'], 0, 10); ?>
					</div>
					<div class="addRow">
						<?php
							if($order['status'] == 1){
								echo 'Статус: Гэрээний № олгогдсон';
							} elseif($order['status'] == 2) {
								echo 'Статус: Гэрээний № олгогдсон';
							} elseif($order['status'] == 3) {
								echo 'Статус: Цуцлагдсан';
							} elseif($order['status'] == 4) {
								echo 'Статус: Үйлдвэрт шилжүүлсэн';	
							} elseif($order['status'] == 5) {
								echo 'Статус: Үйлдвэрлэж эхэлсэн';
							} elseif($order['status'] == 6) {
								echo 'Статус: Үйлдвэрлэж дууссан';
							} elseif($order['status'] == 0) {
								echo 'Статус: Илгээгдсэн';
							}
						?>
					</div>
				</div>
				<div class="small-3 columns">
					<?php echo $order['size1'].' м<sup>3</sup>'; ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>


<?php
include(SITE_TEMPLATE."footer.php");
?>