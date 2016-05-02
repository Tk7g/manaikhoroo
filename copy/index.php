<?php
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Mobile_Detect.php");
require_once(realpath(dirname(__FILE__))."/classes/Block.class.php");

$detect = new Mobile_Detect();

if($detect->isMobile()) {
	
	include(SITE_TEMPLATE."header.php");	
?>
<div id="homeMenu">
	<!--
	<a href="#" onClick='jQuery("#radial_container").radmenu("next")'> Rotate Menu Clockwise </a>
	<a href="#" onClick='jQuery("#radial_container").radmenu("prev")'> Rotate Menu Anti-Clockwise </a>
	<a href="#" onClick='jQuery("#radial_container").radmenu("shuffle")'> Shuffle Items in the Menu </a>
	<div class="row">
		<div class="small-12">
			<div id='radial_container'>
				<ul class='list'>
					<li class='item'>	<div class='my_class'>  0  </div>	</li>
					<li class='item'>	<div class='my_class'>  1  </div>	</li>
					<li class='item'>	<div class='my_class'>  2  </div>	</li>
					<li class='item'>	<div class='my_class'>  3  </div>	</li>
					<li class='item'>	<div class='my_class'>  4  </div>	</li>
					<li class='item'>	<div class='my_class'>  5  </div>	</li>
				</ul>
			</div>
		</div>
	</div>-->
	<div id="circleMenu">
		<div class="row">
			<div class="small-11 small-centered columns">
				<div class="rotatedMenu">
				</div>
				<div class="rotateMenuBlock">
					<a href="<?php echo SITE_URL; ?>order.php" class="center">Захиалга хийх</a>
					<a href="#" link="<?php echo SITE_URL; ?>mobile.php" data="Камерын систем" class="rotated1 rotateMenu"><img src="<?php echo MAIN_FOLDER; ?>/css/images/camera-icon.png" /></a>
					<a href="#" link="<?php echo SITE_URL; ?>mobile.php" data="Богино холбооны систем" class="rotated2 rotateMenu"><img src="<?php echo MAIN_FOLDER; ?>/css/images/light-icon.png" /></a>
					<a href="#" link="<?php echo SITE_URL; ?>order.php" data="Захиалга хийх" class="rotated3 rotateMenu"><img src="<?php echo MAIN_FOLDER; ?>/css/images/note-icon.png" /></a>
					<a href="#" link="<?php echo SITE_URL; ?>mobile.php" data="GPS - Хяналтын систем" class="rotated4 rotateMenu"><img src="<?php echo MAIN_FOLDER; ?>/css/images/gps-icon.png" /></a>
					<a href="#" link="<?php echo SITE_URL; ?>news.php?action=singleContent&id=17" data="Холбоо барих" class="rotated5 rotateMenu"><img src="<?php echo MAIN_FOLDER; ?>/css/images/contact-icon.png" /></a>
					<a href="#" link="<?php echo SITE_URL; ?>news.php" data="Мэдээ, мэдээлэл" class="rotated6 rotateMenu"><img src="<?php echo MAIN_FOLDER; ?>/css/images/news-icon.png" /></a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include(SITE_TEMPLATE.'mobile/footer-social.php'); ?>

<script>
	var obj = { "rotated1": 1, "rotated2": 2, "rotated3": 3, "rotated4": 4, "rotated5": 5, "rotated6": 6 };
	var rotateDegree = 0;
	var circleMenuWidth = $(".rotatedMenu").width();
	var circleMenuHeight = circleMenuWidth;
	
$(document).ready(function(){
	$(".rotatedMenu").css({"height":circleMenuHeight});
	$(".center").css({"height":circleMenuHeight*0.26, "width":circleMenuWidth*0.25, "top":circleMenuHeight*0.36, "left":circleMenuWidth*0.43, "padding-top":circleMenuHeight*0.08});
	$(".rotated1").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.06, "left":circleMenuWidth*0.45});
	$(".rotated2").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.23, "left":circleMenuWidth*0.78});
	$(".rotated3").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.59, "left":circleMenuWidth*0.79});
	$(".rotated4").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.77, "left":circleMenuWidth*0.47});
	$(".rotated5").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.6, "left":circleMenuWidth*0.15});
	$(".rotated6").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.24, "left":circleMenuWidth*0.15});
});

rotateMenu();

function rotateMenu() {
	$(".rotateMenu").click(function(){
		if($(this).attr("class") == "rotated1 rotateMenu") {
			var rot = 2;
			var rotateCircle = 2;
		}
		if($(this).attr("class") === "rotated2 rotateMenu") {
			var rot = 1;
			var rotateCircle = 1;
		}
		if($(this).attr("class") === "rotated3 rotateMenu") {
			var rot = 0;
			var rotateCircle = 0;
		}
		if($(this).attr("class") === "rotated4 rotateMenu") {
			var rot = 5;
			var rotateCircle = -1;
		}
		if($(this).attr("class") === "rotated5 rotateMenu") {
			var rot = 4;
			var rotateCircle = -2;
		}
		if($(this).attr("class") === "rotated6 rotateMenu") {
			var rot = 3;
			var rotateCircle = 3;
		}
		if(rotateDegree == 0) {
			rotateDegree = rotateCircle * 60;	
		} else {
			rotateDegree = rotateDegree + (rotateCircle * 60);
		}
		
		$(".rotatedMenu").css({"transform": "rotate("+rotateDegree+"deg)", "-o-transform": "rotate("+rotateDegree+"deg)", "-moz-transform":"rotate("+rotateDegree+"deg)", "-ms-transform": "rotate("+rotateDegree+"deg)"});
		
		for(i=1; i<=rot; i++) {
			$(".rotateMenu").each(function(){
			if($(this).attr("class") == "rotated1 rotateMenu") {
				var valPlus = 1;
			}
			if($(this).attr("class") === "rotated2 rotateMenu") {
				var valPlus = 2;
			}
			if($(this).attr("class") === "rotated3 rotateMenu") {
				var valPlus = 3;
			}
			if($(this).attr("class") === "rotated4 rotateMenu") {
				var valPlus = 4;
			}
			if($(this).attr("class") === "rotated5 rotateMenu") {
				var valPlus = 5;
			}
			if($(this).attr("class") === "rotated6 rotateMenu") {
				var valPlus = 6;
			}
			valPlus = valPlus + 1;
			if(valPlus === 7) {
				valPlus = 1;
			}
			$(this).removeClass().addClass("rotated"+valPlus).addClass("rotateMenu");
			});	
		}	
		
		$(".center").text($(this).attr("data"));
		$(".center").attr("href", $(this).attr("link"));
		
		$(".rotated1").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.06, "left":circleMenuWidth*0.45});
		$(".rotated2").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.23, "left":circleMenuWidth*0.78});
		$(".rotated3").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.59, "left":circleMenuWidth*0.79});
		$(".rotated4").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.77, "left":circleMenuWidth*0.47});
		$(".rotated5").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.6, "left":circleMenuWidth*0.15});
		$(".rotated6").css({"width":circleMenuWidth*0.17, "height":circleMenuHeight*0.2, "top":circleMenuHeight*0.24, "left":circleMenuWidth*0.15});
		
	});
}

</script>

<?php
	include(SITE_TEMPLATE."footer.php");
	
} else {
	include(WEB_TEMPLATE."header.php");
	
function blockType($type_id) {
	switch ( $type_id ) {
		case 1:
			$block_class = 'yellow_block';
			break;
	}
	return $block_class;
}
	
	include(WEB_TEMPLATE."home-content.php");	
	include(WEB_TEMPLATE."footer.php");
}
?>