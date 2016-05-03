<?php
require_once(realpath(dirname(__FILE__))."/../../classes/Menu.class.php");
?>
	<ul>
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
		?>
		<li>
			<a href="<?php if($parent['additional'] == NULL) { echo $components[$parent['component']]; } else { echo $components[$parent['component']].''.$parent['additional']; } ?>">
			<img src="<?php if($parent['image'] != NULL) { echo ROOT_FOLDER.'/menu/'.$parent['image']; } ?>" />
				<div><?php echo $parent['title']; ?></div>
			</a>
		</li>
		<?php
			endforeach;
		?>
	</ul>