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
	<form action="?action=add" method="post" enctype="multipart/form-data">
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Бүтээгдэхүүний нэр
						<input type="text" name="title" id="Title" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Хамаарал
						<select name="parent" id="Parent">
							<option value="">Сонгоно уу</option>
							<?php foreach($dataParent as $dParent) : ?>
							<option value="<?php echo $dParent['id']; ?>"><?php echo $dParent['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-3 columns">
					<label>Эрэмбэ
						<input type="text" name="queue" id="Queue" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<button type="submit" name="saveProduct" class="saveBtn">Хадгалах</button>
				</div>
			</div>
		</div>
	</form>
	</div>
	</div>
</div>
<script>
	CKEDITOR.replace( 'Content' );
</script>
<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>