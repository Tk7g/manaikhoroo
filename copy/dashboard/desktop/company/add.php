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
					<label>Гэрээний дугаар
						<input type="text" name="agreement_id" id="AgreementId" required="required" />
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
					<label>Компаний нэр
						<input type="text" name="name" id="Name" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Захиалагчийн нэр
						<input type="text" name="client_name" id="ClientName" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Албан тушаал
						<select name="position_id" id="PositionId" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($positions as $pos) : ?>
        					<option value="<?php echo $pos['id']; ?>"><?php echo $pos['title']; ?></option>
        					<?php endforeach; ?>
						</select>
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Утас
						<input type="text" name="phone" id="Phone" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>И-мэйл
						<input type="text" name="email" id="Email" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Оффисын хаяг
						<input type="text" name="address" id="Address" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<button type="submit" name="saveCompany" class="saveBtn">Хадгалах</button>
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