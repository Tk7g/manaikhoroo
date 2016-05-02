
			</div>
		</div>
	</div>
	<script src="<?php echo MAIN_FOLDER; ?>/js/vendor/jquery.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation.min.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation/foundation.offcanvas.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/vendor/fastclick.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/js/foundation/foundation.alert.js"></script>
	<script src="<?php echo MAIN_FOLDER; ?>/css/datepicker/jquery-ui.js"></script>
	
	<script>
		$(document).foundation();
		$(document).ready(function(){
    		$("#sideMenu").height( $("#adminMain").height() - 55 );
    		$("#mainComponent").height( $("#adminMain").height() - 55 );
		});
	</script>
</body>
</html>