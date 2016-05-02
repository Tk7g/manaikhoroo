<div id="sideMenu">
	<ul>
		<li>
			<a href="index.php">Удирдлагын хэсэг</a>
		</li>
		<?php if($_SESSION['login']['group_id'] == 1) { ?>
		<li>
			<a href="order.php">Гэрээт захиалгууд</a>
		</li>
		<li>
			<a href="directOrder.php">Гэрээт бус захиалгууд</a>
		</li>
		<li>
			<a href="order.php?action=orderYearReport">Захиалгын тайлан</a>
		</li>
		<li>
			<a href="order.php?action=orderGraphReport">График тайлан /сараар/</a>
		</li>
		<li>
			<a href="order.php?action=orderDateGraphReport">График тайлан /өдрөөр/</a>
		</li>
		<li>
			<a href="order.php?action=orderRevenueReport">Орлогын тайлан</a>
		</li>
		<li>
			<a href="company.php">Гэрээт компаниуд</a>
		</li>
		<li>
			<a href="news.php">Мэдээ</a>
		</li>
		<li>
			<a href="product.php">Бүтээгдэхүүний төрөл</a>
		</li>
		<li>
			<a href="position.php">Албан тушаал</a>
		</li>
		<li>
			<a href="user.php">Системийн хэрэглэгчид</a>
		</li>
		<?php } elseif($_SESSION['login']['group_id'] == 2) { ?>
		<li>
			<a href="order.php?action=orderManager">Гэрээт захиалгууд</a>
		</li>
		<li>
			<a href="directOrder.php?action=orderManager">Гэрээт бус захиалгууд</a>
		</li>
		<li>
			<a href="company.php">Гэрээт компаниуд</a>
		</li>
		<li>
			<a href="news.php">Мэдээ</a>
		</li>
		<li>
			<a href="product.php">Бүтээгдэхүүний төрөл</a>
		</li>
		<li>
			<a href="position.php">Албан тушаал</a>
		</li>
		<li>
			<a href="user.php">Системийн хэрэглэгчид</a>
		</li>
		<?php } elseif($_SESSION['login']['group_id'] == 3) { ?>
		<li>
			<a href="order.php?action=orderFactory">Гэрээт захиалгууд</a>
		</li>
		<li>
			<a href="directOrder.php?action=orderFactory">Гэрээт бус захиалгууд</a>
		</li>
		<?php } ?>
	</ul>
</div>