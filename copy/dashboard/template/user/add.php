<?php include(ADMIN_TEMPLATE. "template/header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<div id="form-block">
	<form action="user.php?action=add" method="post">
		<div class="row">
    		<div class="large-12 columns">
      			<label>Хэрэглэгчийн нэр
        			<input type="text" name="username" required="required" placeholder="Хэрэглэгчийн нэр" />
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns">
      			<label>Нууц үг
        			<input type="password" name="password" required="required" placeholder="Нууц үг" />
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns">
      			<label>Хэрэглэгчийн бүлэг
        			<select name="group_id" required="required">
        				<option>Сонгоно уу</option>
        				<option value="2">Менежер</option>
        				<option value="3">Үйлдвэрийн менежер</option>
        			</select>
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns text-center">
    			<button type="submit" name="saveUser" class="button small">Хадгалах</button>
    		</div>
    	</div>
	</form>
</div>

<?php include(ADMIN_TEMPLATE. "template/footer.php"); ?>