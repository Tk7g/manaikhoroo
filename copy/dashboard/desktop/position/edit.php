<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/header.php");
	include(ADMIN_TEMPLATE. "session_check.php");
?>

<div id="mainComponent">
	<div class="mainTitle">
		<?php echo $page_title; ?>
	</div>
	<div class="mainWrapper">
	<div class="contentForm">
	<form action="?action=edit&id=<?php echo $current_position['id']; ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" id="ID" value="<?php echo $current_position['id']; ?>" />
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Албан тушаалын нэр
						<input type="text" name="title" id="Title" required="required" value="<?php echo $current_position['title']; ?>" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<button type="submit" name="savePosition" class="saveBtn">Хадгалах</button>
				</div>
			</div>
		</div>
	</form>
	</div>
	</div>
</div>
<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>