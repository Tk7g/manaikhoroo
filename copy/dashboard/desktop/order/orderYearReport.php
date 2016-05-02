<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/header.php");
	include(ADMIN_TEMPLATE. "session_check.php");
?>

<div id="mainComponent">
	<div class="mainTitle">
		<?php echo $page_title; ?>
	</div>
	<div class="mainWrapper">
		<div class="orderInfoWrapper">
			<div class="yearSelectBox">
				<form action="order.php?action=selectYearReport" method="post">
					<div class="floatRow">
						<label>Он</label>
						<select name="year" id="Year" required="required">
							<?php for($k=2014; $k<=date('Y'); $k++) { ?>
							<option value="<?php echo $k; ?>" <?php if($current_year == $k){ echo 'selected'; } ?>><?php echo $k; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="floatRow">
						<label>Төрөл</label>
						<select name="type" id="Type" required="required">
							<option value="0" <?php if($type == 0){ echo 'selected'; } ?>>Бүгд</option>
							<option value="1" <?php if($type == 1){ echo 'selected'; } ?>>Гэрээт захиалга</option>
							<option value="2" <?php if($type == 2){ echo 'selected'; } ?>>Гэрээт бус захиалга</option>
						</select>
					</div>
					<div class="floatRow">
						<button type="submit" name="selectYear" class="yearSelectBtn">Тайлан гаргах</button>
					</div>
				</form>
			</div>
			<div class="orderReportTable">
				<table width="100%">
					<tr>
						<th width="10%">Д/д</th>
						<th width="15%">Захиалгын огноо</th>
						<th width="15%">Захиалагч</th>
						<th width="15%">Гэрээний №</th>
						<th width="15%">Бүтээгдэхүүн</th>
						<th width="15%" class="text-right">Хэмжээ /м<sup>3</sup>/</th>
						<th width="15%" class="text-right">Орлого /₮/</th>
					</tr>
					<?php
						$i = 0; 
						$totalYearRevenue = 0;
						$totalYearSize = 0;
						for($m=1;$m<=12;$m++) {
							$totalMonthRevenue = 0;
							$totalMonthSize = 0;
					?>
					<tr>
						<td colspan="7" class="monthHeader"><?php echo $m.' сар'; ?></td>
					</tr>
					<?php
						if($orders[$m] == NULL) {
					?>
					<tr>
						<td colspan="7"><span class="infoNone">Энэ сард захиалга орж ирээгүй байна.</span></td>
					</tr>
					<?php
						} else {
							foreach($orders[$m] as $order) : 
								$i = $i + 1;
								$totalMonthRevenue = $totalMonthRevenue + $order['total_price'];
								$totalMonthSize = $totalMonthSize + $order['size1'];
								$totalYearRevenue = $totalYearRevenue + $order['total_price'];
								$totalYearSize = $totalYearSize + $order['size1'];
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $order['order_date']; ?></td>
						<td><?php echo $order['company_name']; ?></td>
						<td>
						<?php
						if($order['agreement_id'] != NULL) {
							echo $order['agreement_id'];	
						} else {
							echo '<span class="infoNone">Мэдээлэл алга</span>';
						} 
						?>	
						</td>
						<td><?php echo getProductTypeName($order['product_type_id']); ?></td>
						<td class="text-right"><?php echo $order['size1'].' м<sup>3</sup>'; ?></td>
						<td class="text-right">
						<?php
						if($order['total_price'] != NULL) {
							echo $order['total_price'].' ₮';	
						} else {
							echo '<span class="infoNone">Мэдээлэл алга</span>';
						}
						?>	
						</td>
					</tr>
					<?php endforeach; ?> 
					<tr class="totalRow">
						<td colspan="3"><?php echo $m; ?>-р сарын нийт дүн</td>
						<td></td>
						<td></td>
						<td class="text-right"><?php echo $totalMonthSize; ?> м<sup>3</sup></td>
						<td class="text-right"><?php echo $totalMonthRevenue; ?> ₮</td>
					</tr>
					<?php } ?>
					<?php } ?>
					<tr class="totalYearRow">
						<td colspan="3"><?php echo $current_year; ?> оны нийт дүн</td>
						<td></td>
						<td></td>
						<td class="text-right"><?php echo $totalYearSize; ?> м<sup>3</sup></td>
						<td class="text-right"><?php echo $totalYearRevenue; ?> ₮</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>