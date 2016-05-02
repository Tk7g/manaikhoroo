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
		<a href="/dashboard/message.php?action=add">Мессеж илгээх</a>
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
			<form action="message.php?action=add" method="post">
			<input type="hidden" name="user_id" id="userId" value="<?php echo $_SESSION['login']['id']; ?>"/>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="title">Текст</label>
					<div class="controls">
						<textarea cols="50" rows="8" name="text" id="Text" required="required" class="input-xlarge"></textarea>
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