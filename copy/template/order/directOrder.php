<?php
	include(SITE_TEMPLATE."header2.php");
?>

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
	<form action="order.php?action=directOrder" method="post" autocomplete="off">
		<div class="small-10 large-6 small-centered large-centered columns">
        	<label> Компаний нэр
        		<input name="company_name" type="text" id="CompanyName" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Захиалагчийн нэр
        		<input name="client_name" type="text" id="ClientName" />
        	</label>
        </div>
         <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Албан тушаал
        		<select name="position_id" id="PositionId" required="required">
        			<option value="">Сонгоно уу</option>
        			<?php foreach($positions as $position) : ?>
        			<option value="<?php echo $position['id']; ?>"><?php echo $position['title']; ?></option>
        			<?php endforeach; ?>
        		</select>
        	</label>
        </div>
         <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Утас
        		<input name="phone" type="text" id="Phone" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> И-мэйл
        		<input name="email" type="text" id="Email" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
			<label>Хаяг
        		<input name="address" type="text" id="Address" required="required"/>
        	</label>
		</div>
		<div class="small-10 large-6 small-centered large-centered columns">
			 <label> Бүтээгдэхүүний төрөл</label>
        		<select name="product_type_id" id="ProductTypeID" required="required">
        			<option>Сонгоно уу</option>
        		<?php foreach($parentProTypes as $parentPT) : ?>
        			<?php if($childProType[$parentPT['id']] != NULL) { ?>
        				<optgroup label="<?php echo $parentPT['title']; ?>">
        				<?php foreach($childProType[$parentPT['id']] as $childPT) : ?>
        					<option value="<?php echo $childPT['id']; ?>"><?php echo $childPT['title']; ?></option>
        				<?php endforeach; ?>
        				</optgroup>
        			<?php } else { ?>
        				<option value="<?php echo $parentPT['id']; ?>"><?php echo $parentPT['title']; ?></option>
        			<?php } ?>
        		<?php endforeach; ?>
        		</select>
		</div>
		<div class="small-10 large-6 small-centered large-centered columns">
			 <label> Захиалгын хэмжээ м<sup>3</sup>
			 	<div class="row small-collapse large-collapse">
			 		<div class="small-5 large-5 columns">
			 			<input name="size1" type="text" id="Size1" required="required" placeholder="" />	
			 		</div>
			 		<div class="small-2 large-2 columns">
			 			
			 		</div>
			 		<div class="small-5 large-5 columns">
			 			<input name="size2" type="text" id="Size2" required="required" placeholder="" />
			 		</div>
			 	</div>
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Сламп
        		<select name="slump_type_id" id="SlumpTypeId" required="required">
        			<option value="">Сонгоно уу</option>
        			<?php foreach($slumps as $slump) : ?>
        				<option value="<?php echo $slump['id']; ?>"><?php echo $slump['title']; ?></option>
        			<?php endforeach; ?>
        		</select>	
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Төлбөрийн төлөв
        		<select name="payment_status" id="PaymentStatus" required="required">
        			<option value="">Сонгоно уу</option>
        			<option value="1">Бэлнээр</option>
        			<option value="2">Гэрээний дагуу</option>
        		</select>	
        	</label>
        </div>
         <div class="small-10 large-6 small-centered large-centered columns">
        	<label>Захиалгын огноо
        		<input name="order_date" type="text" id="OrderDate" required="required" placeholder="Захиалгын огноо" />
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Захиалгын цаг
        		<select name="order_time" id="OrderTime" required="required">
        			<option value="">Сонгоно уу</option>
        			<?php for($i=0; $i<=24; $i++) { ?>
        				<option id="<?php echo $i+2; ?>" value="<?php echo $i.':00'; ?>"><?php echo $i.':00'; ?></option>
        			<?php } ?>
        		</select>	
        	</label>
        </div>
		<div class="small-10 large-6 small-centered large-centered columns">
			 <label> Помп хэрэглэх
        		<select name="pomp_type_id" id="PompID">
        			<option value="">Сонгоно уу</option>
        			<?php foreach($pomps as $pomp) : ?>
        				<option value="<?php echo $pomp['id']; ?>"><?php echo $pomp['title']; ?></option>
        			<?php endforeach; ?>
        		</select>
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Бетон цутгалтын төрөл
        		<select name="concrete_type_id" id="ConcreteTypeId" required="required">
        			<option value="">Сонгоно уу</option>
        			<?php foreach($concretes as $concrete) : ?>
        				<option value="<?php echo $concrete['id']; ?>"><?php echo $concrete['title']; ?></option>
        			<?php endforeach; ?>
        		</select>	
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<label> Нэмэлт тайлбар
        		<input name="description" type="text" id="Description" placeholder="Нэмэлт тайлбар"/>
        	</label>
        </div>
        <div class="small-10 large-6 small-centered large-centered columns">
        	<div class="row small-collapse large-collapse">
        		<div class="small-5 large-5 columns text-center">
        			<button type="submit" name="orderSubmit" class="button small expand yellow">Батлах</button>
        		</div>
        		<div class="small-2 large-2 columns">
			 			
			 	</div>
        		<div class="small-5 large-5 columns text-center">
        			<a href="order.php?action=directOrder" class="button small expand red">Цуцлах</a>
        		</div>
        	</div>
        </div>
	</form>
</div>

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

<?php
include(SITE_TEMPLATE."footer.php");
?>