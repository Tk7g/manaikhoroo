<div class="container">
	<div class="row">	
		<div class="col-md-12">
			<div class="district-hover">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9">
			<div id="bagakhangai">
			 	<a class="svg-link" href="indicator.php?action=regionView&district=2">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/bagakhangai.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="baganuur">
				<a class="svg-link" href="indicator.php?action=regionView&district=1">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/baganuur.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="bayangol">
				<a class="svg-link" href="indicator.php?action=regionView&district=3">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/bayangol.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="bayanzurkh">
				<a class="svg-link" href="indicator.php?action=regionView&district=4">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/bayanzurkh.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="chingeltei">
				<a class="svg-link" href="indicator.php?action=regionView&district=9">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/chingeltei.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="khanuul">
				<a class="svg-link" href="indicator.php?action=regionView&district=8">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/khanuul.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="nalaikh">
				<a class="svg-link" href="indicator.php?action=regionView&district=5">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/nalaikh.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="songinokhairkhan">
				<a class="svg-link" href="indicator.php?action=regionView&district=6">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/songinokhairkhan.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
			<div id="sukhbaatar">
				<a class="svg-link" href="indicator.php?action=regionView&district=7">
					<object type="image/svg+xml" data="<?php echo MAIN_FOLDER.'/map/sukhbaatar.svg'; ?>">Your browser does not support SVG</object>
				</a>
			</div>
		</div>
		<div class="col-md-3" id="infohome">
			<?php 
				$info = new Info;
				$city_info = $info->getCityInfo();
			?>
			<div class="svg-box" id="svg-infobox">
				<div class="svg-box-title">
					Улаанбаатар хот
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/population.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Нийт хүн ам
								</div>
								<div class="svg-info-num">
									<?php echo number_format($city_info['info']['population']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/area.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Газар нутгийн хэмжээ
								</div>
								<div class="svg-info-num">
									<?php echo number_format($city_info['info']['area_length']).' га'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/household.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Нийт өрхийн тоо
								</div>
								<div class="svg-info-num">
									<?php echo number_format($city_info['info']['household']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/pop-density.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Хүн амын нягтаршил
								</div>
								<div class="svg-info-num">
									<?php echo number_format($city_info['info']['population_density']).' хүн/га'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){
	$("#bagakhangai").mouseover(function(){
		$(".district-hover").text("Багахангай");
		$.ajax({url:"home_info.php?district=2", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#bagakhangai").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#baganuur").mouseover(function(){
		$(".district-hover").text("Багануур");
		$.ajax({url:"home_info.php?district=1", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#baganuur").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#bayangol").mouseover(function(){
		$(".district-hover").text("Баянгол");
		$.ajax({url:"home_info.php?district=3", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#bayangol").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#bayanzurkh").mouseover(function(){
		$(".district-hover").text("Баянзүрх");
		$.ajax({url:"home_info.php?district=4", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#bayanzurkh").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#chingeltei").mouseover(function(){
		$(".district-hover").text("Чингэлтэй");
		$.ajax({url:"home_info.php?district=9", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#chingeltei").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#khanuul").mouseover(function(){
		$(".district-hover").text("Хан-Уул");
		$.ajax({url:"home_info.php?district=8", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#khanuul").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#nalaikh").mouseover(function(){
		$(".district-hover").text("Налайх");
		$.ajax({url:"home_info.php?district=5", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#nalaikh").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#songinokhairkhan").mouseover(function(){
		$(".district-hover").text("Сонгинохайрхан");
		$.ajax({url:"home_info.php?district=6", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#songinokhairkhan").mouseout(function(){
		$(".district-hover").text("");
	});
	$("#sukhbaatar").mouseover(function(){
		$(".district-hover").text("Сүхбаатар");
		$.ajax({url:"home_info.php?district=7", success:function (result) {
			   $("#svg-infobox").html(result);
		}});
	});
	$("#sukhbaatar").mouseout(function(){
		$(".district-hover").text("");
	});
});
</script>