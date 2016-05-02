<?php 

require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");

$results = Marker::markerCount($_POST['type']);
?>
<td class="check-info">
	<img src="<?php echo $results['image']; ?>" />
<?php echo $results['type']; ?>
</td>
<td><?php echo $results['COUNT(*)']; ?></td>