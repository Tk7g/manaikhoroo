	</section>

  <a class="exit-off-canvas"></a>

  </div>
</div>
	<script src="<?php echo MAIN_FOLDER; ?>/js/vendor/jquery.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation.min.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation/foundation.offcanvas.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation/foundation.alert.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/vendor/fastclick.js"></script>
	<script>
		$(document).foundation();
		$(document).ready(function(){
			$('a.left-off-canvas-toggle').click(function() {
  				$('.inner-wrap').css('min-height', $(window).height() - $('footer').outerHeight() + 'px');
			});
			
<?php 
	if(isset($_GET['action']) && $_GET['action'] == 'companyOrderStat') {
		for($i=1;$i<=12;$i++) { 
?>
	$('.slideRow<?php echo $i; ?>').click(function(){
		$('.slideRowBlock<?php echo $i; ?>').slideToggle();	
	});
<?php }} ?>
		});
	</script>
</body>
</html>