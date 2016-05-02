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
	<form action="user.php?action=add" method="post">
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Хэрэглэгчийн нэр
						<input type="text" name="username" id="Username" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Нууц үг
						<input type="password" name="password" id="Password" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Хэрэглэгчийн бүлэг</<label>
        			<select name="group_id" required="required">
        				<option>Сонгоно уу</option>
        				<option value="2">Менежер</option>
        				<option value="3">Үйлдвэрийн менежер</option>
        			</select>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<button type="submit" name="saveUser" class="saveBtn">Хадгалах</button>
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