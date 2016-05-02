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
					Ulaanbaatar City
				</div>
				<div class="ubit-desc">
					Mayor's Office
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
					City Governmence executive agency
				</div>
				<div class="ubit-desc">
					Information Technology Department
				</div>
			</div>
		</div>
	</div>
</div>
		</div>
		<div class="col-md-2">
			<div class="footer-menu-box">
				<div class="footer-menu-ttl">
					Main menu
				</div>
				<div class="footer-menu-list">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="indicator.php">Districts</a></li>
						<li><a href="news.php?page=info&id=7">About us</a></li>
						<li><a href="news.php">News</a></li>
						<li><a href="user.php?page=sanalAdd">Feedback, Comments</a></li>
						<li><a href="news.php?page=info&id=9">Contact us</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="footer-menu-box">
				<div class="footer-menu-ttl">
					Districts
				</div>
				<div class="footer-menu-list">
					<ul>
						<li><a href="/en/indicator.php?action=regionView&district=1">Baganuur</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=2">Bagakhangai</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=3">Bayngol</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=4">Baynzurkh</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=5">Nalaikh</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=6">Songinokhairkhan</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=7">Sukhbaatar</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=8">Khan-Uul</a></li>
						<li><a href="/en/indicator.php?action=regionView&district=9">Chingeltei</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="footer-menu-box">
				<div class="footer-menu-ttl">
					Link
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