<?php 
include(ADMIN_TEMPLATE."session_check.php"); 
include(SITE_TEMPLATE. "header.php");
?>
<div id="userPage">
	<div class="container">
		<div class="col-md-2">
		<?php require(SITE_TEMPLATE . "users/menu-left.php"); ?>
		</div>
		<div class="col-md-10">
			<h2 class="up-title">
				Миний илгээсэн тэмдэглэгээ
			</h2>
			<div class="msg-block">
				<?php echo $result; ?>
			</div>
			<div class="sanalList">
				
				<table width="100%">
					<tr>
						<th width="5%">№</th>
						<th width="25%">Төрөл</th>
						<th width="20%">Байршил</th>
						<th width="10%">Хорооны зөвшөөрөл</th>
						<th width="10%">Дүүргийн зөвшөөрөл</th>
						<th width="10%">Нийтлэгдсэн</th>
						<th width="20%"></th>
					</tr>
					<?php
						$i = 0; 
						foreach($markers as $marker) : 
						$i = $i + 1;
					?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td class="text-center"><?php echo $marker['typeTitle']; ?></td>
						<td class="text-center">
							<div><?php echo $marker['districtTitle']; ?></div>
							<div><?php echo $marker['regionTitle'].'-р хороо'; ?></div>
							<div><?php echo $marker['latitude'].', '.$marker['longitude']; ?></div>
						</td>
						<td class="text-center">
						<?php
							if($marker['region_accepted'] == 1) {
								echo '<i class="glyphicon glyphicon-ok"></i>';
							} else {
								echo '<i class="glyphicon glyphicon-remove"></i>';
							}
						?>
						</td>
						<td class="text-center">
						<?php
							if($marker['district_accepted'] == 1) {
								echo '<i class="glyphicon glyphicon-ok"></i>';
							} else {
								echo '<i class="glyphicon glyphicon-remove"></i>';
							}
						?>
						</td>
						<td class="text-center">
						<?php
							if($marker['published'] == 1) {
								echo '<i class="glyphicon glyphicon-ok"></i>';
							} else {
								echo '<i class="glyphicon glyphicon-remove"></i>';
							}
						?>
						</td>
						<td class="text-center">
							<a href="user.php?page=viewMarker&type=<?php echo $marker['type_id']; ?>&d=<?php echo $marker['district_id']; ?>&r=<?php echo $marker['region_id']; ?>&id=<?php echo $marker['id'] ?>" class="reply-link">Тэмдэглэгээ харах</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include(SITE_TEMPLATE. "footer.php"); ?>