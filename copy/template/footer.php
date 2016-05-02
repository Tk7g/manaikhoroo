	</section>
    
    <a class="exit-off-canvas"></a>
    
  </div>
</div>
	<script src="<?php echo MAIN_FOLDER; ?>/js/vendor/jquery.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation.min.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation/foundation.offcanvas.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/vendor/fastclick.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/css/datepicker/jquery-ui.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/jquery.transform2d.js"></script>
	<script>
		$(document).foundation();
		
		$(document).ready(function(){
			$('a.left-off-canvas-toggle').click(function() {
  				$('.inner-wrap').css('min-height', $(window).height() - $('footer').outerHeight() + 'px');
			});
		})
	</script>
</body>
</html>