<?php
//error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Link.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Article.class.php");
require_once(realpath(dirname(__FILE__))."/classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Year.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Risks.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Playground.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Report.class.php");
include(SITE_TEMPLATE. "header.php");
?>
<div id="map-header">
<?php include(SITE_TEMPLATE. "map-header.php"); ?>
</div>
<div id="header">
<?php include(SITE_TEMPLATE. "top.php"); ?>
</div>
<!--<div id="ub-map">
	<?php include(SITE_TEMPLATE. "maphome.php"); ?>
</div>-->
<div id="news-block">
	<?php include(SITE_TEMPLATE. "news-block.php") ?>
</div>
<?php
include(SITE_TEMPLATE. "footer.php");
?>
