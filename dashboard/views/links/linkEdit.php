<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/link.php">Холбоос</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/link.php?action=edit">Холбоос засварлах</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Холбоос засварлах</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="link.php?action=edit" method="post">
			<input type="hidden" name="id" value="<?php echo $current_link['id']; ?>" id="NewsId">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="LinkTitle">Холбоосын гарчиг</label>
					<div class="controls">
						<input type="text" name="title" id="LinkTitle" required="required" class="input-xlarge" value="<?php echo $current_link['title']; ?>"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Link">Холбоосын линк</label>
					<div class="controls">
						<input type="text" name="link" id="Link" required="required" class="input-xlarge" value="<?php echo $current_link['link']; ?>"/>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveLink" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>