<div class="profile-header">Таны мэдээлэл</div>
<div class="user-profile">
	<div class="user-info"><?php echo substr($_SESSION['login']['lastname'], 0, 2).'.'.$_SESSION['login']['firstname']; ?></div>
	<div class="user-info">Регистрийн №: <?php echo $_SESSION['login']['identity']; ?></div>
	<div class="user-info"><a href="user.php?page=passChange">Нууц үг солих</a></div>
	<div class="user-info"><a href="user.php?page=logout">Системээс гарах</a></div>
</div>
<div class="user-menu">
	<ul>
		<li><a href="user.php?page=home">Эхлэл</a></li>
		<li><a href="user.php?page=write">Санал хүсэлт бичих</a></li>
		<li><a href="user.php?page=sentlist">Миний илгээсэн санал хүсэлтүүд</a></li>
		<li><a href="user.php?page=select">Газрын зургын тэмдэглэгээ нэмэх</a></li>
		<li><a href="user.php?page=myMarker">Миний илгээсэн зурган тэмдэглэгээ</a></li>
	</ul>
</div>