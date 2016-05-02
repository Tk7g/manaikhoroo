<?php
require_once(realpath(dirname(__FILE__))."/../../../classes/Message.class.php");
?>

<div class="nav-collapse sidebar-nav">
	<ul class="nav nav-tabs nav-stacked main-menu">
		<li><a href="<?php echo '/dashboard/index.php?action=home'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Удирдлагын хэсэг</span></a></li>
<?php if($_SESSION['login']['group_id'] == 1) { ?>
		<li><a href="<?php echo '/dashboard/user.php'; ?>"><i class="icon-user"></i><span class="hidden-tablet"> Хэрэглэгчид</span></a></li>
		<li><a href="<?php echo '/dashboard/markers.php?action=adminMarkers'; ?>"><i class="icon-map-marker"></i><span class="hidden-tablet"> Зурган тэмдэглэгээ</span></a></li>
		<li><a href="<?php echo '/dashboard/markers.php?action=markerHistory&page=1'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Зурган тэмдэглэгээний түүх</span></a></li>
		<li><a href="<?php echo '/dashboard/sanal.php?action=sanalList'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Иргэдээс ирүүлсэн санал хүсэлт</span></a></li>
		<li><a href="<?php echo '/dashboard/sanal.php?action=sanalStat'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Санал хүсэлтүүдийн статистик</span></a></li>
		<li><a target="_blank" href="http://manaikhoroo.ub.gov.mn/stat/?"><i class="icon-asterisk"></i><span class="hidden-tablet"> Вэб Статистик</span></a></li>
		<li><a href="<?php echo '/dashboard/articles.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Мэдээ</span></a></li>
		<li><a href="<?php echo '/dashboard/link.php'; ?>"><i class="icon-signin"></i><span class="hidden-tablet"> Холбоос</span></a></li>
		<li><a href="<?php echo '/dashboard/faq.php'; ?>"><i class="icon-tasks"></i><span class="hidden-tablet"> Заавар</span></a></li>
		<li><a href="<?php echo '/dashboard/section.php'; ?>"><i class="icon-minus"></i><span class="hidden-tablet"> Хэсгийн хил</span></a></li>
		<li><a href="<?php echo '/dashboard/menu.php'; ?>"><i class="icon-sitemap"></i><span class="hidden-tablet"> Үндсэн цэс</span></a></li>
		<li><a href="<?php echo '/dashboard/year.php'; ?>"><i class="icon-asterisk"></i><span class="hidden-tablet"> Он</span></a></li>
		<li><a href="<?php echo '/dashboard/types.php'; ?>"><i class="icon-asterisk"></i><span class="hidden-tablet"> Индикатор</span></a></li>
		<li><a href="<?php echo '/dashboard/message.php?action=adminList'; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet"> Явуулсан мессеж</span></a></li>
		
<?php
$new_messages = Message::getAdminNewInboxMessages();
?>
		<li><a href="<?php echo '/dashboard/message.php?action=adminInbox'; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet"> Ирсэн Мессеж</span><span class="newMessageIcon"><?php echo $new_messages['COUNT(*)']; ?></span></a></li>
		
<?php } elseif($_SESSION['login']['group_id'] == 2) { ?>
<li><a href="<?php echo '/dashboard/markers.php'; ?>"><i class="icon-map-marker"></i><span class="hidden-tablet"> Зурган тэмдэглэгээ</span></a></li>
<li><a href="<?php echo '/dashboard/user.php?action=listDistrict'; ?>"><i class="icon-map-marker"></i><span class="hidden-tablet"> Хэрэглэгчид</span></a></li>
<li><a href="<?php echo '/dashboard/section.php?action=regionSelect'; ?>"><i class="icon-map-marker"></i><span class="hidden-tablet"> Хороодын хэсгийн хил</span></a></li>
<li><a href="<?php echo '/dashboard/markers.php?action=districtMarkerHistory&district='.$_SESSION['login']['district_id'].'&type=1'; ?>"><i class="icon-map-marker"></i><span class="hidden-tablet"> Зурган тэмдэглэгээний түүх</span></a></li>
<!--<li><a href="<?php echo '/dashboard/sanal.php?action=notClosedList'; ?>"><i class="icon-envelope-alt"></i><span class="hidden-tablet"> Нээлттэй санал хүсэлт</span></a></li>
<li><a href="<?php echo '/dashboard/sanal.php?action=closedList'; ?>"><i class="icon-envelope"></i><span class="hidden-tablet"> Хариу өгсөн санал хүсэлт</span></a></li>-->
<li><a href="<?php echo '/dashboard/markers.php?action=civDistrictMarker&district='.$_SESSION['login']['district_id']; ?>"><i class="icon-star"></i><span class="hidden-tablet"> Иргэдээс ирүүлсэн зурган тэмдэглэгээ</span></a></li>
<li><a href="<?php echo '/dashboard/markers.php?action=civDistrictMarkerAccepted&district='.$_SESSION['login']['district_id']; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet">  Зөвшөөрсөн зурган тэмдэглэгээ</span></a></li>

<li><a href="<?php echo '/dashboard/message.php?action=districtList'; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet"> Явсан мессеж</span></a></li>
<?php
$new_messages = Message::getDistrictNewInboxMessages($_SESSION['login']['district_id']);
?>
<li><a href="<?php echo '/dashboard/message.php?action=districtInbox'; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet"> Ирсэн мессеж</span><span class="newMessageIcon"><?php echo $new_messages['COUNT(*)']; ?></span></a></li>

<li><a href="<?php echo 'https://docs.google.com/forms/d/12sKTQErqLqypEQO2bczRtAwEUIMGQlMQHw4txUfWTig/viewform'; ?>" target="_blank"><i class="icon-star-empty"></i><span class="hidden-tablet"> Санал асуулга</span></a></li>
<?php } elseif($_SESSION['login']['group_id'] == 3) { ?>
<li><a href="<?php echo '/dashboard/markers.php?action=markerRegion'; ?>"><i class="icon-map-marker"></i><span class="hidden-tablet"> Зурган тэмдэглэгээ</span></a></li>
<li><a href="<?php echo '/dashboard/section.php?action=sectionListRegion&district='.$_SESSION['login']['district_id'].'&region='.$_SESSION['login']['region_id']; ?>"><i class="icon-map-marker"></i><span class="hidden-tablet"> Хэсгийн хил</span></a></li>
<li><a href="<?php echo '/dashboard/infos.php'; ?>"><i class="icon-tasks"></i><span class="hidden-tablet"> Тоон мэдээлэл</span></a></li>
<!--<li><a href="<?php echo '/dashboard/road.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Замын зураглал</span></a></li>-->
<li><a href="<?php echo '/dashboard/playground.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Ногоон байгууламж</span></a></li>
<li><a href="<?php echo '/dashboard/torongarts.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Торон гарц</span></a></li>
<li><a href="<?php echo '/dashboard/earthground.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Сул шороон хөрстэй талбай</span></a></li>
<li><a href="<?php echo '/dashboard/risks.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Үерийн аюултай бүс</span></a></li>
<li><a href="<?php echo '/dashboard/crosswalk.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Авто замын гарц гаргах боломжит газар</span></a></li>
<li><a href="<?php echo '/dashboard/road.php'; ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Зам</span></a></li>
<!--<li><a href="<?php echo '/dashboard/sanal.php'; ?>"><i class="icon-envelope-alt"></i><span class="hidden-tablet"> Нээллтэй санал хүсэлт</span></a></li>
<li><a href="<?php echo '/dashboard/sanal.php?action=closedRegion'; ?>"><i class="icon-envelope"></i><span class="hidden-tablet"> Хариу өгсөн санал хүсэлт</span></a></li>-->
<li><a href="<?php echo '/dashboard/markers.php?action=civRegionMarker&region='.$_SESSION['login']['region_id']; ?>"><i class="icon-star"></i><span class="hidden-tablet"> Иргэдээс ирүүлсэн зурган тэмдэглэгээ</span></a></li>
<li><a href="<?php echo '/dashboard/markers.php?action=civRegionMarkerAccepted&region='.$_SESSION['login']['region_id']; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet"> Зөвшөөрсөн зурган тэмдэглэгээ</span></a></li>
<li><a href="<?php echo '/dashboard/message.php?action=regionList'; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet"> Явуулсан мессеж</span></a></li>
<?php
$new_messages = Message::getRegionNewInboxMessages($_SESSION['login']['region_id']);
?>
<li><a href="<?php echo '/dashboard/message.php?action=regionInbox'; ?>"><i class="icon-star-empty"></i><span class="hidden-tablet"> Ирсэн мессеж</span><span class="newMessageIcon"><?php echo $new_messages['COUNT(*)']; ?></span></a></li>

<li><a href="<?php echo 'https://docs.google.com/forms/d/12sKTQErqLqypEQO2bczRtAwEUIMGQlMQHw4txUfWTig/viewform'; ?>" target="_blank"><i class="icon-star-empty"></i><span class="hidden-tablet"> Санал асуулга</span></a></li>
<?php } ?>
	</ul>
</div>