<?php
	include(SITE_TEMPLATE."header2.php");
	include("session_check.php");
?>

<div id="order-menu">
	<div class="row small-collapse large-collapse">
		<div class="small-12 large-6 large-centered columns">
		<div class="row small-collapse large-collapse">
			<div class="small-6 large-6 columns">
				<a class="<?php if($_GET['action'] == 'companyInfo') { echo 'active-om'; } ?>" href="#" class="text-center">Компаний бүртгэл</a>
			</div>
			<div class="small-6 large-6 columns">
				<a class="<?php if($_GET['action'] == 'loginOrder') { echo 'active-om'; } ?>" href="<?php SITE_URL; ?>order.php?action=loginOrder" class="text-center">Шууд захиалга</a>
			</div>
		</div>
		</div>
	</div>
</div>
<?php if ( isset( $result ) ) { ?>
<div class="row">
<div class="small-12 columns">
	<div data-alert class="infoAlert alert-box alert round">
  		<?php echo $result; ?>
  		<a href="#" class="close">&times;</a>
	</div>
</div>
</div>
<?php } ?>

<div id="order-box">
	<form action="order.php?action=companyInfo" method="post" autocomplete="off">
		<input type="hidden" name="id" id="Id" value="<?php echo $company['id']; ?>" />
		<div class="small-10 large-6 small-centered large-centered columns">
        	<label> Гэрээний дугаар
        		<input name="agreement_id" type="text" id="AgreementId" value="<?php echo $company['agreement_id']; ?>" disabled="disabled" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Компаний нэр
        		<input name="name" type="text" id="Name" value="<?php echo $company['name']; ?>" disabled="disabled" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Захиалагчийн нэр
        		<input name="client_name" type="text" id="ClientName" value="<?php echo $company['client_name']; ?>" disabled="disabled" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Албан тушаал
        		<input name="position_id" type="text" id="PositionId" value="<?php echo getPositionName($company['position_id']); ?>" disabled="disabled" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Утас
        		<input name="phone" type="text" id="Phone" value="<?php echo $company['phone']; ?>" disabled="disabled" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> И-мэйл
        		<input name="email" type="text" id="Email" value="<?php echo $company['email']; ?>" disabled="disabled" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Нууц үг
        		<input name="password" type="password" id="Password" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Нууц үг баталгаажуулах
        		<input name="password2" type="password" id="Password2" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<div class="row small-collapse large-collapse">
        		<div class="small-12 large-5 small-centered columns text-center">
        			<button type="submit" name="companySubmit" class="button small expand yellow">Хадгалах</button>
        		</div>
        	</div>
        </div>
	</form>
</div>

<?php
include(SITE_TEMPLATE."footer.php");
?>

<script>
  $(function() {
    $( "#OrderDate" ).datepicker({
    	dateFormat: "yy-mm-dd"
    });
  });
  
  $(document).ready(function(){
  	$('#OrderTime').change(function() {
  		var selectedName = $("#OrderTime option:selected").text();
  		var selectedTime = $("#OrderTime option:selected").attr('id');
    	$("#OrderTime option:selected").text(selectedName + '-' + selectedTime + ':00');
	});
  });
</script>