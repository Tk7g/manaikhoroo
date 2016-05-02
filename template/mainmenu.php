<?php
require_once(realpath(dirname(__FILE__))."/../classes/Menu.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
include(ADMIN_TEMPLATE."session_check.php"); 
session_start();
?>
<div id="mainmenu" >
	<ul class="nav navbar-nav nav-fixed-top" role="navigation">
		<?php 
			$components = array(
				1 => 'index.php',
				2 => 'indicator.php',
				3 => 'indicator.php?action=regionView&district=',
				4 => 'report.php',
				5 => 'news.php',
				6 => 'news.php?page=info&id=',
				7 => 'user.php?page=sanalAdd',
				8 => 'dashboard/index.php'
			);
			$parents = Menu::getParents(); 
			foreach($parents as $parent) :
			$subs = Menu::getSubs($parent['id']);
		?>
		<li <?php if($subs != NULL) { echo 'id="dropdown-list"'; } ?>>
			<a href="<?php if($parent['additional'] == NULL) { echo $components[$parent['component']]; } else { echo $components[$parent['component']].''.$parent['additional']; } ?>">
			<i><img src="<?php if($parent['image'] != NULL) { echo ROOT_FOLDER.'/menu/'.$parent['image']; } ?>" /></i>
				<?php echo $parent['title']; ?>
			</a>
			<?php 
				if($subs != NULL) { 
			?>
			<ul class="dropdown-list" role="menu">
				<?php 
					foreach($subs as $sub) :
				?>
				<li><a href="<?php if($sub['additional'] == NULL) { echo $components[$sub['component']]; } else { echo $components[$sub['component']].''.$sub['additional']; } ?>"><?php echo $sub['title']; ?></a></li>
			<?php
					endforeach; 
			?>
			</ul>
			<?php
				} 
			?>
		</li>
		<?php
			endforeach;
		?>
		<?php if($_SESSION != NULL) {?>
		<li id="dropdown-list1">
			<a href="#">
				<i><img src="/webroot/icons/user-icon.png"/></i>
				<?php echo $_SESSION['login']['username']; ?>
			</a>
			<ul class="dropdown-list1" role="menu">
				<li><a href="user.php?page=passChange"><i class="glyphicon glyphicon-refresh"></i> Нууц үг солих</a></li>
				<li><a href="user.php?page=logout"><i class="glyphicon glyphicon-off"></i> Гарах</a></li>
			</ul>
		</li>
		<?php } ?>
                <li id="dropdown-list2">
		<a href="http://manaikhoroo.ub.gov.mn/en/index.php">
			<i><img src="/webroot/menu/151_20150330195911.png"></i>ENGLISH
		</a>
		
		</li>
	</ul>
</div>

<script>

$(document).ready(function(){
	$("#dropdown-list").mouseover(function() {
		$(".dropdown-list").show();
	});
	$("#dropdown-list").mouseout(function() {
		$(".dropdown-list").hide();
	});
	$("#dropdown-list1").mouseover(function() {
		$(".dropdown-list1").show();
	});
	$("#dropdown-list1").mouseout(function() {
		$(".dropdown-list1").hide();
	});
});

</script>