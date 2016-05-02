<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=districtList">Мессеж</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=districtWrite">Мессеж илгээх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Мессеж илгээх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="message.php?action=districtWrite" method="post">
			<input type="hidden" name="wrote" id="Wrote" value="<?php echo $_SESSION['login']['id']; ?>"/>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="title">Текст</label>
					<div class="controls">
						<textarea cols="50" rows="6" name="text" id="Text" required="required" class="input-xlarge"></textarea>
					</div>
				</div>
				<div class="control-group">
					<div class="regionCheckTitle">
						Хороодын хэрэглэгчид
					</div>
					<div class="regionCheckRow">
					<?php foreach($regions as $region) : ?>
						<div class="regionCheckBlock">
							<input type="checkbox" name="toRegion<?php echo $region['id']; ?>" class="regionCheckbox" value="<?php echo $region['id']; ?>" >
							<label><?php echo $region['title'].'-р хороо'; ?></label>
						</div>
					<?php endforeach; ?>	
					</div>
				</div>
				<div class="control-group">
					<div class="regionCheckTitle">
						Дүүргийн админууд
					</div>
					<div class="regionCheckRow">
					<?php foreach($districts as $district) : ?>
						<?php if($district['id'] != $_SESSION['login']['district_id']) : ?>
						<div class="regionCheckBlock">
							<input type="checkbox" name="toDistrict<?php echo $district['id']; ?>" class="regionCheckbox" value="<?php echo $district['id']; ?>" >
							<label><?php echo $district['title']; ?></label>
						</div>
						<?php endif; ?>
					<?php endforeach; ?>	
					</div>
				</div>
				<div class="control-group">
					<div class="regionCheckRow">
						<div class="regionCheckBlock">
							<input type="checkbox" name="toAdmin" class="regionCheckbox" value="1" >
							<label>Системийн админ</label>
						</div>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="sendMessage" class="btn btn-primary">Илгээх</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>