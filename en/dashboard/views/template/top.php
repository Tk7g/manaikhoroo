	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="index.html"><span>Удирдлагын хэсэг</span></a>
			
			<!-- Header Menu -->
			<div class="nav-no-collapse header-nav">
				<ul class="nav pull-right">
					<li>
						<a class="btn" href="#">
							<i class="halflings-icon white wrench"></i>
						</a>
					</li>
					<!-- User Dropdown -->
					<li class="dropdown">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="halflings-icon white user"></i> <?php echo substr($_SESSION['login']['lastname'],0,2).'.'.$_SESSION['login']['firstnama']; ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown-menu-title">
 								<span>Хэрэглэгчийн хэсэг</span>
							</li>
							<!--<li><a href="#"><i class="halflings-icon user"></i> Таны мэдээлэл</a></li>-->
							<li><a href="user.php?action=passChange"><i class="halflings-icon refresh"></i> Нууц үг солих</a></li>
							<li><a href="index.php?action=logout"><i class="halflings-icon off"></i> Гарах линк</a></li>
						</ul>
					</li>
					<!-- User Dropdown -->
				</ul>
			</div>
			<!-- Header Menu -->
			
		</div>
	</div>