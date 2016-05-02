<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=districtList">Мессеж</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo 'Мессеж'; ?></h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<a href="?action=districtWrite" class='quick-button-small span1'><i class="icon-plus"></i><p>Нэмэх</p></a>
			<div class="clearfix"></div>
		</div>
		<?php if ( isset( $results['statusMessage'] ) ) { ?>
        	<div class="box-content status-message"><?php echo $results['statusMessage'] ?></div>
		<?php } ?>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
				<thead>
					<tr>
						<th width="5%">№</th>
						<th width="40%">Мессеж</th>
						<th width="10%">Илгээсэн огноо</th>
						<th width="35%">Хэнд илгээсэн</th>
						<th width="10%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($messages as $msg) :
						$k = $k + 1; 
						$user_info = User::getUserById($msg['wrote']);
						$district_info = District::getDistrict($user_info['district_id']);
						if($user_info['region_id'] != NULL) {
							$region_info = Region::getRegion($user_info['region_id']);
						}
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $msg['text']; ?></td>
						<td><?php echo $msg['created']; ?></td>
						<td>
						<span class="sentUserList">
						<?php
						$regionSents = Message::getRegionSentMessages($msg['id']);
						foreach($regionSents as $regSent) :
							$region = Region::getRegion($regSent['to_region_id']);
							echo $region['title'].'-р хороо, ';
						endforeach;
						
						$districtSents = Message::getDistrictSentMessages($msg['id']);
						foreach($districtSents as $distSent) :
							$district = District::getDistrict($distSent['to_district_id']);
							echo $district['title'].', ';
						endforeach;
						
						$adminSents = Message::getAdminSentMessages($msg['id']);
						if($adminSents != NULL) {
							echo 'Системийн админ';
						}
						?>
						</span>
						</td>
						<td>
							<a href="?action=deleteDistrictList&id=<?php echo $msg['id']; ?>" class='btn btn-danger' onclick="return confirm('<?php echo $msg['text']; ?> - мессежийг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>