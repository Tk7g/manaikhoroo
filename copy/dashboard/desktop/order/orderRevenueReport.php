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
				<form action="order.php?action=selectYearRevenueReport" method="post">
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
					<?php
						$i = 0; 
						$totalYearRevenue = 0;
						$totalYearGift = 0;
						$totalYearBarter = 0;
						$totalYearPaid = 0;
						$totalYearLeft = 0;
						for($m=1;$m<=12;$m++) {
							$totalMonthRevenue = 0;
							$totalMonthGift = 0;
							$totalMonthBarter = 0;
							$totalMonthPaid = 0;
							$totalMonthLeft = 0;
					?>
					<tr>
						<td colspan="8" class="monthHeader"><?php echo $m.' сар'; ?></td>
					</tr>
					<?php
						if($orders[$m] == NULL) {
					?>
					<tr>
						<td colspan="8"><span class="infoNone">Энэ сард захиалга орж ирээгүй байна.</span></td>
					</tr>
					<?php
						} else {
					?>
					<tr>
						<th width="5%">Д/д</th>
						<th width="10%">Захиалагч</th>
						<th width="10%">Гэрээний №</th>
						<th width="15%" class="text-right">Gift</th>
						<th width="15%" class="text-right">Бартер</th>
						<th width="15%" class="text-right">Төлсөн</th>
						<th width="15%" class="text-right">Төлбөрийн үлдэгдэл</th>
						<th width="15%" class="text-right">Нийт дүн</th>
					</tr>
					<?php
							foreach($orders[$m] as $order) : 
								$i = $i + 1;
								$totalMonthRevenue = $totalMonthRevenue + $order['total_price'];
								$totalMonthGift = $totalMonthGift + $order['gift'];
								$totalMonthBarter = $totalMonthBarter + $order['barter'];
								$totalMonthPaid = $totalMonthPaid + $order['payment1'];
								$totalMonthLeft = $totalMonthLeft + $order['payment2'];
								$totalYearRevenue = $totalYearRevenue + $order['total_price'];
								$totalYearGift = $totalYearGift + $order['gift'];
								$totalYearBarter = $totalYearBarter + $order['barter'];
								$totalYearPaid = $totalYearPaid + $order['payment1'];
								$totalYearLeft = $totalYearLeft + $order['payment2'];
					?>
					<tr>
						<td><?php echo $i; ?></td>
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
						<td class="text-right">
						<?php
						if($order['gift'] != 0) {
							echo $order['gift'].' ₮';	
						} else {
							echo '<span class="infoNone">-</span>';
						}
						?>		
						</td>
						<td class="text-right">
						<?php
						if($order['barter'] != 0) {
							echo $order['barter'].' ₮';	
						} else {
							echo '<span class="infoNone">-</span>';
						}
						?>		
						</td>
						<td class="text-right">
						<?php
						if($order['payment1'] != NULL) {
							echo $order['payment1'].' ₮';	
						} else {
							echo '<span class="infoNone">Мэдээлэл алга</span>';
						}
						?>	
						</td>
						<td class="text-right">
						<?php
						if($order['payment2'] != NULL) {
							echo $order['payment2'].' ₮';	
						} else {
							echo '<span class="infoNone">Мэдээлэл алга</span>';
						}
						?>	
						</td>
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
						<td class="text-right gift_col"><?php echo $totalMonthGift; ?> ₮</td>
						<td class="text-right barter_col"><?php echo $totalMonthBarter; ?> ₮</td>
						<td class="text-right paid_col"><?php echo $totalMonthPaid; ?> ₮</td>
						<td class="text-right left_col"><?php echo $totalMonthLeft; ?> ₮</td>
						<td class="text-right"><?php echo $totalMonthRevenue; ?> ₮</td>
					</tr>
					<tr class="additionalTotalInfo">
						<td class="text-right" colspan="4"></td>
						<td class="text-right" colspan="3">
						<?php
							echo '( Нийт дүн - Gift )';
						?>
						</td>
						<td class="text-right">
							<?php
							if($totalMonthRevenue != 0) {
								echo $totalMonthRevenue - $totalMonthGift;
								echo ' ₮'; 
							} else {
								echo 'Мэдээлэл алга байна.';
							}
							?>
						</td>
					</tr>
					<tr class="additionalTotalInfo">
						<td class="text-right" colspan="4"></td>
						<td class="text-right" colspan="3">
						<?php
							echo '( Нийт дүн - Gift - Төлбөрийн үлдэгдэл )';
						?>
						</td>
						<td class="text-right">
							<?php
							if($totalMonthRevenue != 0) {
								echo $totalMonthRevenue - $totalMonthGift -$totalMonthLeft;
								echo ' ₮'; 
							} else {
								echo 'Мэдээлэл алга байна.';
							}
							?>
						</td>
					</tr>
					<?php } ?>
					<?php } ?>
					<tr class="totalYearRow">
						<td colspan="3"><?php echo $current_year; ?> оны нийт дүн</td>
						<td class="text-right"><?php echo $totalYearGift; ?> ₮</td>
						<td class="text-right"><?php echo $totalYearBarter; ?> ₮</td>
						<td class="text-right"><?php echo $totalYearPaid; ?> ₮</td>
						<td class="text-right"><?php echo $totalYearLeft; ?> ₮</td>
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