<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=regionList">Мессеж</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=reply&id<?php echo $_GET['id']; ?>">Мессеж хариу илгээх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Мессеж хариу илгээх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<div class="control-group">
				<?php
					$user_info = User::getUserById($current_msg['user_id']);
					$district_info = District::getDistrict($user_info['district_id']);
					if($user_info['region_id'] != NULL) {
						$region_info = Region::getRegion($user_info['region_id']);
						echo '<b>'.$district_info['title'].' дүүргийн '.$region_info['title'].'-р хорооны ажилтан:</b> '.$current_msg['text'];
					} else {
						echo '<b>'.$district_info['title'].' дүүргийн админ:</b> '.$current_msg['text'];	
					}  
				?>
			</div>
			<form action="message.php?action=reply&id=<?php echo $current_msg['id']; ?>" method="post">
			<input type="hidden" name="id" id="Id" value="<?php echo $current_msg['id']; ?>"/>
			<input type="hidden" name="replied" id="Replied" value="<?php echo $_SESSION['login']['id']; ?>"/>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="title">Хариу</label>
					<div class="controls">
						<textarea cols="50" rows="8" name="reply" id="Reply" required="required" class="input-xlarge"></textarea>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="sendReply" class="btn btn-primary">Илгээх</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>