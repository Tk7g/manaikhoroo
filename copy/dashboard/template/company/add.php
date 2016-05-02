<?php include(ADMIN_TEMPLATE. "template/header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<div id="form-block">
	<form action="company.php?action=add" method="post">
		<div class="row">
    		<div class="large-12 columns">
      			<label>Гэрээний дугаар
        			<input type="text" name="agreement_id" required="required" placeholder="Гэрээний дугаар" />
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
      			<label>Компаний нэр
        			<input type="text" name="name" required="required" placeholder="Компаний нэр" />
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns">
      			<label>Захиалагчийн нэр
        			<input type="text" name="client_name" required="required" placeholder="Захиалагчийн нэр" />
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns">
      			<label>Албан тушаал
        			<select name="position_id" required="required">
        				<option>Сонгоно уу</option>
        			<?php foreach($positions as $pos) : ?>
        				<option value="<?php echo $pos['id']; ?>"><?php echo $pos['title']; ?></option>
        			<?php endforeach; ?>
        			</select>
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns">
      			<label>Утас
        			<input type="text" name="phone" required="required" placeholder="Утас" />
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns">
      			<label>И-мэйл
        			<input type="text" name="email" required="required" placeholder="И-мэйл хаяг" />
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns">
      			<label>Оффисын хаяг
        			<input type="text" name="address" required="required" placeholder="Оффисын хаяг" />
      			</label>
    		</div>
  		</div>
  		<div class="row">
    		<div class="large-12 columns text-center">
    			<button type="submit" name="saveCompany" class="infoFormSubmit">Хадгалах</button>
    		</div>
    	</div>
	</form>
</div>

<?php include(ADMIN_TEMPLATE. "template/footer.php"); ?>