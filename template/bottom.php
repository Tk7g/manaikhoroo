<div class="container">
	<div class="row">
		<div class="col-md-5">
			<div class="footer-logo">
	<div class="site-logo">
		<div class="row">
			<div class="col-md-2">
				<img src="<?php echo IMG_FOLDER.'icons/logo_icon.png'; ?>" class="img-responsive" />
			</div>
			<div class="col-md-10">
				<div class="zaa-ttl">
					Улаанбаатар хотын
				</div>
				<div class="ubit-desc">
					Захирагчийн ажлын алба
				</div>
			</div>
		</div>
	</div>
	<div class="ubit-logo">
		<div class="row">
			<div class="col-md-2">
				<img src="<?php echo IMG_FOLDER.'icons/taf.png'; ?>" class="img-responsive" />
			</div>
			<div class="col-md-10">
				<div class="site-logo-ttl">
					THE ASIA FOUNDATION
				</div>
				<div class="site-logo-desc">
					Азийн сан
				</div>
			</div>
		</div>
	</div>
	<div class="ubit-logo">	
		<div class="row">
			<div class="col-md-2">
				<img src="<?php echo IMG_FOLDER.'icons/ubit.png'; ?>" class="img-responsive" />
			</div>
			<div class="col-md-10">
				<div class="ubit-ttl">
					Нийслэлийн засаг даргын хэрэгжүүлэгч агентлаг
				</div>
				<div class="ubit-desc">
					Мэдээллийн Технологийн Газар
				</div>
			</div>
		</div>
	</div>
</div>
		</div>
		<div class="col-md-2">
			<div class="footer-menu-box">
				<div class="footer-menu-ttl">
					Үндсэн цэс
				</div>
				<div class="footer-menu-list">
					<ul>
						<li><a href="index.php">Нүүр</a></li>
						<li><a href="indicator.php">Дүүрэг</a></li>
						<li><a href="news.php?page=info&id=7">Бидний тухай</a></li>
						<li><a href="news.php">Мэдээ</a></li>
						<li><a href="user.php?page=sanalAdd">Санал хүсэлт</a></li>
						<li><a href="news.php?page=info&id=9">Холбоо барих</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="footer-menu-box">
				<div class="footer-menu-ttl">
					Дүүрэг
				</div>
				<div class="footer-menu-list">
					<ul>
						<li><a href="/indicator.php?action=regionView&district=1">Багануур</a></li>
						<li><a href="/indicator.php?action=regionView&district=2">Багахангай</a></li>
						<li><a href="/indicator.php?action=regionView&district=3">Баянгол</a></li>
						<li><a href="/indicator.php?action=regionView&district=4">Баянзүрх</a></li>
						<li><a href="/indicator.php?action=regionView&district=5">Налайх</a></li>
						<li><a href="/indicator.php?action=regionView&district=6">Сонгинохайрхан</a></li>
						<li><a href="/indicator.php?action=regionView&district=7">Сүхбаатар</a></li>
						<li><a href="/indicator.php?action=regionView&district=8">Хан-Уул</a></li>
						<li><a href="/indicator.php?action=regionView&district=9">Чингэлтэй</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="footer-menu-box">
				<div class="footer-menu-ttl">
					Холбоос
				</div>
				<div class="footer-menu-list">
				<?php
					$links = Link::getList();   
				?>
					<ul>
						<?php foreach($links as $link) : ?>
						<li><a href="<?php echo $link['link']; ?>"><?php echo $link['title']; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>